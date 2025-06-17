<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function index()
    {
        return view('quiz.instruction');
    }

    public function quizform()
    {
        $questions = Question::all(); // Ambil semua soal
        return view('quiz.quiz-page', compact('questions'));
    }

    public function submitQuiz(Request $request)
    {
        $answers = $request->input('answers'); // ['question_id' => 1, 'score' => 1]

        $visual = 0;
        $auditory = 0;
        $kinesthetic = 0;

        foreach ($answers as $answer) {
            $question = Question::find($answer['question_id']); // Ambil soal dari database

            if ($question) {
                $score = $answer['score'];

                // Jika soal favoritable, gunakan nilai asli. Jika tidak, balik nilai (1 -> 0, 0 -> 1)
                if (!$question->favoritable) {
                    $score = $score == 1 ? 0 : 1;
                }

                // Tambahkan skor sesuai tipe soal
                if ($question->type === 'visual') {
                    $visual += $score;
                } elseif ($question->type === 'auditory') {
                    $auditory += $score;
                } elseif ($question->type === 'kinesthetic') {
                    $kinesthetic += $score;
                }
            }
        }

        // Hitung rata-rata
        $total = $visual + $auditory + $kinesthetic;
        $average = $total > 0 ? $total / 3 : 0;

        // Simpan ke database
        $test = Test::create([
            'user_id' => Auth::id(),
            'visual_score' => $visual,
            'auditory_score' => $auditory,
            'kinesthetic_score' => $kinesthetic,
            'average_score' => $average
        ]);

        // Kirim ke Flask
        $flaskUrl = env('FLASK_API_URL');
        $response = Http::post($flaskUrl, [
            'visual' => $test->visual_score,
            'auditory' => $test->auditory_score,
            'kinesthetic' => $test->kinesthetic_score,
            'average' => $test->average_score
        ]);

        $result = $response->json();

        // Update hasil prediksi di database
        $test->update(['prediction' => $result['prediction']]);
        $userId = Auth::id();

        return redirect()->route('result', ['id' => $userId, 'prediction' => $result['prediction']])
            ->with([
                'visual_score' => $test->visual_score,
                'auditory_score' => $test->auditory_score,
                'kinesthetic_score' => $test->kinesthetic_score,
                'average_score' => $test->average_score,
            ]);
    }



}
