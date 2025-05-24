@extends('admin.dashbord.pages.layout')

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="pd-20 card-box mb-30">
                <h4 class="text-blue h4 mb-20">{{ $pageTitle }}</h4>

                {{-- Form ya kuongeza referral level moja moja --}}
                <form action="{{ route('admin.referrals.store') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <label>Level (Eg 1, 2, 3)</label>
                            <input type="number" name="level" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-5">
                            <label>Commission Percentage (%)</label>
                            <input type="number" name="percent" class="form-control" step="0.01" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Add Level</button>
                        </div>
                    </div>
                </form>

                {{-- Orodha ya referrals zilizopo --}}
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Commission (%)</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($referrals as $referral)
                                <tr>
                                    <td>{{ $referral->level }}</td>
                                    <td>{{ $referral->percent }}%</td>
                                    <td>{{ $referral->created_at->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No referral levels added yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- SweetAlert for feedback --}}
@push('scripts')
<script>
    @if (session('success'))
        Swal.fire({ icon: 'success', title: 'Success!', text: '{{ session('success') }}' });
    @endif

    @if (session('error'))
        Swal.fire({ icon: 'error', title: 'Error!', text: '{{ session('error') }}' });
    @endif
</script>
@endpush

@endsection
