@extends('admin.layouts.master')
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Ads Sections</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ RolesList</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <!-- row opened -->
    <div class="row row-sm">
        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Ads Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all ads</p>
                    <div class="row row-xs wd-xl-80p">

                        <div class="pull-right">
                            <a class="btn btn-primary-gradient btn-block" href="{{ route('ads.create') }}"> Create New
                                Ads</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top userlist-table">
                        <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                            <thead>
                            <tr>
                                <th class="wd-lg-20p"><span>Image</span></th>
                                <th class="wd-lg-20p"><span>Name</span></th>
                                <th class="wd-lg-20p"><span>Status</span></th>
                                <th class="wd-lg-20p"><span>Priority</span></th>
                                <th class="wd-lg-20p">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ads as $ad)
                                <tr>
                                    <td>
                                        <img alt="avatar" class="rounded-circle avatar-md mr-2" src="{{asset('/storage/'. $ad->image)}}">
                                    </td>
                                    <td>{{$ad->name}}</td>
                                    <td class="text-center">
                                        @if($ad->status == "Active")
                                            <span class="label text-success d-flex"><div class="dot-label bg-success mr-1"></div>
                                        @else
                                                    <span class="label text-muted d-flex"><div class="dot-label bg-gray-300 mr-1"></div>
                                        @endif
                                        {{$ad->status}}
                                    </td>
                                    <td>
                                        <a>{{$ad->priority}}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('ads.edit',$ad->id) }}" class="btn btn-sm btn-info">
                                            <i class="las la-pen"></i>
                                        </a>
                                        <form action="{{ route('ads.destroy', $ad->id) }}"
                                              method="post" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="las la-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        {{$ads->links()}}
                    </div>
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
    </div>
@endsection
