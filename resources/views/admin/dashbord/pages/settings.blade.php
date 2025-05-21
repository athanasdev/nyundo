@extends('admin.dashbord.pages.layout')

@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">

                <!-- Referral Settings Table -->
                <div class="card-box mb-10">
                    <div class="pd-20">
                        <h4 class="text-blue h4">Referral Settings</h4>
                    </div>
                    <div class="pb-20">
                        <table class="table hover nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Level</th>
                                    <th>Commission Percentage (%)</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($referralSettings as $setting)
                                    <tr>
                                        <td>{{ $setting->id }}</td>
                                        <td>{{ $setting->level }}</td>
                                        <td>{{ number_format($setting->commission_percentage, 2) }}</td>
                                        <td>{{ $setting->created_at ? $setting->created_at->format('d-m-Y H:i') : 'N/A' }}
                                        </td>
                                        <td>{{ $setting->updated_at ? $setting->updated_at->format('d-m-Y H:i') : 'N/A' }}
                                        </td>
                                         <td>
                                             <button class="btn btn-primary btn-sm" type="submit">update</button>
                                         </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
