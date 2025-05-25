<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameSetting; // Make sure this is correctly imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // For logging errors

class GameSettingsController extends Controller
{
    public function index()
    {
        $settings = GameSetting::latest()->paginate(10);
        return view('admin.dashbord.game.game_settings', compact('settings'));
    }

    public function create()
    {
        return view('admin.game_settings.create');
    }

    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $validatedData = $request->validate([
            // 'name' => 'nullable|string|max:255', // Add this if you introduce a name field
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'earning_percentage' => 'required|numeric|min:0|max:100',
            // 'is_active' and 'payout_enabled' are handled below after validation
        ]);

        try {
            // 2. Explicitly handle checkbox values as they might not be present if unchecked
            //    Request::has() returns true if the checkbox was checked and sent a value (e.g., '1')
            //    and false if it was not checked.
            $validatedData['is_active'] = $request->has('is_active');
            $validatedData['payout_enabled'] = $request->has('payout_enabled');

            // 3. Create the new GameSetting record in the database
            GameSetting::create($validatedData); // Use $validatedData for mass assignment

            // 4. Redirect with a success message
            return redirect()->route('admin.game_settings.index')->with('success', 'Game setting created successfully.');

        } catch (\Exception $e) {
            // 5. Log any unexpected errors and redirect back with an error message
            Log::error("Error creating game setting: " . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create game setting. Please try again.');
        }
    }

    public function edit(GameSetting $gameSetting)
    {
        return view('admin.game_settings.edit', compact('gameSetting'));
    }

    public function update(Request $request, GameSetting $gameSetting)
    {
        $validatedData = $request->validate([
            // 'name' => 'nullable|string|max:255', // Add this if you introduce a name field
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'earning_percentage' => 'required|numeric|min:0|max:100',
        ]);

        try {
            // Explicitly handle checkbox values for update as well
            $validatedData['is_active'] = $request->has('is_active');
            $validatedData['payout_enabled'] = $request->has('payout_enabled');

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

    // Methods to toggle global status via admin panel (buttons/switches)
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
