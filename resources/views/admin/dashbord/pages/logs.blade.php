@extends('admin.dashbord.pages.layout')

@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">


                <!-- Export Datatable start -->
                <div class="card-box mb-10">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Transactions</h4>
                    </div>
                    <div class="pb-20">
                        <div class="table-responseive">
                            <table class="table hover table-stripled data-table-export nowrap text-center">
                                <thead>
                                    <tr>
                                        <th class="table-plus">Id</th>
                                        <th>User Id</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Descriptions</th>
                                        <th>Created At</th>
                                        <th>Update At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $index => $transaction)
                                        <tr>
                                            <td class="table-plus">{{ $transaction->id }}</td>
                                            <td>{{ $transaction->user_id }}</td>
                                            <td>{{ $transaction->type }}</td>
                                            <td>$ {{ $transaction->amount }}</td>
                                            <td>{{ $transaction->description }} </td>
                                            <td>{{ $transaction->created_at ? $transaction->created_at->format('d-m-Y') : '--' }}
                                            </td>
                                            <td>{{ $transaction->updated_at ? $transaction->updated_at->format('d-m-Y') : '--' }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                        <div class="d-flex justify-content-end px-3 pb-3">
                            {{ $transactions->links() }}
                        </div>

                    </div>
                </div>

            </div>
        @endsection
