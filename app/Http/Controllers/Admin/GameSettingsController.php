<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GameSettingsController extends Controller
{
    public function index()
    {
        $settings = GameSetting::latest()->paginate(10);
        return view('admin.dashbord.game.game_settings', compact('settings'));
    }

    // public function create()
    // {
    //     return view('admin.dashbord.game.create');
    // }

    // // public function store(Request $request)
    // // {
    // //     $validatedData = $request->validate([
    // //         'start_time' => 'required|date_format:H:i',
    // //         'end_time' => 'required|date_format:H:i',
    // //         'earning_percentage' => 'required|numeric|min:0|max:100',
    // //         'is_active' => 'nullable|boolean',
    // //         'payout_enabled' => 'nullable|boolean',
    // //         'type' => 'required|in:buy,sell',
    // //         'crypto_category' => 'required|in:XRP,BTC,ETH,SOLANA,PI',
    // //     ]);

    // //     // Get the application's configured timezone (e.g., 'Africa/Nairobi')
    // //     $appTimezone = config('app.timezone');

    // //     // Create Carbon instances from the time string, specifying they are in the app's timezone
    // //     $startTime = Carbon::createFromFormat('H:i', $validatedData['start_time'], $appTimezone);
    // //     $endTime = Carbon::createFromFormat('H:i', $validatedData['end_time'], $appTimezone);

    // //     // If the end time is on the next day (e.g., starts at 23:00, ends at 01:00)
    // //     if ($endTime->lt($startTime)) {
    // //         $endTime->addDay();
    // //     }

    // //     try {
    // //         // Prepare data for creation
    // //         $dataToCreate = $validatedData;

    // //         // Convert checkbox values properly
    // //         $dataToCreate['is_active'] = $request->boolean('is_active');
    // //         $dataToCreate['payout_enabled'] = $request->boolean('payout_enabled');

    // //         // The Carbon instances are already timezone-aware, so setTimezone converts them to UTC for storage
    // //         $dataToCreate['start_time'] = $startTime;
    // //         $dataToCreate['end_time'] = $endTime;

    // //         GameSetting::create($dataToCreate);

    // //         return redirect()->route('admin.game_settings.index')->with('success', 'Game setting created successfully.');
    // //     } catch (\Exception $e) {
    // //         Log::error("Error creating game setting: " . $e->getMessage());
    // //         return back()->withInput()->with('error', 'Failed to create game setting. Please try again.');
    // //     }
    // // }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i',
    //         'earning_percentage' => 'required|numeric|min:0|max:100',
    //         'is_active' => 'nullable|boolean',
    //         'payout_enabled' => 'nullable|boolean',
    //         'type' => 'required|in:buy,sell',
    //         'crypto_category' => 'required|in:XRP,BTC,ETH,SOLANA,PI',
    //     ]);

    //     // Get the application's configured timezone (e.g., 'Africa/Nairobi')
    //     $appTimezone = config('app.timezone');

    //     // Create Carbon instances from the time string, specifying they are in the app's timezone
    //     // This creates a full datetime object for today at the specified time
    //     $startTime = Carbon::createFromFormat('H:i', $validatedData['start_time'], $appTimezone);
    //     $endTime = Carbon::createFromFormat('H:i', $validatedData['end_time'], $appTimezone);

    //     // If the end time is on the next day (e.g., starts at 23:00, ends at 01:00)
    //     if ($endTime->lt($startTime)) {
    //         $endTime->addDay();
    //     }

    //     try {
    //         // Prepare data for creation
    //         $dataToCreate = $validatedData;

    //         // Convert checkbox values properly
    //         $dataToCreate['is_active'] = $request->boolean('is_active');
    //         $dataToCreate['payout_enabled'] = $request->boolean('payout_enabled');

    //         // Eloquent will automatically convert these Carbon objects to UTC for storage
    //         $dataToCreate['start_time'] = $startTime;
    //         $dataToCreate['end_time'] = $endTime;

    //         GameSetting::create($dataToCreate);

    //         return redirect()->route('admin.game_settings.index')->with('success', 'Game setting created successfully.');
    //     } catch (\Exception $e) {
    //         Log::error("Error creating game setting: " . $e->getMessage());
    //         return back()->withInput()->with('error', 'Failed to create game setting. Please try again.');
    //     }

    // }

        // public function edit(GameSetting $gameSetting)
    // {
    //     return view('admin.dashbord.game.edit', compact('gameSetting'));
    // }


    // public function update(Request $request, GameSetting $gameSetting)
    // {
    //     $validatedData = $request->validate([
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i',
    //         'earning_percentage' => 'required|numeric|min:0|max:100',
    //         'is_active' => 'nullable|boolean',
    //         'payout_enabled' => 'nullable|boolean',
    //         'type' => 'required|in:buy,sell',
    //         'crypto_category' => 'required|in:XRP,BTC,ETH,SOLANA,PI',
    //     ]);

    //     // Get the application's configured timezone
    //     $appTimezone = config('app.timezone');

    //     // Create Carbon instances from the time string in the correct timezone
    //     $startTime = Carbon::createFromFormat('H:i', $validatedData['start_time'], $appTimezone);
    //     $endTime = Carbon::createFromFormat('H:i', $validatedData['end_time'], $appTimezone);

    //     if ($endTime->lt($startTime)) {
    //         $endTime->addDay();
    //     }

    //     try {
    //         $dataToUpdate = $validatedData;
    //         $dataToUpdate['is_active'] = $request->boolean('is_active');
    //         $dataToUpdate['payout_enabled'] = $request->boolean('payout_enabled');

    //         // Convert to UTC for storage
    //         $dataToUpdate['start_time'] = $startTime;
    //         $dataToUpdate['end_time'] = $endTime;

    //         $gameSetting->update($dataToUpdate);

    //         return redirect()->route('admin.game_settings.index')->with('success', 'Game setting updated successfully.');
    //     } catch (\Exception $e) {
    //         Log::error("Error updating game setting {$gameSetting->id}: " . $e->getMessage());
    //         return back()->withInput()->with('error', 'Failed to update game setting. Please try again.');
    //     }
    // }


    public function create()
    {
        return view('admin.dashbord.game.create');
    }

    public function store(Request $request)
    {
        // Validation ensures end time is after start time
        $validatedData = $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'earning_percentage' => 'required|numeric|min:0',
            'type' => 'required|in:buy,sell',
            'crypto_category' => 'required|in:XRP,BTC,ETH,SOLANA,PI',
        ]);

        // Get the application's configured timezone (e.g., 'Africa/Nairobi')
        $appTimezone = config('app.timezone');

        // Carbon parses the datetime string, interpreting it in the app's timezone.
        // Eloquent will automatically convert these Carbon instances to UTC upon saving.
        $startTime = Carbon::parse($validatedData['start_time'], $appTimezone);
        $endTime = Carbon::parse($validatedData['end_time'], $appTimezone);

        try {
            GameSetting::create([
                'start_time' => $startTime,
                'end_time' => $endTime,
                'earning_percentage' => $validatedData['earning_percentage'],
                'is_active' => $request->boolean('is_active'),
                'payout_enabled' => $request->boolean('payout_enabled'),
                'type' => $validatedData['type'],
                'crypto_category' => $validatedData['crypto_category'],
            ]);

            return redirect()->route('admin.game_settings.index')->with('success', 'Game setting created successfully.');
        } catch (\Exception $e) {
            Log::error("Error creating game setting: " . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create game setting. Please try again.');
        }
    }

    public function edit(GameSetting $gameSetting)
    {
        return view('admin.dashbord.game.create', compact('gameSetting'));
    }

    public function update(Request $request, GameSetting $gameSetting)
    {
        $validatedData = $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'earning_percentage' => 'required|numeric|min:0',
            'type' => 'required|in:buy,sell',
            'crypto_category' => 'required|in:XRP,BTC,ETH,SOLANA,PI',
        ]);

        $appTimezone = config('app.timezone');
        $startTime = Carbon::parse($validatedData['start_time'], $appTimezone);
        $endTime = Carbon::parse($validatedData['end_time'], $appTimezone);

        try {
            $gameSetting->update([
                'start_time' => $startTime,
                'end_time' => $endTime,
                'earning_percentage' => $validatedData['earning_percentage'],
                'is_active' => $request->boolean('is_active'),
                'payout_enabled' => $request->boolean('payout_enabled'),
                'type' => $validatedData['type'],
                'crypto_category' => $validatedData['crypto_category'],
            ]);

            return redirect()->route('admin.game_settings.index')->with('success', 'Game setting updated successfully.');
        } catch (\Exception $e) {
            Log::error("Error updating game setting {$gameSetting->id}: " . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update game setting. Please try again.');
        }
    }






    public function destroy(GameSetting $gameSetting)
    {
        try {
            $gameSetting->delete();
            return redirect()->route('admin.game_settings.index')->with('success', 'Game setting deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Error deleting game setting {$gameSetting->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to delete game setting. Please try again.');
        }
    }

    public function toggleInvestmentStatus(GameSetting $gameSetting)
    {
        try {
            $gameSetting->update(['is_active' => !$gameSetting->is_active]);
            return back()->with('success', 'Investment status toggled for ' . $gameSetting->id . '.');
        } catch (\Exception $e) {
            Log::error("Error toggling investment status for {$gameSetting->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to toggle investment status. Please try again.');
        }
    }

    public function togglePayoutStatus(GameSetting $gameSetting)
    {
        try {
            $gameSetting->update(['payout_enabled' => !$gameSetting->payout_enabled]);
            return back()->with('success', 'Payout status toggled for ' . $gameSetting->id . '.');
        } catch (\Exception $e) {
            Log::error("Error toggling payout status for {$gameSetting->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to toggle payout status. Please try again.');
        }
    }
}
