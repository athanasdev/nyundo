@extends('admin.dashbord.pages.layout') {{-- Ensure this path is correct --}}

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Edit Game Setting</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.game_settings.index') }}">Game Settings List</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Game Setting</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                {{-- Success/Error Messages --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.game_settings.update', $gameSetting->id) }}">
                    @csrf
                    @method('PUT')

                    @php
                        $adminTimezone = \App\Models\GameSetting::getAdminTimezone();
                    @endphp

                    <div class="mb-3">
                        <label for="start_time">Start Time (Local Time)</label>
                        <input
                            type="time"
                            class="form-control @error('start_time') is-invalid @enderror"
                            name="start_time"
                            value="{{ old('start_time', optional($gameSetting->start_time)->setTimezone($adminTimezone)->format('H:i')) }}"
                            required
                        >
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="end_time">End Time (Local Time)</label>
                        <input
                            type="time"
                            class="form-control @error('end_time') is-invalid @enderror"
                            name="end_time"
                            value="{{ old('end_time', optional($gameSetting->end_time)->setTimezone($adminTimezone)->format('H:i')) }}"
                            required
                        >
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="earning_percentage">Earning Percentage (%)</label>
                        <input
                            type="number"
                            step="0.01"
                            class="form-control @error('earning_percentage') is-invalid @enderror"
                            name="earning_percentage"
                            value="{{ old('earning_percentage', $gameSetting->earning_percentage) }}"
                            required
                            min="0"
                            max="100"
                        >
                        @error('earning_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Type Field --}}
                    <div class="mb-3">
                        <label for="type">Type</label>
                        <select class="form-control @error('type') is-invalid @enderror" name="type" required>
                            <option value="">Select Type</option>
                            <option value="daily" {{ old('type', $gameSetting->type) === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ old('type', $gameSetting->type) === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ old('type', $gameSetting->type) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Crypto Category Field --}}
                    <div class="mb-3">
                        <label for="crypto_category">Crypto Category</label>
                        <select class="form-control @error('crypto_category') is-invalid @enderror" name="crypto_category" required>
                            <option value="">Select Category</option>
                            <option value="BTC" {{ old('crypto_category', $gameSetting->crypto_category) === 'BTC' ? 'selected' : '' }}>Bitcoin (BTC)</option>
                            <option value="ETH" {{ old('crypto_category', $gameSetting->crypto_category) === 'ETH' ? 'selected' : '' }}>Ethereum (ETH)</option>
                            <option value="BNB" {{ old('crypto_category', $gameSetting->crypto_category) === 'BNB' ? 'selected' : '' }}>BNB</option>
                            <!-- Add more if needed -->
                        </select>
                        @error('crypto_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Game Duration --}}
                    <div class="mb-3">
                        <label for="game_duration">Game Duration (Minutes)</label>
                        <input
                            type="number"
                            class="form-control @error('game_duration') is-invalid @enderror"
                            name="game_duration"
                            value="{{ old('game_duration', $gameSetting->game_duration) }}"
                            required
                            min="1"
                        >
                        @error('game_duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Minimum Payout --}}
                    <div class="mb-3">
                        <label for="minimum_payout">Minimum Payout (in {{ $gameSetting->currency ?? 'TZS' }})</label>
                        <input
                            type="number"
                            step="0.01"
                            class="form-control @error('minimum_payout') is-invalid @enderror"
                            name="minimum_payout"
                            value="{{ old('minimum_payout', $gameSetting->minimum_payout) }}"
                            required
                            min="0"
                        >
                        @error('minimum_payout')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Is Active --}}
                    <div class="mb-3 form-check">
                        <input
                            type="checkbox"
                            class="form-check-input @error('is_active') is-invalid @enderror"
                            name="is_active"
                            id="is_active"
                            value="1"
                            {{ old('is_active', $gameSetting->is_active) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="is_active">Is Active?</label>
                        @error('is_active')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Payout Enabled --}}
                    <div class="mb-3 form-check">
                        <input
                            type="checkbox"
                            class="form-check-input @error('payout_enabled') is-invalid @enderror"
                            name="payout_enabled"
                            id="payout_enabled"
                            value="1"
                            {{ old('payout_enabled', $gameSetting->payout_enabled) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="payout_enabled">Payout Enabled?</label>
                        @error('payout_enabled')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Game Setting</button>
                    <a href="{{ route('admin.game_settings.index') }}" class="btn btn-secondary">Cancel</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
