<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{

    public function store(Request $request)
    {
        $answers = $request->input('answers');

        // Inisialisasi skor
        $visualScore = 0;
        $auditoryScore = 0;
        $kinestheticScore = 0;

        // Hitung skor dari jawaban user
        foreach ($answers as $questionId => $answer) {
            $question = Question::find($questionId);

            if ($question) {
                if ($question->type === 'visual') {
                    $visualScore += (int) $answer;
                } elseif ($question->type === 'auditory') {
                    $auditoryScore += (int) $answer;
                } elseif ($question->type === 'kinesthetic') {
                    $kinestheticScore += (int) $answer;
                }
            }
        }

        // Hitung rata-rata skor
        $averageScore = round(($visualScore + $auditoryScore + $kinestheticScore) / 3, 2);

        // Simpan hasil tes
        $test = Test::create([
            'user_id' => Auth::id(),
            'visual_score' => $visualScore,
            'auditory_score' => $auditoryScore,
            'kinesthetic_score' => $kinestheticScore,
            'average_score' => $averageScore,
        ]);

        return response()->json(['message' => 'Tes berhasil disimpan!', 'test' => $test]);
    }
}
