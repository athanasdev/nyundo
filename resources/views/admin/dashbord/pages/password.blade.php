@extends('admin.dashbord.pages.layout')

@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <!-- Export Datatable start -->
                <div class="card-box mb-10">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Password Reset Request</h4>
                    </div>
                    <div class="pb-20">
                        <table class="table hover table-stripled data-table-export nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="table-plus datatable-nosort">Email</th>
                                    <th>Username</th>
                                    <th>Code</th>
                                    <th>Unique ID</th>
                                    <th>Request Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resetRequests as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="table-plus">{{ $item->email }}</td>
                                        <td>{{ $item->username ?? '-' }}</td>
                                        <td>
                                            {{ $item->code ?? '-' }}
                                        </td>
                                        <td>{{ $item->unique_id ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                                        <td>
                                            @if ($item->code)
                                                <button class="btn btn-sm btn-outline-primary"
                                                    onclick="copyToClipboard('{{ $item->code }}')">
                                                    <i class="dw dw-copy"></i> Copy
                                                </button>
                                            @else
                                                <span class="text-muted">No code</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        @endsection
