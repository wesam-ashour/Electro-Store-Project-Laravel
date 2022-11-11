@extends('celebrity.layouts.master')
@section('content')
    <style>
        .dott {
            height: 30px;
            width: 30px;
            border-radius: 50%;
            margin: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Colors Sections</h4><span class="text-muted mt-1 tx-13 ml-2 mb-0">/
                    RolesList</span>
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
                        <h4 class="card-title mg-b-0">Colors Table</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">List of all colors</p>
                    <div class="row row-xs wd-xl-80p">

                        <div class="pull-right">
                            <a class="btn btn-primary-gradient btn-block" href="{{ route('colors.create') }}"> Create New
                                Color</a>
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
                                    <th>Color</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($colors as $color)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $color->name }}</td>
                                        <td class="dott" style="background-color:{{ $color->color }}"></td>
                                        <td>
                                            <a class="btn btn-secondary-gradient"
                                                href="{{ route('colors.edit', $color->id) }}"><i
                                                    class="typcn typcn-edit"></i></a>
                                            <form action="{{ route('colors.destroy', $color->id) }}" method="post"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger-gradient">
                                                    <i class="typcn typcn-trash"></i>
                                                </button>
                                            </form>
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
