@extends('admin.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Celebrities Sections</h4><span
                    class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    Celebrities list</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Celebrities Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all celebrities</p>
                    <div class="row row-xs wd-xl-80p">
                        <div class="pull-right">
                            <a class="btn btn-primary-gradient btn-block" href="{{ route('celebrities.create') }}"> Create
                                New
                                Celebrity</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (count($celebrities) > 0)
                        <div style="display: inline-block;">
                            <form method="GET">
                                <div class="input-group mb-5">
                                    <form action="{{ route('admins.index') }}">
                                        <input type="text" name="search" value="{{ request()->get('search') }}"
                                            class="form-control" placeholder="Search..." aria-label="Search"
                                            aria-describedby="button-addon2">&nbsp;&nbsp;

                                        <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>
                                        &nbsp;&nbsp;

                                        <select id='status' class="form-control" name="filter">

                                            <option {{ is_null(request()->input('filter')) ? 'selected' : '' }}
                                                value="0">
                                                -Select-</option>

                                            <option {{ request()->input('filter') == 1 ? 'selected' : '' }} value="1">
                                                Alphabetical</option>



                                            <option {{ request()->input('filter') == 2 ? 'selected' : '' }} value="2">
                                                Date of registration</option>

                                        </select>&nbsp;&nbsp;
                                        <button type="submit" class="btn btn-warning">Sort</button>
                                        &nbsp;&nbsp;
                                        <select id='status' class="form-control" name="export">

                                            <option {{ is_null(request()->input('export')) ? 'selected' : '' }}
                                                value="">
                                                -Select-</option>

                                            <option {{ request()->input('export') == 1 ? 'selected' : '' }} value="1">
                                                PDF
                                            </option>

                                            <option {{ request()->input('export') == 2 ? 'selected' : '' }} value="2">
                                                EXCEL</option>

                                            <option {{ request()->input('export') == 3 ? 'selected' : '' }} value="3">
                                                CSV
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
                                        <th class="wd-lg-20p"><span>Username</span></th>
                                        <th class="wd-lg-20p"><span>Mobile</span></th>
                                        <th class="wd-lg-20p"><span>Status</span></th>
                                        <th class="wd-lg-20p"><span>Add by</span></th>
                                        <th class="wd-lg-20p"><span>Created at</span></th>

                                        <th class="wd-lg-20p">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($celebrities as $key => $celebrity)
                                        <tr>
                                            <td>{{ $celebrity->first_name . ' ' . $celebrity->last_name }}</td>

                                            <td>
                                                <a>{{ $celebrity->username }}</a>
                                            </td>
                                            <td>
                                                <a>{{ $celebrity->mobile }}</a>
                                            </td>
                                            <td class="text-center">
                                                @if ($celebrity->status == '1')
                                                    <span class="label text-success d-flex">
                                                        <div class="dot-label bg-success mr-1"></div> Active
                                                    @else
                                                        <span class="label text-muted d-flex">
                                                            <div class="dot-label bg-gray-300 mr-1"></div>Inactive
                                                @endif
                                            </td>
                                            <td>
                                                <a>{{ $celebrity->add_by }}</a>
                                            </td>
                                            <td>
                                                <a>{{ $celebrity->created_at }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('celebrities.edit', $celebrity->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="las la-pen"></i>
                                                </a>
                                                <form action="{{ route('celebrities.destroy', $celebrity->id) }}"
                                                    method="post" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return myFunction();">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            {{ $celebrities->links() }}
                        </div>
                        @else
                        No celebrities found!
                    @endif
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->
@endsection
