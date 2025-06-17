<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JiQuiz - Tes Gaya Belajar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav id="navbar" class="fixed top-0 left-0 w-full bg-white shadow-md transition-all duration-300">
        <div class="flex justify-between items-center px-10 py-4">
            <h1 class="text-2xl font-bold text-blue-600">GayaBelajar<span>KU</span></h1>
            <ul class="flex space-x-6 text-gray-600">
                <li>
                    @auth
                    <div class="relative">
                        <button id="dropdownButton" class="font-semibold text-blue-600">
                            {{ auth()->user()->name }}
                        </button>
                        <div id="dropdownMenu" class="absolute hidden bg-white shadow-md mt-2 right-0 min-w-[150px] rounded-lg overflow-visible">
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="border-2 font-semibold border-blue-600 text-blue-600 px-6 py-1 rounded-2xl transition duration-300 hover:bg-blue-600 hover:text-white">
                        Login
                    </a>
                    @endauth
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mx-auto py-8 px-4 mt-20">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Tes Gaya Belajar</h2>
                <div class="bg-blue-600 text-white px-4 py-1 rounded-full text-sm" id="pageIndicator">
                    Halaman 1
                </div>
            </div>

            <div class="w-full bg-gray-200 h-2 rounded-full mb-6">
                <div id="progressBar" class="bg-blue-600 h-2 rounded-full" style="width: 16.67%"></div>
            </div>

            <div class="bg-purple-100 p-3 rounded-md mb-8 text-sm text-center">
                Pilih salah satu jawaban yang sesuai dengan tingkat kecocokan berdasarkan kondisimu saat ini
            </div>

            @php $questionNumber = 1; @endphp
            <form id="quizForm" method="POST" action="{{ route('quiz.submit') }}">
                @csrf
                <div id="pagesContainer">
                    @foreach ($questions->chunk(8) as $pageIndex => $questionPage)
                    <div class="quiz-page {{ $pageIndex == 0 ? '' : 'hidden' }}" data-page="{{ $pageIndex + 1 }}"
                        data-type="{{ $questionPage->first()->type }}">
                        @foreach ($questionPage as $index => $question)
                        <div class="mb-6 pb-4 border-b border-gray-200">
                            <p class="mb-3">
                                <span class="font-medium">{{ $questionNumber++ }}.</span>
                                {{ $question->question_text }}
                            </p>

                            <input type="hidden" name="answers[{{ $question->id }}][question_id]" value="{{ $question->id }}">

                            <div class="space-y-2">
                                <label class="flex items-center justify-between p-3 border border-gray-200 rounded-md bg-white transition-all">
                                    <span>Ya</span>
                                    <input type="radio" name="answers[{{ $question->id }}][score]" value="{{ $question->is_favoritable ? 0 : 1 }}" class="w-4 h-4 text-blue-600" required>
                                </label>

                                <label class="flex items-center justify-between p-3 border border-gray-200 rounded-md bg-white transition-all">
                                    <span>Tidak</span>
                                    <input type="radio" name="answers[{{ $question->id }}][score]" value="{{ $question->is_favoritable ? 1 : 0 }}" class="w-4 h-4 text-blue-600">
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>

                <div class="flex justify-between mt-10">
                    <button type="button" id="backBtn" class="flex items-center text-gray-600 px-4 py-2 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back
                    </button>
                    <div class="flex space-x-4">
                        <button type="button" id="nextBtn" class="flex items-center text-gray-600 px-4 py-2 rounded opacity-50 cursor-not-allowed" disabled>
                            Next
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        <button type="submit" id="finishBtn" class="hidden bg-blue-600 text-white px-8 py-2 rounded-full">
                            Selesai
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const backBtn = document.getElementById('backBtn');
            const nextBtn = document.getElementById('nextBtn');
            const finishBtn = document.getElementById('finishBtn');
            let currentPage = 1;
            const totalPages = document.querySelectorAll('.quiz-page').length;

            function checkAnswers() {
                const currentQuestions = document.querySelector(`.quiz-page[data-page="${currentPage}"]`);
                const allInputs = currentQuestions.querySelectorAll('input[type="radio"]');
                const totalQuestions = new Set([...allInputs].map(input => input.name)).size;
                const answeredQuestions = new Set([...allInputs].filter(input => input.checked).map(input => input.name)).size;

                if (answeredQuestions === totalQuestions) {
                    nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    nextBtn.disabled = false;
                } else {
                    nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    nextBtn.disabled = true;
                }
            }

            function updateRadioHighlights() {
                const pages = document.querySelectorAll('.quiz-page');

                pages.forEach(page => {
                    const groups = new Set([...page.querySelectorAll('input[type="radio"]')].map(radio => radio.name));
                    groups.forEach(groupName => {
                        const radios = page.querySelectorAll(`input[name="${groupName}"]`);
                        radios.forEach(radio => {
                            const label = radio.closest('label');
                            if (label) {
                                label.classList.remove('border-blue-500', 'ring-2', 'ring-blue-300', 'shadow-blue-200');
                                if (radio.checked) {
                                    label.classList.add('border-blue-500', 'ring-2', 'ring-blue-300', 'shadow-blue-200');
                                }
                            }
                        });
                    });
                });
            }

            function showPage(pageNumber) {
                document.querySelectorAll('.quiz-page').forEach(page => {
                    page.classList.toggle('hidden', parseInt(page.dataset.page) !== pageNumber);
                });

                document.getElementById('pageIndicator').textContent = `Halaman ${pageNumber}`;
                const progressBar = document.getElementById('progressBar');
                const progressPercent = (pageNumber / totalPages) * 100;
                progressBar.style.width = `${progressPercent}%`;

                if (pageNumber === totalPages) {
                    finishBtn.classList.remove('hidden');
                    nextBtn.classList.add('hidden');
                } else {
                    finishBtn.classList.add('hidden');
                    nextBtn.classList.remove('hidden');
                }

                backBtn.disabled = pageNumber === 1;

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });

                checkAnswers();
                updateRadioHighlights();
            }

            nextBtn.addEventListener('click', function () {
                if (currentPage < totalPages) {
                    currentPage++;
                    showPage(currentPage);
                }
            });

            backBtn.addEventListener('click', function () {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                }
            });

            document.querySelectorAll('input[type="radio"]').forEach(input => {
                input.addEventListener('change', () => {
                    checkAnswers();
                    updateRadioHighlights();
                });
            });

            showPage(currentPage);
        });
    </script>
</body>

</html>
