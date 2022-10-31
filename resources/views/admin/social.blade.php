@extends('admin.layouts.master')
@section('content')
    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Update User Info</h4>
                </div>
                <div class="card-body pt-0">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @foreach ($lookups as $lookup)
                    <form method="POST" action="{{ route('lookups.update',$lookup->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="">
                            <div class="form-group">
                                <label>facebook url</label>
                                <input type="text" name="facebook_url" class="form-control" placeholder="Enter First name"
                                    value="{{ $lookup->facebook_url }}">
                            </div>
                            <div class="form-group">
                                <label>instagram url</label>
                                <input type="text" name="instagram_url" class="form-control" placeholder="Enter Last name"
                                    value="{{ $lookup->instagram_url }}">
                            </div>
                            <div class="form-group">
                                <label>twitter url</label>
                                <input type="text" name="twitter_url" class="form-control" placeholder="Enter Last name"
                                    value="{{ $lookup->twitter_url }}">
                            </div>
                            <div class="form-group">
                                <label>snapchat url</label>
                                <input type="text" name="snapchat_url" class="form-control" placeholder="Enter Last name"
                                    value="{{ $lookup->snapchat_url }}">
                            </div>
                            <div class="form-group">
                                <label>whatsApp number</label>
                                <input type="tel" name="whatsApp_number" class="form-control" placeholder="Enter Phone number"
                                    value="{{ $lookup->whatsApp_number }}">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Save Changes</button>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
