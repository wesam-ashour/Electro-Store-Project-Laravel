@extends('admin.layouts.master')
@section('content')
    <!-- row -->
    <div class="row row-sm" style="padding-top: 25px;">
        <div class="col-lg-7 col-xl-7 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Create New Material</h4>
                </div>
                <div class="card-body pt-0">
                    <form method="POST" action="{{route('coupons.store')}}">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="title" required>
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control"
                                       placeholder="code" required>
                                @error('code')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Value</label>
                                <input type="text" name="value" class="form-control"
                                       placeholder="value" required>
                                @error('value')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <div class="form-group">
                                    <div class="mb-4">
                                        <select name="type" class="form-control">
                                            
                                                <option value="percent">
                                                    percent
                                                </option>
                                        </select>
                                    </div>
                                </div>
                                
                                @error('type')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Min Orders Amount</label>
                                <input type="number" name="min_order_amt" class="form-control"
                                       placeholder="Min Order Amount" required>
                                @error('min_order_amt')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                    <div class="mb-4">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            @foreach (\App\Models\User::STATUS as $status)
                                                <option value="{{ $status }}">
                                                    @if ($status == 1)
                                                        Active
                                                    @else
                                                        In active
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
