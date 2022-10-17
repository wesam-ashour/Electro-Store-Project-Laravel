@extends('admin.layouts.master')
@section('content')
    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-6 col-md-12">
            <div class="card mg-b-20" id="list">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        List of permissions for {{$role->name}}
                    </div>
                    <p class="mg-b-20 text-muted card-sub-title">It is Very Easy to Preview and Customize</p>
                    <div class="text-wrap">
                        <div class="example">
                            <div class="listgroup-example ">
                                <ul class="list-group">
                                    <?php $i = 0; ?>
                                    <li>@if(!empty($rolePermissions))
                                            @foreach($rolePermissions as $v)
                                                    <?php $i++; ?>
                                                {{ $i . "-" }}
                                                <label class="label label-success">{{ $v->name }},</label>
                                                <br/>
                                            @endforeach
                                        @endif</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

@endsection
