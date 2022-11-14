@extends('admin.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Contact us Sections</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    Contact us list</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Contact us Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all Contact us Messages</p>
                </div>
                <div class="card-body">
                    @if (count($submisions) > 0)


                        <div style="display: inline-block;">
                            <form method="GET">
                                <div class="input-group mb-5">
                                    <form action="{{ route('contact.index') }}">
                                        <input type="text" name="search" value="{{ request()->get('search') }}"
                                            class="form-control" placeholder="Search..." aria-label="Search"
                                            aria-describedby="button-addon2">&nbsp;&nbsp;

                                        <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive border-top userlist-table">
                            <table class="table card-table table-striped table-vcenter text-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-lg-20p"><span>Name</span></th>
                                        <th class="wd-lg-20p"><span>Email</span></th>
                                        <th class="wd-lg-20p"><span>Mobile Number</span></th>
                                        <th class="wd-lg-20p"><span>Message</span></th>
                                        <th class="wd-lg-20p"><span>Date of submission</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($submisions as $key => $submision)
                                        <tr>
                                            <td>{{ $submision->name }}</td>
                                            <td>
                                                <a>{{ $submision->email }}</a>
                                            </td>
                                            <td>
                                                <a>{{ $submision->mobile }}</a>
                                            </td>
                                            <td>
                                                <textarea disabled>{{ $submision->message }}</textarea>
                                            </td>
                                            <td>
                                                <a>{{ $submision->created_at }}</a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            {{ $submisions->links() }}
                        </div>
                        @else
                        No Messages Found!
                    @endif
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->
@endsection
