@extends('admin.layouts.master')
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Users Sections</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ Userlist</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">USERS Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all users</p>
                    <div class="row row-xs wd-xl-80p">
                    <div class="pull-right">
                        <a class="btn btn-primary-gradient btn-block" href="{{ route('users.create') }}"> Create New
                            User</a>
                    </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top userlist-table">
                        <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                            <thead>
                            <tr>
                                <th class="wd-lg-20p"><span>Name</span></th>
                                <th class="wd-lg-20p"><span>Phone</span></th>
                                <th class="wd-lg-20p"><span>Roles</span></th>
                                <th class="wd-lg-20p"><span>Status</span></th>
                                <th class="wd-lg-20p"><span>Email</span></th>
                                <th class="wd-lg-20p">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $key => $user)
                            <tr>
                                <td>{{$user->first_name .' '. $user->last_name}}</td>
                                <td>
                                    {{$user->mobile ?: 'Null'}}
                                </td>
                                <td>
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($user->status == "Active")
                                        <span class="label text-success d-flex"><div class="dot-label bg-success mr-1"></div>
                                        @else
                                            <span class="label text-muted d-flex"><div class="dot-label bg-gray-300 mr-1"></div>
                                                @endif
                                        {{$user->status}}
                                </td>
                                <td>
                                    <a>{{$user->email}}</a>
                                </td>
                                <td>
                                    <a href="{{ route('users.show',$user->id) }}" class="btn btn-sm btn-primary">
                                        <i class="las la-search"></i>
                                    </a>
                                    <a href="{{ route('users.edit',$user->id) }}" class="btn btn-sm btn-info">
                                        <i class="las la-pen"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}"
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
                        {{$users->links()}}
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->
@endsection
