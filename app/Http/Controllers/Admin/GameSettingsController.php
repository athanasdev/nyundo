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

    public function create()
    {
        return view('admin.dashbord.game.create');
    }

    public function store(Request $request)
    {
        // $adminTimezone = GameSetting::getAdminTimezone();

        $validatedData = $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'earning_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'nullable|boolean',
            'payout_enabled' => 'nullable|boolean',
            'type' => 'required|in:buy,sell',
            'crypto_category' => 'required|in:XRP,BTC,ETH,SOLANA,PI',
        ]);


        $todayInAdminTimezone = Carbon::now();

        $startTime = $todayInAdminTimezone->copy()->setTimeFromTimeString($validatedData['start_time']);
        $endTime = $todayInAdminTimezone->copy()->setTimeFromTimeString($validatedData['end_time']);

        if ($endTime->lt($startTime)) {
            $endTime->addDay();
        }

        if ($endTime->lte($startTime)) {
            return back()->withInput()->withErrors(['end_time' => 'The end time must be after the start time.']);
        }

        try {
            // Convert checkbox values properly
            $validatedData['is_active'] = $request->boolean('is_active');
            $validatedData['payout_enabled'] = $request->boolean('payout_enabled');

            // Convert to UTC for storage
            $validatedData['start_time'] = $startTime->copy()->setTimezone('UTC');
            $validatedData['end_time'] = $endTime->copy()->setTimezone('UTC');

            GameSetting::create($validatedData);

            return redirect()->route('admin.game_settings.index')->with('success', 'Game setting created successfully.');
        } catch (\Exception $e) {
            Log::error("Error creating game setting: " . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create game setting. Please try again.');
        }
    }

    public function edit(GameSetting $gameSetting)
    {
        return view('admin.dashbord.game.edit', compact('gameSetting'));
    }

    public function update(Request $request, GameSetting $gameSetting)
    {
        // $adminTimezone = GameSetting::getAdminTimezone();

        $validatedData = $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'earning_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'nullable|boolean',
            'payout_enabled' => 'nullable|boolean',
            'type' => 'required|in:buy,sell',
            'crypto_category' => 'required|in:XRP,BTC,ETH,SOLANA,PI',
        ]);


        $startTime = Carbon::createFromFormat('H:i', $validatedData['start_time']);
        $endTime = Carbon::createFromFormat('H:i', $validatedData['end_time']);

        if ($endTime->lt($startTime)) {
            $endTime->addDay();
        }

        if ($endTime->lte($startTime)) {
            return back()->withInput()->withErrors(['end_time' => 'The end time must be after the start time.']);
        }

        try {
            $validatedData['is_active'] = $request->boolean('is_active');
            $validatedData['payout_enabled'] = $request->boolean('payout_enabled');

            $validatedData['start_time'] = $startTime->copy()->setTimezone('UTC');
            $validatedData['end_time'] = $endTime->copy()->setTimezone('UTC');

            $gameSetting->update($validatedData);

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
