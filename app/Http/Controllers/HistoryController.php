<?php

namespace App\Http\Controllers;

use App\Models\history;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(){
        $history = history::orderBy('id', 'desc')->take('10')->get();
        return view('history', compact('history'));
    }
}
