@extends('admin.layouts.master')
@section('content')
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-sm-12 col-lg-12 col-xl-12">
            <div class="">
                <a class="main-header-arrow" href="" id="ChatBodyHide"><i class="icon ion-md-arrow-back"></i></a>
                <div class="main-content-body main-content-body-contacts card custom-card">
                    <div class="main-contact-info-header pt-3">
                        <div class="media">
                            <div class="main-img-user">
                                <img alt="avatar" src="{{asset('assets/img/user.png')}}">
                            </div>
                            <div class="media-body">
                                <h5>{{$users->first_name . ' ' . $users->last_name}}</h5>
                                @if(!empty($users->getRoleNames()))
                                    @foreach($users->getRoleNames() as $v)
                                <p>{{$v}}</p>
                                    @endforeach
                                @else
                                    <p>Null</p>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="main-contact-info-body p-4">
{{--                        <div>--}}
{{--                            <h6>Biography</h6>--}}
{{--                            <p>Sed ut perspiciatis unde omnis iste natus</p>--}}
{{--                        </div>--}}
                        <div class="media-list pb-0">
                            <div class="media">
                                <div class="media-body">
                                    <div>
                                        <label>Mobile</label> <span class="tx-medium">{{$users->mobile}}</span>
                                    </div>
                                    <div>
                                        <label>Status</label> <span class="tx-medium">{{$users->status}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-body">
                                    <div>
                                        <label>Email Account</label> <span class="tx-medium">{{$users->email}}</span>
                                    </div>
                                    <div>
                                        <label>Added By</label> <span class="tx-medium">{{$users->add_by}}</span>
                                    </div>

                                </div>
                            </div>
                            <div class="media">
                                <div class="media-body">
                                    <div>
                                        <label>Current Addresses</label> <span class="tx-medium">
                                            @forelse ($addresss as $address)
                                            {{$loop->iteration}}- {{$address->area}}<br>
                                            @empty
                                                No address added
                                            @endforelse
                                            
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="media mb-0">
                                <div class="media-body">
                                    <div>
                                        <label>Account created before</label> <span class="tx-medium">{{$users->created_at->diffForHumans()}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
    </div>

@endsection
