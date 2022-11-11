@extends('admin.layouts.master')
@section('content')
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-sm-12 col-lg-12 col-xl-12">
            <div class="">
                <a class="main-header-arrow" href="" id="ChatBodyHide"><i class="icon ion-md-arrow-back"></i></a>
                <div class="main-content-body main-content-body-contacts card custom-card">
                    <div class="main-contact-info-header pt-3">
                        <div class="media">

                            <h5>Order details info</h5>
                        </div>
                    </div>

                    @foreach ($addresses as $address)
                        <div class="main-contact-info-body p-4">
                            <div class="media-list pb-0">
                                <div class="media">
                                    <div class="media-body">
                                        <div>
                                            <label>Full Name</label> <span class="tx-medium">{{ \App\Models\User::find($order->user_id)->first_name . ' ' . \App\Models\User::find($order->user_id)->last_name }}</span>
                                        </div>
                                        <div>
                                            <label>status</label> <span class="tx-medium">@if( \App\Models\User::find($order->user_id)->status == 1) active @else Not active @endif</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-body">
                                        <div>
                                            <label>Mobile</label> <span class="tx-medium">{{ \App\Models\User::find($order->user_id)->mobile }}</span>
                                        </div>
                                        <div>
                                            <label>Email</label> <span class="tx-medium">{{ \App\Models\User::find($order->user_id)->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-body">
                                        <div>
                                            <label>area</label> <span class="tx-medium">{{ $address->area }}</span>
                                        </div>
                                        <div>
                                            <label>block no</label> <span class="tx-medium">{{ $address->block_no }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-body">
                                        <div>
                                            <label>street no</label> <span
                                                class="tx-medium">{{ $address->street_no }}</span>
                                        </div>
                                        <div>
                                            <label>building type</label> <span
                                                class="tx-medium">{{ $address->building_type }}</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-body">
                                        <div>
                                            <label>house no</label> <span class="tx-medium">{{ $address->house_no }}</span>
                                        </div>
                                        <div>
                                            <label>building no</label> <span
                                                class="tx-medium">{{ $address->building_no }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="media mb-0">
                                    <div class="media-body">
                                        <div>
                                            <label>floor no</label> <span class="tx-medium">{{ $address->floor_no }}</span>
                                        </div>
                                        <div>
                                            <label>flat no</label> <span class="tx-medium">{{ $address->flat_no }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="media mb-0">
                                    <div class="media-body">
                                        <div>
                                            <label>landmark</label> <span class="tx-medium">{{ $address->landmark }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- End Row -->
    </div>
@endsection
