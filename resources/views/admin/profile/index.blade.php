@extends('admin.layouts.master')
@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Pages</h4><span
                    class="text-muted mt-1 tx-13 ml-2 mb-0">/ Profile</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-info btn-icon mr-2"><i class="mdi mdi-filter-variant"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-danger btn-icon mr-2"><i class="mdi mdi-star"></i></button>
            </div>
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" class="btn btn-warning  btn-icon mr-2"><i class="mdi mdi-refresh"></i></button>
            </div>
            <div class="mb-3 mb-xl-0">
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-primary">14 Aug 2019</button>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                            id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate"
                         data-x-placement="bottom-end">
                        <a class="dropdown-item" href="#">2015</a>
                        <a class="dropdown-item" href="#">2016</a>
                        <a class="dropdown-item" href="#">2017</a>
                        <a class="dropdown-item" href="#">2018</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->

    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            {{--                            <div class="main-img-user profile-user">--}}
                            {{--                                <img alt="" src="../../assets/img/faces/6.jpg"><a class="fas fa-camera profile-edit"--}}
                            {{--                                                                                  href="JavaScript:void(0);"></a>--}}
                            {{--                            </div>--}}
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">Name: {{$user->first_name . " " . $user->last_name}}</h5>
                                    <p class="main-profile-name-text">
                                        Role:
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                {{ $v }}
                                            @endforeach
                                        @endif</p>
                                </div>
                            </div>
                            <h6>Email</h6>
                            <div class="main-profile-bio">
                                {{$user->email}}
                            </div>
                            <h6>Phone</h6>
                            <div class="main-profile-bio">
                                {{$user->mobile ?: "null"}}
                            </div>
                            <!-- main-profile-bio -->
                            <hr class="mg-y-30">
                            <label class="main-content-label tx-13 mg-b-20">Address</label>
                            <div class="form-group">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mg-b-0 text-md-nowrap">
                                            @if(count($Address))
                                            <thead>
                                            <tr>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0; ?>
                                            @foreach($Address as $address)
                                                    <?php $i++; ?>
                                                <tr>
                                                    <td>{{$address->address}}</td>
                                                    <td>
                                                        <a href="{{ url('address',$address->id) }}"
                                                           class="btn btn-sm btn-primary"> Edit</a>
                                                        <form action="{{ url('address/destroy', $address->id) }}"
                                                              method="post" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            @else
                                            No Address Found
                                            @endif
                                        </table>
                                    </div>
                                </div>

                                {{--                                    <p>{{ $i . "-" .$address->address ?: null}} <a href="{{ url('address',$address->id) }}" class="btn btn-sm btn-primary"> Edit</a></p>--}}
                            </div>
                            <!--skill bar-->
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                            <li class="active">
                                <a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i
                                            class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">ABOUT ME</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#profile" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i
                                            class="las la-images tx-15 mr-1"></i></span> <span
                                        class="hidden-xs">GALLERY</span> </a>
                            </li>
                            <li class="">
                                <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i
                                            class="las la-cog tx-16 mr-1"></i></span> <span class="hidden-xs">Add Address</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content border-left border-bottom border-right border-top-0 p-4">
                        <div class="tab-pane active" id="home">
                            <h4 class="tx-15 text-uppercase mb-3">BIOdata</h4>
                            <p class="m-b-5">Hi I'm Petey Cruiser,has been the industry's standard dummy text ever since
                                the 1500s, when an unknown printer took a galley of type. Donec pede justo, fringilla
                                vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a,
                                venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer
                                tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus.
                                Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p>
                            <div class="m-t-30">
                                <h4 class="tx-15 text-uppercase mt-3">Experience</h4>
                                <div class=" p-t-10">
                                    <h5 class="text-primary m-b-5 tx-14">Lead designer / Developer</h5>
                                    <p class="">websitename.com</p>
                                    <p><b>2010-2015</b></p>
                                    <p class="text-muted tx-13 m-b-0"></p>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="border p-1 card thumb">
                                        <a href="#" class="image-popup" title="Screenshot-2"> <img
                                                src="../../assets/img/photos/7.jpg" class="thumb-img"
                                                alt="work-thumbnail"> </a>
                                        <h4 class="text-center tx-14 mt-3 mb-0">Gallary Image</h4>
                                        <div class="ga-border"></div>
                                        <p class="text-muted text-center"><small>Photography</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="settings">
                            <form role="form" method="post" action="{{url('address/add')}}">
                                @csrf
                                <div class="form-group">
                                    <label for="FullName">Add new Address</label>
                                    <input type="text" name="address" value="John Doe" id="FullName"
                                           class="form-control">
                                </div>
                                <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

@endsection
