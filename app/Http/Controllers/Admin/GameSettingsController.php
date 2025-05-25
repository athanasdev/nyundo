<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // Import Carbon

class GameSettingsController extends Controller
{
    /**
     * Display a listing of the game settings.
     * The times are displayed in the admin's local timezone in the view.
     */
    public function index()
    {
        $settings = GameSetting::latest()->paginate(10);
        return view('admin.dashbord.game.game_settings', compact('settings'));
    }

    /**
     * Show the form for creating a new game setting.
     */
    public function create()
    {
        return view('admin.dashbord.game.create');
    }

    /**
     * Store a newly created game setting in storage.
     * Converts start_time and end_time from admin's local timezone to UTC before saving.
     */
    public function store(Request $request)
    {
        // Get the admin's configured timezone from the GameSetting model
        $adminTimezone = GameSetting::getAdminTimezone();

        // Validate the incoming request data
        $validatedData = $request->validate([
            // 'name' => 'nullable|string|max:255', // Add this if you introduce a name field
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'earning_percentage' => 'required|numeric|min:0|max:100',
        ]);

        // Custom validation for end_time after start_time, considering the timezone
        $startTime = Carbon::createFromFormat('H:i', $validatedData['start_time'], $adminTimezone);
        $endTime = Carbon::createFromFormat('H:i', $validatedData['end_time'], $adminTimezone);

        if ($endTime->lt($startTime)) {
            // If end time is earlier than start time, it likely spans into the next day.
            // For simplicity, we'll just add a day to end time to make the comparison valid.
            // You might want more sophisticated logic here depending on your business rules
            // (e.g., explicitly disallow settings that span across midnight, or require a date input).
            $endTime->addDay();
        }

        if ($endTime->lte($startTime)) { // Use LSE to ensure end time is strictly after start time, even if by a second
            return back()->withInput()->withErrors(['end_time' => 'The end time must be after the start time.']);
        }


        try {
            // Explicitly handle checkbox values as they might not be present if unchecked
            $validatedData['is_active'] = $request->has('is_active');
            $validatedData['payout_enabled'] = $request->has('payout_enabled');

            // Convert local times to UTC for storage
            $validatedData['start_time'] = $startTime->setTimezone('UTC')->format('H:i:s');
            $validatedData['end_time'] = $endTime->setTimezone('UTC')->format('H:i:s');


            // Create the new GameSetting record in the database
            GameSetting::create($validatedData);

            // Redirect with a success message
            return redirect()->route('admin.game_settings.index')->with('success', 'Game setting created successfully.');

        } catch (\Exception $e) {
            // Log any unexpected errors and redirect back with an error message
            Log::error("Error creating game setting: " . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create game setting. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified game setting.
     * The times are passed to the view as Carbon instances, which will then be formatted in the view.
     */
    public function edit(GameSetting $gameSetting)
    {
        return view('admin.dashbord.game.edit', compact('gameSetting'));
    }

    /**
     * Update the specified game setting in storage.
     * Converts start_time and end_time from admin's local timezone to UTC before saving.
     */
    public function update(Request $request, GameSetting $gameSetting)
    {
        // Get the admin's configured timezone from the GameSetting model
        $adminTimezone = GameSetting::getAdminTimezone();

        $validatedData = $request->validate([
            // 'name' => 'nullable|string|max:255', // Add this if you introduce a name field
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'earning_percentage' => 'required|numeric|min:0|max:100',
        ]);

        // Custom validation for end_time after start_time, considering the timezone
        $startTime = Carbon::createFromFormat('H:i', $validatedData['start_time'], $adminTimezone);
        $endTime = Carbon::createFromFormat('H:i', $validatedData['end_time'], $adminTimezone);

        if ($endTime->lt($startTime)) {
            $endTime->addDay();
        }

        if ($endTime->lte($startTime)) {
            return back()->withInput()->withErrors(['end_time' => 'The end time must be after the start time.']);
        }


        try {
            // Explicitly handle checkbox values for update as well
            $validatedData['is_active'] = $request->has('is_active');
            $validatedData['payout_enabled'] = $request->has('payout_enabled');

            // Convert local times to UTC for storage
            $validatedData['start_time'] = $startTime->setTimezone('UTC')->format('H:i:s');
            $validatedData['end_time'] = $endTime->setTimezone('UTC')->format('H:i:s');

            $gameSetting->update($validatedData);

            return redirect()->route('admin.game_settings.index')->with('success', 'Game setting updated successfully.');
        } catch (\Exception $e) {
            Log::error("Error updating game setting {$gameSetting->id}: " . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update game setting. Please try again.');
        }
    }

    /**
     * Remove the specified game setting from storage.
     */
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

    /**
     * Toggle the investment status for the specified game setting.
     */
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

    /**
     * Toggle the payout status for the specified game setting.
     */
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

