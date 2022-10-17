@extends('admin.layouts.master')
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Roles Sections</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/ RolesList</span>
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
                        <h4 class="card-title mg-b-0">Roles Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all roles</p>
                    <div class="row row-xs wd-xl-80p">

                        <div class="pull-right">
                            <a class="btn btn-primary-gradient btn-block" href="{{ route('roles.create') }}"> Create New
                                Role</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-md-nowrap">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>1</td>
                                    <td>{{$role->name}}</td>
                                    <td><a class="btn btn-dark-gradient" href="{{ route('roles.show',$role->id) }}"><i
                                                class="typcn  typcn typcn-zoom-in-outline "></i></a>
                                        <a class="btn btn-secondary-gradient"
                                           href="{{ route('roles.edit',$role->id) }}"><i
                                                class="typcn typcn-edit"></i></a>
                                        <form action="{{ route('roles.destroy', $role->id) }}"
                                              method="post" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger-gradient">
                                                <i
                                                    class="typcn typcn-trash"></i>
                                            </button>
                                        </form>
                                        {{--                                        <a class="btn btn-danger-gradient" href="{{ route('users.destroy',$user->id) }}"> <i--}}
                                        {{--                                                class="typcn typcn-trash"></i></a>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
    </div>
@endsection
