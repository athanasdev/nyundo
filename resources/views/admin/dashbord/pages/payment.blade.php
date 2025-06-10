@extends('admin.dashbord.pages.layout')

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card-box mb-10">
                <div class="pd-20">
                    <h4 class="text-blue h4">Payments</h4>
                </div>
                <div class="pb-20">
                    <div class="table-responsive">
                        <table class="table hover table-striped data-table-export nowrap text-center">
                            <thead>
                                <tr>
                                    <th class="table-plus">ID</th>
                                    <th>User ID</th>
                                    <th>Payment ID</th>
                                    <th>Amount</th>
                                    <th>Pay Address</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Processed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td class="table-plus">{{ $payment->id }}</td>
                                        <td>{{ $payment->user_id }}</td>
                                        <td>{{ $payment->payment_id }}</td>
                                        <td><strong>{{ rtrim($payment->pay_amount, '0.') }} {{ $payment->pay_currency }}</strong></td>
                                        <td>{{ $payment->pay_address ?? '--' }}</td>
                                        <td>
                                            @if ($payment->payment_status == 'confirmed' || $payment->payment_status == 'finished')
                                                <span class="badge badge-success">{{ ucfirst($payment->payment_status) }}</span>
                                            @elseif ($payment->payment_status == 'waiting')
                                                <span class="badge badge-warning">Waiting</span>
                                            @else
                                                <span class="badge badge-secondary">{{ ucfirst($payment->payment_status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $payment->created_at->format('d M, Y H:i') }}</td>
                                        <td>
                                            @if ($payment->is_processed)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-danger">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$payment->is_processed)
                                                <form action="{{ route('admin.payments.process', $payment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to mark this payment as processed?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        Process ✔️
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-success btn-sm" disabled>
                                                    Processed
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No payments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end px-3 pt-3">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
