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
						<table class="table hover multiple-select-row table-stripled data-table-export nowrap">
							<thead>
								<tr>
                                    <th>#</th>
									<th class="table-plus datatable-nosort">Id</th>
									<th>Username</th>
									<th>code</th>
									<th>status</th>
									<th>Request date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr>
                                    <td>1</td>
									<td class="table-plus">Gloria F. Mead</td>
									<td>25</td>
									<td>456899</td>
									<td>2829 Trainer Avenue Peoria, IL 61602 </td>
									<td>29-03-2018</td>
									<td>
                                         <span class="micon dw dw-copy"></span>
                                    </td>
								</tr>
								<tr>
                                    <td>2</td>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>30</td>
									<td>6789992</td>
									<td>1280 Prospect Valley Road Long Beach, CA 90802 </td>
									<td>29-03-2018</td>
									<td><span class="micon dw dw-copy"></span></td>
								</tr>
								<tr>
                                     <td>3</td>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>20</td>
									<td>879923456</td>
									<td>2829 Trainer Avenue Peoria, IL 61602 </td>
									<td>29-03-2018</td>
									<td>
                                        <span class="micon dw dw-copy"></span>
                                    </td>
								</tr>
								<tr>
                                    <td>4</td>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>30</td>
									<td>Sagittarius</td>
									<td>1280 Prospect Valley Road Long Beach, CA 90802 </td>
									<td>29-03-2018</td>
									<td>
                                        <span class="micon dw dw-copy"></span>
                                    </td>
								</tr>
								<tr>
                                    <td>5</td>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>25</td>
									<td>879923456</td>
									<td>2829 Trainer Avenue Peoria, IL 61602 </td>
									<td>29-03-2018</td>
									<td><span class="micon dw dw-copy"></span></td>
								</tr>
								<tr>
                                     <td>6</td>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>20</td>
									<td>87876123</td>
									<td>1280 Prospect Valley Road Long Beach, CA 90802 </td>
									<td>29-03-2018</td>
									<td><span class="micon dw dw-copy"></span></td>
								</tr>
								<tr>
                                    <td>7</td>
									<td class="table-plus">Andrea J. Cagle</td>
									<td>18</td>
									<td>879923456</td>
									<td>1280 Prospect Valley Road Long Beach, CA 90802 </td>
									<td>29-03-2018</td>
									<td><span class="micon dw dw-copy"></span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

			</div>

@endsection
