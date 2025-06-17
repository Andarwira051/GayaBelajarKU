<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Question([
            'question_text' => $row['question_text'], // Pastikan sesuai dengan judul kolom di Excel
            'type' => $row['type'], // Harus 'visual', 'auditory', atau 'kinesthetic'
            'is_favoritable' => $row['is_favoritable'], // 1 atau 0
        ]);
    }
}

