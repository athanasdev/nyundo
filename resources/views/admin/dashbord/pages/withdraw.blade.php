@extends('admin.dashbord.pages.layout')

@section('content')
    {{-- ... Your existing content section ... --}}
    {{-- (The HTML structure from the previous answer for the table goes here) --}}
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <div class="section">
                    <div class="row">
                    </div>
                </div>

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
                                            <button class="btn btn-sm btn-outline-primary copy-btn ml-2"
                                                data-clipboard-target="#address-{{ $withdraw->id }}">
                                                Copy
                                            </button>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $withdraw->status == 'pending' ? 'badge-warning' : 'badge-success' }}">
                                                {{ ucfirst($withdraw->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $withdraw->created_at ? $withdraw->created_at->format('d-m-Y H:i') : 'N/A' }}
                                        </td>
                                        <td>{{ $withdraw->updated_at && $withdraw->status != 'pending' ? $withdraw->updated_at->format('d-m-Y H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            @if ($withdraw->status == 'pending')
                                                <a class="btn btn-success btn-sm" href="{{-- route('admin.withdraw.process', $withdraw->id) --}}#">Pay</a>
                                            @else
                                                <span class="badge badge-success">Processed</span>
                                            @endif
                                            <a class="btn btn-secondary btn-sm ml-1"
                                                href="{{ url()->previous() }}">Return</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>

    <script>
        $(function() {
            console.log('Document ready. Attempting to initialize ClipboardJS...');

            if (typeof ClipboardJS === 'function') {
                console.log('ClipboardJS library is loaded.');

                if ($('.copy-btn').length > 0) {
                    console.log('Found ' + $('.copy-btn').length +
                        ' elements with class .copy-btn. Initializing ClipboardJS...');
                    const clipboard = new ClipboardJS('.copy-btn');

                    clipboard.on('success', function(e) {
                        console.log('Copy successful! Text:', e.text);
                        alert('Address "' + e.text + '" copied to clipboard!');

                        const originalText = e.trigger.innerText;
                        e.trigger.innerText = 'Copied!';
                        e.clearSelection();

                        setTimeout(function() {
                            e.trigger.innerText = originalText;
                        }, 2000);
                    });

                    clipboard.on('error', function(e) {
                        console.error('ClipboardJS Error:', e);
                        alert('Failed to copy address. Please try manually.');
                        e.clearSelection();
                    });

                } else {
                    console.warn('ClipboardJS: No elements with class .copy-btn found.');
                }

            } else {
                console.error('CRITICAL: ClipboardJS library NOT FOUND.');
                alert('Error: Clipboard functionality cannot be initialized.');
            }
        });
    </script>
@endsection
