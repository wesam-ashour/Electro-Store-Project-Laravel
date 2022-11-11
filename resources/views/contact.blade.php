@extends('layouts.master')
@section('content')
     <!-- BREADCRUMB -->
     <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="#">{{ __('contact.Home') }}</a></li>
                        <li class="active">{{ __('contact.Contact_Us') }}</li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /BREADCRUMB -->
    <br>
    <div class="main-body">
        <div class="row">
            <div class="container">
                <section data-bs-version="5.1" class="form7 cid-tmuKNv2phb" id="form7-n">


                    <div class="container">
                        <div class="mbr-section-head">
                            <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-2">
                                <strong>{{ __('contact.Get_in_Touch') }}</strong>
                            </h3>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="">
                            <div class="col-lg-8 mx-auto mbr-form" data-form-type="formoid">
                                <form method="POST" action="{{ route('store_submisions') }}"
                                    class="mbr-form form-with-styler mx-auto" data-form-title="Form Name">
                                    @csrf
                                    <br>
                                    <p class="mbr-text mbr-fonts-style align-center mb-4 display-7">
                                        {{ __('contact.One') }}
                                    </p>
                                    <div class="dragArea row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group mb-3" data-for="name">
                                            <label>{{ __('contact.Name') }}</label>
                                            <input type="text" name="name" placeholder="{{ __('contact.Name') }}" data-form-field="name"
                                                class="form-control" value="" id="name-form7-n">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group mb-3" data-for="email">
                                            <label>{{ __('contact.Email') }}</label>
                                            <input type="email" name="email" placeholder="{{ __('contact.Email') }}" data-form-field="email"
                                                class="form-control" value="" id="email-form7-n">
                                        </div>
                                        <div data-for="phone" class="col-lg-12 col-md-12 col-sm-12 form-group mb-3">
                                            <label>{{ __('contact.Phone') }}</label>
                                            <input type="tel" name="mobile" placeholder="{{ __('contact.Phone') }}" data-form-field="phone"
                                                class="form-control" value="" id="phone-form7-n">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group mb-3" data-for="name">
                                            <label>{{ __('contact.Message') }}</label>
                                            <textarea type="text" name="message" placeholder="{{ __('contact.Message') }}" data-form-field="name" class="form-control" value=""
                                                id="name-form7-n"></textarea>
                                        </div>
                                       
                                    </div>
                                    <div class="col-auto mbr-section-btn align-center">
                                        <button type="submit" class="btn btn-primary display-4">{{ __('contact.Submit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
