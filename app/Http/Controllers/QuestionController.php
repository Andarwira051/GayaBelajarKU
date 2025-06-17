<?php

namespace App\Http\Controllers;

use App\Imports\QuestionsImport;
use App\Models\Question;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    // Menampilkan daftar soal
    public function index()
    {
        $questions = Question::paginate(10); // Menampilkan 10 soal per halaman
        return view('questions.index', compact('questions'));
    }

    // Menampilkan form tambah soal
    public function create()
    {
        return view('questions.create');
    }

    // Menyimpan soal baru
    public function store(Request $request)
    {
        $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:visual,auditory,kinesthetic',
            'is_favoritable' => 'required|boolean',
        ]);

        Question::create([
            'question_text' => $request->question_text,
            'type' => $request->type,
            'is_favoritable' => $request->is_favoritable,
        ]);

        return redirect()->route('questions.index')->with('success', 'Soal berhasil ditambahkan');
    }

    // Menampilkan form edit soal
    public function edit(Question $question)
    {
        return response()->json([
            'question_text' => $question->question_text,
            'type' => $question->type,
            'is_favoritable' => $question->is_favoritable,
        ]);
    }

    // Mengupdate soal
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'type' => 'required|in:visual,auditory,kinesthetic',
            'is_favoritable' => 'required|boolean',
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'type' => $request->type,
            'is_favoritable' => $request->is_favoritable,
        ]);

        return redirect()->route('questions.index')->with('success', 'Soal berhasil diperbarui');
    }

    // Menghapus soal
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Soal berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:2048', // Validasi file
        ]);

        Excel::import(new QuestionsImport, $request->file('file'));

        return redirect()->route('questions.index')->with('success', 'Soal berhasil diimpor!');
    }

    public function excel(){
        return view('questions.excel');
    }
}
