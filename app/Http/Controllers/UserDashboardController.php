<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard');
    }
    
    public function profile()
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        return view('user.dashboard.profiles', compact('user', 'profile'));
    }
}
