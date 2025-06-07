<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function getLogs()
    {
        $logPath = storage_path('logs/laravel.log');

        if (!File::exists($logPath)) {
            return response()->json(['error' => 'Log file not found'], 404);
        }

        $content = File::get($logPath);

        // Optional: limit size (e.g., get only the last 5000 characters)
        $content = substr($content, -5000);

        return response()->json([
            'log' => $content
        ]);
    }


    
}
