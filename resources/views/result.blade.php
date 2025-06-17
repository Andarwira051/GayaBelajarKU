<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Tes Gaya Belajar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }

        .gradient-heading {
            background: linear-gradient(to right, #3b82f6, #2563eb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .circle-animation {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .circle-animation:hover {
            transform: scale(1.05);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 8px 10px -6px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>

<body class="bg-gradient-to-b from-blue-40 to-white min-h-screen flex items-center justify-center p-4 py-10">
    <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-lg max-w-3xl w-full mx-auto border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold mb-2">Hasil Tes Gaya Belajar</h1>
            <div class="flex justify-center items-center mt-4 mb-2">
                <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 flex items-center">
                    <i class="fas fa-calendar-alt text-gray-500 mr-2"></i>
                    <span class="text-gray-600 text-sm font-medium">
                        Tanggal Tes :
                        {{ \Carbon\Carbon::parse($test->created_at)->locale('id')->translatedFormat('d F Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Main result box -->
        <div
            class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-1 mb-8 shadow-lg transform transition-all duration-300 hover:scale-[1.01]">
            <div class="bg-white rounded-lg p-6">
                <div class="text-center py-4">
                    <div class="text-sm uppercase tracking-wider text-gray-500 font-medium mb-1">Gaya Belajar Dominan
                    </div>
                    <p id="predictedStyle" class="text-3xl font-bold text-blue-600">{{ $test->prediction }}</p>
                </div>
            </div>
        </div>

        <!-- Diagram lingkaran persentase untuk setiap gaya belajar -->
        <div class="mb-10">
            <h3 class="font-semibold text-gray-700 mb-6 text-center text-lg">Analisis Gaya Belajar Anda</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Visual -->
                <div id="visual-box" class="rounded-xl p-4 flex flex-col items-center card-hover">
                    <div id="visual-circle"
                        class="w-32 h-32 flex items-center justify-center rounded-full border-4 shadow-lg mb-2 circle-animation">
                        <div class="flex flex-col items-center">
                            <span id="visual-percentage" class="text-2xl font-bold">{{ $visualPercentage }}%</span>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <div class="p-2 rounded-full bg-blue-100 inline-block mb-2">
                            <i id="visual-icon" class="fas fa-eye text-xl"></i>
                        </div>
                        <h4 class="font-semibold">Visual</h4>
                        <p class="text-sm text-gray-600">{{ $test->visual_score }} poin</p>
                    </div>
                </div>

                <!-- Auditory -->
                <div id="auditory-box" class="rounded-xl p-4 flex flex-col items-center card-hover">
                    <div id="auditory-circle"
                        class="w-32 h-32 flex items-center justify-center rounded-full border-4 shadow-lg mb-2 circle-animation">
                        <div class="flex flex-col items-center">
                            <span id="auditory-percentage" class="text-2xl font-bold">{{ $auditoryPercentage }}%</span>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <div class="p-2 rounded-full bg-blue-100 inline-block mb-2">
                            <i id="auditory-icon" class="fas fa-ear-listen text-xl"></i>
                        </div>
                        <h4 class="font-semibold">Auditori</h4>
                        <p class="text-sm text-gray-600">{{ $test->auditory_score }} poin</p>
                    </div>
                </div>

                <!-- Kinesthetic -->
                <div id="kinesthetic-box" class="rounded-xl p-4 flex flex-col items-center card-hover">
                    <div id="kinesthetic-circle"
                        class="w-32 h-32 flex items-center justify-center rounded-full border-4 shadow-lg mb-2 circle-animation">
                        <div class="flex flex-col items-center">
                            <span id="kinesthetic-percentage"
                                class="text-2xl font-bold">{{ $kinestheticPercentage }}%</span>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <div class="p-2 rounded-full bg-blue-100 inline-block mb-2">
                            <i id="kinesthetic-icon" class="fas fa-person-walking text-xl"></i>
                        </div>
                        <h4 class="font-semibold">Kinestetik</h4>
                        <p class="text-sm text-gray-600">{{ $test->kinesthetic_score }} poin</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="descriptionText" class="mb-8 text-gray-600 bg-gray-50 p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center mb-3">
                <div class="p-2 rounded-full bg-blue-100 mr-3">
                    <i class="fas fa-lightbulb text-blue-500"></i>
                </div>
                <h3 class="font-semibold text-gray-700">Deskripsi Gaya Belajar</h3>
            </div>
            <p class="italic text-gray-500">Memuat deskripsi gaya belajar...</p>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl mb-8 shadow-sm border border-blue-100">
            <div class="flex items-center mb-4">
                <div class="p-2 rounded-full bg-blue-100 mr-3">
                    <i class="fas fa-check-circle text-blue-500"></i>
                </div>
                <h3 class="font-semibold text-gray-700">Rekomendasi Belajar</h3>
            </div>
            <ul id="recommendationsList" class="space-y-3 text-gray-600">
                <li class="flex items-start">
                    <span
                        class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-500 mr-2 mt-0.5">
                        <i class="fas fa-spinner fa-spin text-xs"></i>
                    </span>
                    <span>Memuat rekomendasi...</span>
                </li>
            </ul>
        </div>

        <div class="flex justify-center flex-wrap gap-4">
            <a href="{{ route('export.pdf', ['id' => $test->id, 'prediction' => $test->prediction]) }}"
                class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium py-3 px-6 rounded-lg transition-all shadow-md flex items-center">
                <i class="fas fa-file-pdf mr-2"></i> Export PDF
            </a>

            <a href="/"
                class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-all shadow-md flex items-center">
                <i class="fas fa-redo mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil nilai gaya belajar dominan dari #predictedStyle
            var predictedStyle = document.getElementById('predictedStyle').textContent.trim();

            console.log("Gaya belajar terdeteksi:", predictedStyle); // Debug untuk melihat nilai yang terdeteksi

            // Tentukan gaya belajar yang aktif
            var activeStyles = determineActiveStyles(predictedStyle);
            console.log("Gaya belajar aktif:", activeStyles);

            // Definisikan objek konfigurasi gaya belajar
            const styleConfigs = {
                "Visual": {
                    icon: "fa-eye",
                    color: "blue",
                    description: "Anda belajar lebih baik melalui gambar, grafik, dan representasi visual. Anda memiliki kemampuan baik dalam memahami informasi yang disajikan secara visual.",
                    recommendations: [
                        "Gunakan peta pikiran untuk merangkum materi",
                        "Tandai materi penting dengan warna berbeda",
                        "Gunakan ilustrasi dan diagram saat belajar",
                        "Tonton video pembelajaran terkait topik",
                        "Buat catatan dengan grafik dan gambar"
                    ]
                },
                "Auditori": {
                    icon: "fa-ear-listen",
                    color: "blue",
                    description: "Anda belajar lebih baik melalui mendengar dan diskusi. Informasi yang disampaikan secara lisan akan lebih mudah dipahami dan diingat.",
                    recommendations: [
                        "Rekam dan dengarkan kembali materi pelajaran",
                        "Diskusikan materi dengan teman atau kelompok belajar",
                        "Bacakan materi dengan suara keras",
                        "Dengarkan podcast atau audiobook tentang topik",
                        "Jelaskan konsep ke orang lain secara verbal"
                    ]
                },
                "Kinestetik": {
                    icon: "fa-person-walking",
                    color: "blue",
                    description: "Anda belajar lebih baik melalui aktivitas fisik dan pengalaman langsung. Anda perlu praktik dan gerakan untuk memahami informasi dengan baik.",
                    recommendations: [
                        "Praktikkan konsep melalui eksperimen langsung",
                        "Gunakan gerakan tubuh saat menghafal",
                        "Ambil jeda singkat untuk bergerak di antara sesi belajar",
                        "Buat model 3D atau alat peraga untuk konsep kompleks",
                        "Berlatihlah sambil berjalan atau bergerak"
                    ]
                }
            };

            // Kombinasi gaya belajar
            const combinedConfigs = {
                "Visual-Auditori": {
                    description: "Anda memiliki gaya belajar campuran Visual dan Auditori. Anda dapat memahami informasi dengan baik melalui gambar dan representasi visual serta melalui pendengaran dan diskusi. Kemampuan ini memberikan fleksibilitas dalam cara Anda belajar dan memproses informasi."
                },
                "Visual-Kinestetik": {
                    description: "Anda memiliki gaya belajar campuran Visual dan Kinestetik. Anda dapat memahami informasi dengan baik melalui gambar dan representasi visual serta melalui aktivitas fisik dan pengalaman langsung. Kombinasi ini membuat Anda efektif dalam belajar melalui demonstrasi visual yang disertai praktik langsung."
                },
                "Auditori-Kinestetik": {
                    description: "Anda memiliki gaya belajar campuran Auditori dan Kinestetik. Anda dapat memahami informasi dengan baik melalui pendengaran dan diskusi serta melalui aktivitas fisik dan pengalaman langsung. Kombinasi ini membuat Anda efektif dalam belajar melalui diskusi yang disertai dengan praktik atau gerakan."
                },
                "Visual-Auditori-Kinestetik": {
                    description: "Anda memiliki gaya belajar yang seimbang antara Visual, Auditori, dan Kinestetik. Ini adalah keunggulan yang memungkinkan Anda beradaptasi dengan berbagai metode pembelajaran. Anda dapat memahami informasi dengan baik melalui gambar, pendengaran, dan aktivitas fisik, yang memberikan fleksibilitas maksimal dalam proses belajar Anda."
                }
            };

            // Setup warna dan tampilan berdasarkan gaya belajar dominan
            setupLearningStyleBoxes(activeStyles);

            // Tampilkan deskripsi dan rekomendasi berdasarkan gaya belajar
            displayDescriptionAndRecommendations(activeStyles, styleConfigs, combinedConfigs);
        });

        // Fungsi untuk menentukan gaya belajar yang aktif dari prediksi
        function determineActiveStyles(prediction) {
            // Jika prediksi adalah gaya tunggal, kembalikan sebagai array dengan satu elemen
            if (prediction === 'Visual' || prediction === 'Auditori' || prediction === 'Kinestetik') {
                return [prediction];
            }

            // Jika prediksi berisi "-", berarti ini adalah kombinasi
            if (prediction.includes('-')) {
                return prediction.split('-');
            }

            // Jika prediksi berisi "dan", coba parsing lebih lanjut
            if (prediction.includes(' dan ')) {
                const styles = [];
                if (prediction.includes('Visual')) styles.push('Visual');
                if (prediction.includes('Auditori')) styles.push('Auditori');
                if (prediction.includes('Kinestetik')) styles.push('Kinestetik');
                return styles;
            }

            // Jika format prediksi tidak dikenal, kembalikan sebagai array tunggal
            return [prediction];
        }

        // Fungsi untuk mengatur warna dan tampilan kotak gaya belajar
        function setupLearningStyleBoxes(activeStyles) {
            // Elemen visual
            const visualBox = document.getElementById('visual-box');
            const visualCircle = document.getElementById('visual-circle');
            const visualPercentage = document.getElementById('visual-percentage');
            const visualIcon = document.getElementById('visual-icon');

            // Elemen auditory
            const auditoryBox = document.getElementById('auditory-box');
            const auditoryCircle = document.getElementById('auditory-circle');
            const auditoryPercentage = document.getElementById('auditory-percentage');
            const auditoryIcon = document.getElementById('auditory-icon');

            // Elemen kinesthetic
            const kinestheticBox = document.getElementById('kinesthetic-box');
            const kinestheticCircle = document.getElementById('kinesthetic-circle');
            const kinestheticPercentage = document.getElementById('kinesthetic-percentage');
            const kinestheticIcon = document.getElementById('kinesthetic-icon');

            // Reset semua ke warna abu-abu (default) dengan opacity rendah
            visualBox.className =
                "rounded-xl p-4 flex flex-col items-center bg-gray-100 opacity-50 transition-all duration-300 card-hover";
            visualCircle.className =
                "w-32 h-32 flex items-center justify-center rounded-full border-4 border-gray-300 shadow-md transition-all duration-300 circle-animation";
            visualPercentage.className = "text-2xl font-bold text-gray-400";
            visualIcon.className = "fas fa-eye text-gray-400";

            auditoryBox.className =
                "rounded-xl p-4 flex flex-col items-center bg-gray-100 opacity-50 transition-all duration-300 card-hover";
            auditoryCircle.className =
                "w-32 h-32 flex items-center justify-center rounded-full border-4 border-gray-300 shadow-md transition-all duration-300 circle-animation";
            auditoryPercentage.className = "text-2xl font-bold text-gray-400";
            auditoryIcon.className = "fas fa-ear-listen text-gray-400";

            kinestheticBox.className =
                "rounded-xl p-4 flex flex-col items-center bg-gray-100 opacity-50 transition-all duration-300 card-hover";
            kinestheticCircle.className =
                "w-32 h-32 flex items-center justify-center rounded-full border-4 border-gray-300 shadow-md transition-all duration-300 circle-animation";
            kinestheticPercentage.className = "text-2xl font-bold text-gray-400";
            kinestheticIcon.className = "fas fa-person-walking text-gray-400";

            console.log("Mengatur tampilan untuk gaya belajar:", activeStyles); // Debug

            // Set warna biru untuk gaya belajar aktif
            if (activeStyles.includes('Visual')) {
                visualBox.className =
                    "rounded-xl p-4 flex flex-col items-center bg-blue-50 opacity-100 transition-all duration-300 transform card-hover";
                visualCircle.className =
                    "w-32 h-32 flex items-center justify-center rounded-full border-4 border-blue-500 shadow-lg transition-all duration-300 circle-animation";
                visualPercentage.className = "text-2xl font-bold text-blue-600";
                visualIcon.className = "fas fa-eye text-blue-600";
            }

            if (activeStyles.includes('Auditori')) {
                auditoryBox.className =
                    "rounded-xl p-4 flex flex-col items-center bg-blue-50 opacity-100 transition-all duration-300 transform card-hover";
                auditoryCircle.className =
                    "w-32 h-32 flex items-center justify-center rounded-full border-4 border-blue-500 shadow-lg transition-all duration-300 circle-animation";
                auditoryPercentage.className = "text-2xl font-bold text-blue-600";
                auditoryIcon.className = "fas fa-ear-listen text-blue-600";
            }

            if (activeStyles.includes('Kinestetik')) {
                kinestheticBox.className =
                    "rounded-xl p-4 flex flex-col items-center bg-blue-50 opacity-100 transition-all duration-300 transform card-hover";
                kinestheticCircle.className =
                    "w-32 h-32 flex items-center justify-center rounded-full border-4 border-blue-500 shadow-lg transition-all duration-300 circle-animation";
                kinestheticPercentage.className = "text-2xl font-bold text-blue-600";
                kinestheticIcon.className = "fas fa-person-walking text-blue-600";
            }
        }

        // Fungsi untuk menampilkan deskripsi dan rekomendasi
        function displayDescriptionAndRecommendations(activeStyles, styleConfigs, combinedConfigs) {
            const descriptionEl = document.getElementById('descriptionText');
            const recommendationsEl = document.getElementById('recommendationsList');

            // Bersihkan elemen
            descriptionEl.innerHTML = `
                <div class="flex items-center mb-3">
                    <div class="p-2 rounded-full bg-blue-100 mr-3">
                        <i class="fas fa-lightbulb text-blue-500"></i>
                    </div>
                    <h3 class="font-semibold text-gray-700">Deskripsi Gaya Belajar</h3>
                </div>
            `;
            recommendationsEl.innerHTML = '';

            // Kasus untuk gaya belajar tunggal
            if (activeStyles.length === 1) {
                const styleName = activeStyles[0];
                const config = styleConfigs[styleName];

                if (config) {
                    // Tambahkan deskripsi
                    const paragraph = document.createElement('p');
                    paragraph.className = "text-gray-600 leading-relaxed";
                    paragraph.textContent = config.description;
                    descriptionEl.appendChild(paragraph);

                    // Tampilkan rekomendasi
                    config.recommendations.forEach(function(recommendation) {
                        const listItem = document.createElement('li');
                        listItem.classList.add('flex', 'items-start', 'mb-3', 'bg-white', 'p-3', 'rounded-lg',
                            'shadow-sm', 'border', 'border-gray-100', 'transition-all', 'duration-200',
                            'hover:shadow-md');

                        const iconWrapper = document.createElement('span');
                        iconWrapper.className =
                            "inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-600 mr-3 mt-0.5";

                        const icon = document.createElement('i');
                        icon.classList.add('fas', config.icon, 'text-xs');

                        const text = document.createElement('span');
                        text.textContent = recommendation;
                        text.className = "text-gray-700";

                        iconWrapper.appendChild(icon);
                        listItem.appendChild(iconWrapper);
                        listItem.appendChild(text);
                        recommendationsEl.appendChild(listItem);
                    });
                }
            }
            // Kasus untuk gaya belajar campuran
            else {
                // Buat kunci untuk mencari di combinedConfigs
                const combinedKey = activeStyles.sort().join('-');

                // Tampilkan deskripsi gabungan
                const paragraph = document.createElement('p');
                paragraph.className = "text-gray-600 leading-relaxed";

                if (combinedConfigs[combinedKey]) {
                    paragraph.textContent = combinedConfigs[combinedKey].description;
                } else {
                    paragraph.textContent = "Anda memiliki gaya belajar campuran yang unik yang mencakup " +
                        activeStyles.join(' dan ') + ".";
                }

                descriptionEl.appendChild(paragraph);

                // Tampilkan rekomendasi gabungan dari semua gaya belajar aktif
                let allRecommendations = [];

                // Kumpulkan semua rekomendasi dari gaya belajar aktif
                activeStyles.forEach(function(style) {
                    if (styleConfigs[style] && styleConfigs[style].recommendations) {
                        // Pilih 2-3 rekomendasi dari setiap gaya untuk menghindari terlalu banyak
                        const selectedRecs = styleConfigs[style].recommendations.slice(0, 3);
                        selectedRecs.forEach(function(rec) {
                            allRecommendations.push({
                                text: rec,
                                icon: styleConfigs[style].icon,
                                color: styleConfigs[style].color,
                                style: style
                            });
                        });
                    }
                });

                // Tampilkan rekomendasi gabungan
                allRecommendations.forEach(function(rec) {
                    const listItem = document.createElement('li');
                    listItem.classList.add('flex', 'items-start', 'mb-3', 'bg-white', 'p-3', 'rounded-lg',
                        'shadow-sm', 'border', 'border-gray-100', 'transition-all', 'duration-200',
                        'hover:shadow-md');

                    const iconWrapper = document.createElement('span');
                    iconWrapper.className =
                        "inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-600 mr-3 mt-0.5";

                    const icon = document.createElement('i');
                    icon.classList.add('fas', rec.icon, 'text-xs');

                    const text = document.createElement('span');
                    text.innerHTML =
                        `<span class="text-gray-700">${rec.text}</span> <span class="text-xs text-blue-500 ml-1"></span>`;

                    iconWrapper.appendChild(icon);
                    listItem.appendChild(iconWrapper);
                    listItem.appendChild(text);
                    recommendationsEl.appendChild(listItem);
                });
            }
        }
    </script>
</body>

</html>
