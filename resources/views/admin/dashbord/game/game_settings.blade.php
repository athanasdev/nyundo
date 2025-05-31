@extends('admin.dashbord.pages.layout') {{-- Ensure this path is correct for your main layout --}}

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">

            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Game Settings</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                {{-- <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.game_settings_overview') }}">Home</a></li> --}}
                                <li class="breadcrumb-item active" aria-current="page">Game Settings List</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <a href="{{ route('admin.game_settings.create') }}" class="btn btn-primary">Add New Game Setting</a>
                    </div>
                </div>
            </div>

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                {{-- Success/Error Messages --}}
                @if (session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Start Time (Local)</th>
                                <th>End Time (Local)</th>
                                <th>Earning (%)</th>
                                <th>Type</th>
                                <th>Crypto Category</th>
                                <th>Active</th>
                                <th>Payout Enabled</th>
                                <th>Created At (UTC)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $adminTimezone = \App\Models\GameSetting::getAdminTimezone();
                            @endphp

                            @forelse ($settings as $setting)
                                <tr>
                                    <td>{{ $setting->id }}</td>
                                    <td>{{ $setting->start_time->setTimezone($adminTimezone)->format('h:i A') }}</td>
                                    <td>{{ $setting->end_time->setTimezone($adminTimezone)->format('h:i A') }}</td>
                                    <td>{{ number_format($setting->earning_percentage, 2) }}%</td>
                                    <td>{{ ucfirst($setting->type) }}</td>
                                    <td>{{ $setting->crypto_category }}</td>
                                    <td>
                                        <span class="badge badge-{{ $setting->is_active ? 'success' : 'danger' }}">
                                            {{ $setting->is_active ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $setting->payout_enabled ? 'success' : 'danger' }}">
                                            {{ $setting->payout_enabled ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td>{{ $setting->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <a class="dropdown-item" href="{{ route('admin.game_settings.edit', $setting->id) }}">
                                                    <i class="dw dw-edit2"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.game_settings.destroy', $setting->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this game setting?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="dw dw-delete-3"></i> Delete
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.game_settings.toggle_investment', $setting->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="icon-copy dw dw-toggle"></i> Toggle Investment
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.game_settings.toggle_payout', $setting->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="icon-copy dw dw-toggle"></i> Toggle Payout
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No game settings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $settings->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
