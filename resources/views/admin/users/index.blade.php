@extends('admin.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Users Sections</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    Userlist</span>
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
                    <div style="display: inline-block;">
                        <form method="GET">
                            <div class="input-group mb-5">
                                <form action="{{ route('users.index') }}">
                                <input type="text" name="search" value="{{ request()->get('search') }}"
                                    class="form-control" placeholder="Search..." aria-label="Search"
                                    aria-describedby="button-addon2">&nbsp;&nbsp;

                                <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>
                                &nbsp;&nbsp;
                                
                                    <select id='status' class="form-control" name="filter">

                                        <option {{ is_null(request()->input('filter')) ? 'selected' : '' }} value="0">
                                            -Select-</option>

                                        <option {{ request()->input('filter') == 1 ? 'selected' : '' }} value="1">
                                            Alphabetical</option>

                                        <option {{ request()->input('filter') == 2 ? 'selected' : '' }} value="2">
                                            Most orders</option>

                                        <option {{ request()->input('filter') == 3 ? 'selected' : '' }} value="3">
                                            Date of registration</option>

                                    </select>&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-warning">Sort</button>
                                    &nbsp;&nbsp;
                                    <select id='status' class="form-control" name="export">

                                        <option {{ is_null(request()->input('export')) ? 'selected' : 'selected' }} value="">
                                            -Select-</option>

                                        <option {{ request()->input('export') == 1 }} value="1">PDF
                                        </option>

                                        <option {{ request()->input('export') == 2  }} value="2">
                                            EXCEL</option>

                                        <option {{ request()->input('export') == 3  }} value="3">CSV
                                        </option>
                                    </select>&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-success">Export</button>
                                </form>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive border-top userlist-table">
                        <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th class="wd-lg-20p"><span>Name</span></th>
                                    <th class="wd-lg-20p"><span>Email</span></th>
                                    {{-- <th class="wd-lg-20p"><span>Roles</span></th> --}}
                                    <th class="wd-lg-20p"><span>Orders</span></th>
                                    <th class="wd-lg-20p"><span>Status</span></th>
                                    <th class="wd-lg-20p"><span>Created at</span></th>

                                    <th class="wd-lg-20p">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                        <td>
                                            <a>{{ $user->email }}</a>
                                        </td>
                                        {{-- <td>
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                </td> --}}
                                        <td>
                                            <a
                                                href="{{ route('show_orders_user', $user->id) }}">Orders({{ $user->orders_count }})</a>
                                        </td>
                                        <td class="text-center">
                                            @if ($user->status == '1')
                                                <span class="label text-success d-flex">
                                                    <div class="dot-label bg-success mr-1"></div> Active
                                                @else
                                                    <span class="label text-muted d-flex">
                                                        <div class="dot-label bg-gray-300 mr-1"></div>Inactive
                                            @endif
                                        </td>
                                        <td>
                                            <a>{{ $user->created_at }}</a>
                                        </td>

                                        <td>
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-primary">
                                                <i class="las la-search"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">
                                                <i class="las la-pen"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="post"
                                                style="display: inline-block;">
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
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->
@endsection
