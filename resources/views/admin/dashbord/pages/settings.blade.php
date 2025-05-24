@extends('admin.dashbord.pages.layout')

@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                @php
                    // Check if main account exists
                    $mainAccount = \App\Models\MainAccount::first();
                @endphp

                <div class="card-box mb-10">
                    <div class="pd-20 card-box mb-30">
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-blue h4">Payment Address</h4>
                            </div>
                        </div>

                        <form
                            action="{{ $mainAccount ? route('main-account.update', $mainAccount->id) : route('main-account.store') }}"
                            method="POST">
                            @csrf
                            @if ($mainAccount)
                                @method('PUT')
                            @endif

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Deposit Address</label>
                                <div class="col-sm-12 col-md-10">
                                    <input class="form-control" type="text" name="deposit_address"
                                        placeholder="e.g., usdttcr20"
                                        value="{{ old('deposit_address', $mainAccount->deposit_address ?? '') }}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">Currency</label>
                                <div class="col-sm-12 col-md-10">
                                    <input class="form-control" type="text" name="currency" placeholder="e.g., USD"
                                        value="{{ old('currency', $mainAccount->currency ?? '') }}" required>
                                </div>
                            </div>

                            @if ($mainAccount)
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Current Password</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control" name="current_password" type="password"
                                            placeholder="Enter current password">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-2 col-form-label">New Password</label>
                                <div class="col-sm-12 col-md-10">
                                    <input class="form-control"
                                        placeholder="{{ $mainAccount ? 'Update Password' : 'Set Password' }}"
                                        name="password" type="password" {{ $mainAccount ? '' : 'required' }}>
                                </div>
                            </div>

                            <input type="hidden" name="admin_id" value="{{ auth()->user()->id }}">

                            <div class="btn-list">
                                <button type="submit" class="btn btn-success btn-sm">
                                    {{ $mainAccount ? 'Update' : 'Create' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- Referral Settings Table -->
                <div class="card-box mb-10">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Referral Settings</h4>
                    </div>
                    <div class="pb-20">
                        <table class="table hover nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Level</th>
                                    <th>Commission Percentage (%)</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop through the 'referrals' collection, not 'referralSettings' --}}
                                @foreach ($referrals as $setting)
                                    <tr>
                                        <td>{{ $setting->id }}</td>
                                        <td>{{ $setting->level }}</td>
                                        {{-- Use 'percent' field from the new table --}}
                                        <td>{{ number_format($setting->percent, 2) }}</td>
                                        <td>{{ $setting->created_at ? $setting->created_at->format('d-m-Y H:i') : 'N/A' }}
                                        </td>
                                        <td>{{ $setting->updated_at ? $setting->updated_at->format('d-m-Y H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            {{-- This 'update' button currently has type="submit" without a form.
                                 If you want to edit individual rows, you'll need:
                                 1. A form around each row OR
                                 2. A modal/separate page for editing.
                                 The previous example I gave for ReferralController@index
                                 uses a single form to add/edit all levels dynamically.
                                 This simple 'update' button doesn't do anything by itself here.
                            --}}
                                            <button class="btn btn-success btn-sm" type="button">Edit</button>
                                            {{-- You might also want a delete button --}}
                                            {{-- <button class="btn btn-danger btn-sm" type="button">Delete</button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
