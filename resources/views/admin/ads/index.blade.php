@extends('admin.layouts.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Ads Sections</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    AdsList</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <!-- row opened -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
                    @if (count($ads) > 0)
                        <div class="table-responsive border-top userlist-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="30px">#</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tablecontents">
                                    @foreach ($ads as $ad)
                                        <tr class="row1" data-id="{{ $ad->id }}">
                                            <td class="pl-3"><i class="fa fa-sort"></i></td>
                                            <td>
                                                <img alt="avatar"
                                                    style="object-fit: cover;
                                        width: 150x;
                                        height: 50px;"
                                                    src="{{ asset('images/ads/' . $ad->image) }}">
                                            </td>
                                            <td>{{ $ad->name }}</td>
                                            <td>
                                                @if ($ad->status == 1)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </td>
                                            <td>{{ $ad->created_at }}</td>
                                            <td>
                                                <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-sm btn-info">
                                                    <i class="las la-pen"></i>
                                                </a>
                                                <form action="{{ route('ads.destroy', $ad->id) }}" method="post"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return myFunction();">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        No Ads Found!
                    @endif
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
    </div>
@endsection
