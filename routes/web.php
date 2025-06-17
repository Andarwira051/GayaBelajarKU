<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\RiwayatController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PengajarMiddleware;
use App\Models\Test;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

/*
|--------------------------------------------------------------------------
| RUTE PUBLIK (Tanpa Autentikasi)
|--------------------------------------------------------------------------
| Rute-rute yang dapat diakses tanpa harus login terlebih dahulu
|
*/

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Rute autentikasi (login & register)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [LoginController::class, 'register'])->name('register.store');



//Rute-rute yang memerlukan autentikasi dasar


Route::middleware(['auth'])->group(function () {

    // == Rute form quiz ==
    Route::get('/quiz-form', [QuizController::class, 'quizform'])->name('quiz-form');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/{id}', [RiwayatController::class, 'showDetail'])->name('showDetail');

    // === RUTE QUIZ ===
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz');
    Route::post('/submit-quiz', [QuizController::class, 'submitQuiz'])->name('quiz.submit');

    // === RUTE HASIL & LAPORAN ===
    // Tampil hasil tes
    Route::get('/user/{id}/result/{prediction}', function ($id, $prediction) {
        $test = Test::where('user_id', $id)->where('prediction', $prediction)->latest()->first();

        $visualPercentage = $test->average_score > 0 ? round(($test->visual_score / ($test->average_score * 3)) * 100) : 0;
        $auditoryPercentage = $test->average_score > 0 ? round(($test->auditory_score / ($test->average_score * 3)) * 100) : 0;
        $kinestheticPercentage = $test->average_score > 0 ? round(($test->kinesthetic_score / ($test->average_score * 3)) * 100) : 0;

        $dominantStyle = max($visualPercentage, $auditoryPercentage, $kinestheticPercentage);

        return view('result', compact('test', 'visualPercentage', 'auditoryPercentage', 'kinestheticPercentage', 'dominantStyle'));
    })->name('result');

    // Export hasil ke PDF
    Route::get('/user/{id}/result/{prediction}/pdf', function ($id, $prediction) {
        $test = Test::findOrFail($id);

        $pdf = Pdf::loadView('pdf.result', compact('test', 'prediction'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('hasil_tes_gaya_belajar.pdf');
    })->name('export.pdf');


    // === RUTE TOKEN ===
    Route::get('/token', [TokenController::class, 'showForm'])->name('token.form');
    Route::post('/token', [TokenController::class, 'submitToken'])->name('token.submit');
    Route::post('/token/clear', [TokenController::class, 'clearToken'])->name('token.clear');


    // === RUTE LOGOUT ===
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});

//Rute-rute yang hanya dapat diakses oleh admin

// Rute admin dengan middleware AdminMiddleware (class)
Route::middleware(['auth', AdminMiddleware::class])->group(function () {

    // === DASHBOARD ADMIN ===
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // === MANAJEMEN USER ===
    Route::resource('users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // === MANAJEMEN PERTANYAAN ===
    Route::get('/admin/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::get('/admin/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/admin/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/admin/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/admin/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/admin/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    Route::post('/admin/questions/import', [QuestionController::class, 'import'])->name('admin.questions.import');
    Route::get('/admin/questions/importexcel', [QuestionController::class, 'excel'])->name('questions.excel');

});

// Rute-rute yang hanya dapat diakses oleh pengajar


Route::middleware(['auth', PengajarMiddleware::class])->group(function () {

    // === DASHBOARD PENGAJAR ===
    Route::get('/pengajar', [PengajarController::class, 'lihatKelas'])->name('pengajar.kelas.index');;

    // === MANAJEMEN KELAS ===
    Route::get('/pengajar/kelas', [PengajarController::class, 'lihatKelas'])->name('pengajar.kelas.index');
    Route::get('/pengajar/kelas/buat', [PengajarController::class, 'buatKelasForm'])->name('pengajar.kelas.create');
    Route::post('/pengajar/kelas/simpan', [PengajarController::class, 'simpan'])->name('pengajar.kelas.simpan');

    // Rute kelas
    Route::get('/kelas/{nama_kelas}', [KelasController::class, 'show'])->name('pengajar.kelas.show');
    Route::get('/kelas/{nama_kelas}/edit', [KelasController::class, 'edit'])->name('pengajar.kelas.edit');
    Route::put('/kelas/{nama_kelas}', [KelasController::class, 'update'])->name('pengajar.kelas.update');
    Route::delete('/kelas/{nama_kelas}', [KelasController::class, 'destroy'])->name('pengajar.kelas.destroy');

});
