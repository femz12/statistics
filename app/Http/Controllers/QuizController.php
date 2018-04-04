<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    //
    public function start()
    {
      return view('quiz.start');
    }
}
