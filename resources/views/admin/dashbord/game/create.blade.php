@extends('admin.dashbord.pages.layout')

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>{{ isset($gameSetting) ? 'Edit' : 'Add New' }} Game Setting</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.game_settings.index') }}">Game Settings List</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ isset($gameSetting) ? 'Edit' : 'Add New' }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                @if (session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ isset($gameSetting) ? route('admin.game_settings.update', $gameSetting->id) : route('admin.game_settings.store') }}">
                    @csrf
                    @if(isset($gameSetting))
                        @method('PUT')
                    @endif

                    {{-- DATETIME INPUTS FOR PRECISION --}}
                    <div class="mb-3">
                        <label for="start_time" class="form-label"><b>Signal Start Time (Date and 24hr Time)</b></label>
                        <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time"
                               value="{{ old('start_time', isset($gameSetting) ? \Carbon\Carbon::parse($gameSetting->start_time)->format('Y-m-d\TH:i') : '') }}" required>
                        <div class="form-text">Input is based on your local timezone: {{ config('app.timezone') }}</div>
                    </div>

                    <div class="mb-3">
                        <label for="end_time" class="form-label"><b>Signal End Time (Date and 24hr Time)</b></label>
                        <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time"
                               value="{{ old('end_time', isset($gameSetting) ? \Carbon\Carbon::parse($gameSetting->end_time)->format('Y-m-d\TH:i') : '') }}" required>
                    </div>

                    {{-- OTHER FORM FIELDS --}}
                    <div class="mb-3">
                        <label for="earning_percentage" class="form-label">Earning Percentage (%)</label>
                        <input type="number" step="0.01" min="0" class="form-control @error('earning_percentage') is-invalid @enderror" id="earning_percentage" name="earning_percentage" value="{{ old('earning_percentage', $gameSetting->earning_percentage ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="buy" {{ old('type', $gameSetting->type ?? '') == 'buy' ? 'selected' : '' }}>Buy</option>
                            <option value="sell" {{ old('type', $gameSetting->type ?? '') == 'sell' ? 'selected' : '' }}>Sell</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="crypto_category" class="form-label">Crypto Category</label>
                        <select id="crypto_category" name="crypto_category" class="form-control" required>
                            <option value="XRP" {{ old('crypto_category', $gameSetting->crypto_category ?? '') == 'XRP' ? 'selected' : '' }}>XRP</option>
                            <option value="BTC" {{ old('crypto_category', $gameSetting->crypto_category ?? '') == 'BTC' ? 'selected' : '' }}>BTC</option>
                            <option value="ETH" {{ old('crypto_category', $gameSetting->crypto_category ?? '') == 'ETH' ? 'selected' : '' }}>ETH</option>
                            <option value="SOLANA" {{ old('crypto_category', $gameSetting->crypto_category ?? '') == 'SOLANA' ? 'selected' : '' }}>SOLANA</option>
                            <option value="PI" {{ old('crypto_category', $gameSetting->crypto_category ?? '') == 'PI' ? 'selected' : '' }}>PI</option>
                        </select>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $gameSetting->is_active ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Is Active?</label>
                    </div>

                     <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="payout_enabled" name="payout_enabled" value="1" {{ old('payout_enabled', $gameSetting->payout_enabled ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="payout_enabled">Payout Enabled?</label>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ isset($gameSetting) ? 'Update Setting' : 'Create Setting' }}</button>
                    <a href="{{ route('admin.game_settings.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
