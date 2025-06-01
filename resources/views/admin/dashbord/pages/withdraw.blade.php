@extends('admin.dashbord.pages.layout')

@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <!-- Dashboard Summary Cards (unchanged) -->
                <div class="section">
                    <div class="row">
                        <!-- Your cards here... -->
                    </div>
                </div>

                <!-- Withdraw Requests Table -->
                <div class="card-box mb-10">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Withdraw Requests</h4>
                    </div>
                    <div class="pb-20">
                        <table class="table hover data-table-export nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Payment Address</th>
                                    <th>Status</th>
                                    <th>Requested At</th>
                                    <th>Paid At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdraws as $withdraw)
                                    <tr>
                                        <td>{{ $withdraw->id }}</td>
                                        <td>{{ $withdraw->user->username ?? 'N/A' }}</td>
                                        <td>${{ number_format($withdraw->amount, 2) }}</td>
                                        <td>
                                            <span id="address-{{ $withdraw->id }}">{{ $withdraw->payment_address }}</span>
                                            <button
                                                class="btn btn-sm btn-outline-primary copy-btn"
                                                data-clipboard-target="#address-{{ $withdraw->id }}">
                                                Copy
                                            </button>
                                        </td>
                                        <td>
                                            <span class="badge {{ $withdraw->status == 'pending' ? 'badge-warning' : 'badge-success' }}">
                                                {{ ucfirst($withdraw->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $withdraw->created_at ? $withdraw->created_at->format('d-m-Y H:i') : 'N/A' }}</td>
                                        <td>{{ $withdraw->updated_at ? $withdraw->updated_at->format('d-m-Y H:i') : 'N/A' }}</td>
                                        <td>
                                            <a class="btn btn-success btn-sm" href="#">Pay</a>
                                            <a href="#">__++__</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">{{ $withdraws->links() }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Include Clipboard.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
    <script>
        // Initialize Clipboard.js
        const clipboard = new ClipboardJS('.copy-btn');

        // Optional: User feedback
        clipboard.on('success', function(e) {
            e.trigger.innerText = 'Copied!';
            setTimeout(() => {
                e.trigger.innerText = 'Copy';
            }, 1500);
        });

        clipboard.on('error', function(e) {
            alert('Failed to copy!');
        });
    </script>
@endsection
