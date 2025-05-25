@extends('admin.dashbord.pages.layout') {{-- Ensure this path is correct for your main layout --}}

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Add New Game Setting</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.game_settings.index') }}">Game Settings List</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add New Game Setting</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                {{-- Display success/error messages --}}
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.game_settings.store') }}">
                    @csrf

                    {{-- If you have a 'name' field for the game setting --}}
                    {{--
                    <div class="mb-3">
                        <label for="name" class="form-label">Game Name / Description</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    --}}

                    <div class="mb-3">
                        {{-- Clarified label for timezone --}}
                        <label for="start_time" class="form-label">Start Time (HH:MM - Your Local Time)</label>
                        <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                        @error('start_time')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        {{-- Clarified label for timezone --}}
                        <label for="end_time" class="form-label">End Time (HH:MM - Your Local Time)</label>
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                        @error('end_time')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="earning_percentage" class="form-label">Earning Percentage (%)</label>
                        <input type="number" step="0.01" class="form-control @error('earning_percentage') is-invalid @enderror" id="earning_percentage" name="earning_percentage" value="{{ old('earning_percentage') }}" required min="0" max="100">
                        @error('earning_percentage')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Is Active?</label>
                        @error('is_active')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input @error('payout_enabled') is-invalid @enderror" id="payout_enabled" name="payout_enabled" value="1" {{ old('payout_enabled') ? 'checked' : '' }}>
                        <label class="form-check-label" for="payout_enabled">Payout Enabled?</label>
                        @error('payout_enabled')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Game Setting</button>
                    <a href="{{ route('admin.game_settings.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
