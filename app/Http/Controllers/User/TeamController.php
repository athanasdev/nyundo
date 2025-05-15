<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function team()
    {
        return view('user.team');
    }


    public function aitrading()
    {
        return view('user.aitrading');
    }

    public function bonuses()
    {
        return view('user.bonuses');
    }

    
}
