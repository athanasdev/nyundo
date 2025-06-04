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
                                        {{-- <td>
                                            <span id="paymentAddressInput2">{{ $withdraw->payment_address }}</span>
                                            <button id="copyAddressButton1" class="btn btn-sm btn-outline-primary copy-btn ml-2">
                                                Copy
                                            </button>
                                        </td> --}}
                                        <td>
                                            <span class="payment-address">{{ $withdraw->payment_address }}</span>
                                            <button class="btn btn-sm btn-outline-primary copy-btn ml-2">
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
{{-- 
@section('scripts')
   

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
        // Copy Button Logic
        const copyBtn = document.getElementById("copyAddressButton1");
        const addressInput = document.getElementById("paymentAddressInput2");
        const feedback = document.getElementById("copyFeedbackDisplay");

        copyBtn?.addEventListener("click", function() {
            console.log("the button clicked")
            addressInput.select();
            addressInput.setSelectionRange(0, 99999); // for mobile
            navigator.clipboard.writeText(addressInput.value).then(() => {
                copyBtn.classList.add("copied");
                feedback.textContent = "Address copied!";
                setTimeout(() => {
                    copyBtn.classList.remove("copied");
                    feedback.textContent = "";
                }, 2000);
            });
        });

    });
    </script>
@endsection --}}

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyButtons = document.querySelectorAll('.copy-btn');

            copyButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const addressSpan = this.previousElementSibling;
                    const textToCopy = addressSpan.innerText;

                    navigator.clipboard.writeText(textToCopy).then(() => {
                        this.innerText = 'Copied!';
                        this.classList.add('btn-success');

                        setTimeout(() => {
                            this.innerText = 'Copy';
                            this.classList.remove('btn-success');
                        }, 2000);
                    }).catch(err => {
                        console.error('Copy failed', err);
                    });
                });
            });
        });
    </script>
@endsection
