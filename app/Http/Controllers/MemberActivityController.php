<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberActivityController extends Controller
{
    public function index(): View
    {
        $activities = [
            [
                'id' => 1,
                'title' => 'Profile Updated',
                'description' => 'You updated your profile information',
                'date' => now()->subDays(2),
                'type' => 'profile'
            ],
            [
                'id' => 2,
                'title' => 'Welcome to the Platform',
                'description' => 'Your account was created successfully',
                'date' => auth()->user()->created_at,
                'type' => 'system'
            ],
            [
                'id' => 3,
                'title' => 'Dashboard Access',
                'description' => 'You accessed your member dashboard',
                'date' => now()->subHours(3),
                'type' => 'access'
            ]
        ];

        return view('member.activities', compact('activities'));
    }
}
