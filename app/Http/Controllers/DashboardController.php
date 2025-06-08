<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Anda bisa menambahkan logic untuk mengambil data film berdasarkan mood di sini
        return view('dashboard');
    }
}