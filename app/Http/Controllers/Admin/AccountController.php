<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\MainAccount;

class AccountController extends Controller
{


    public function store(Request $request)
    {
        if (MainAccount::count() > 0) {
            return redirect()->back()->with('success', 'Main account alaeady exists....');
        }

        $request->validate([
            'deposit_address' => 'required|string',
            'password' => 'required|string',
            'currency' => 'required|string',
            'admin_id' => 'required|exists:admins,id|unique:main_accounts,admin_id',
        ]);

        $mainAccount = MainAccount::create([
            'deposit_address' => $request->deposit_address,
            'password' => bcrypt($request->password),
            'currency' => $request->currency,
            'admin_id' => $request->admin_id,
        ]);

        return redirect()->back()->with('success', 'Main account created successfully.');
    }



    public function update(Request $request, $id)
    {
        $mainAccount = MainAccount::findOrFail($id);

        $request->validate([
            'deposit_address' => 'sometimes|string',
            'currency' => 'sometimes|string',
            'password' => 'nullable|string|min:6',
            'current_password' => 'required|string',
            'admin_id' => 'sometimes|exists:admins,id|unique:main_accounts,admin_id,' . $id,
        ]);

        
        if (!Hash::check($request->current_password, $mainAccount->password)) {
            return redirect()->back()->with('error', 'Invalid current password. Update failed.');
        }

        if ($request->has('deposit_address')) {
            $mainAccount->deposit_address = $request->deposit_address;
        }

        if ($request->has('currency')) {
            $mainAccount->currency = $request->currency;
        }

        if ($request->filled('password')) {
            $mainAccount->password = bcrypt($request->password);
        }

        if ($request->has('admin_id')) {
            $mainAccount->admin_id = $request->admin_id;
        }

        $mainAccount->save();

        return redirect()->back()->with('success', 'Main account updated successfully.');
    }


}
