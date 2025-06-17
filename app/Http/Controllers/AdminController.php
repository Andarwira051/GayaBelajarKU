<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        return view('admin.dashboard', [
            'userCount' => User::count(),
            'questionCount' => Question::count(),
            'testCount' => Test::count(),// Sesuaikan dengan model yang digunakan
        ]);
    }

    
}
