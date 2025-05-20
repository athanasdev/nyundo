@extends('admin.dashbord.pages.layout')

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <!-- Profile Card Section -->
            <div class="row">
                <div class="col-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <div class="profile-photo text-center">
                            <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                            <img src="vendors/images/photo1.jpg" alt="" class="avatar-photo">
                        </div>
                        <h5 class="text-center h5 mb-0">Ross C. Lopez</h5>
                        <p class="text-center text-muted font-14">Lorem ipsum dolor sit amet</p>
                        <div class="profile-info">
                            <h5 class="mb-20 h5 text-blue">Contact Information</h5>
                            <ul>
                                <li><span>Email Address:</span> FerdinandMChilds@test.com</li>
                                <li><span>Phone Number:</span> 619-229-0054</li>
                                <li><span>Country:</span> America</li>
                                <li><span>Address:</span> 1807 Holden Street, San Diego, CA 92115</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Referral Levels Section -->
            <div class="row">
                <div class="col-12 mb-30">
                    <div class="pd-20 card-box height-100-p">
                        <h5 class="mb-20 h5 text-blue">Referral Levels</h5>
                        <ul>
                            <li><span>Level 0:</span> Username - JohnDoe, Deposited - $100</li>
                            <li><span>Level 1:</span> Username - JaneDoe, Deposited - $200</li>
                            <li><span>Level 2:</span> Username - MikeSmith, Deposited - $300</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
