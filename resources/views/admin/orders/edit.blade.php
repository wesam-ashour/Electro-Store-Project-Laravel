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
                    <form method="POST" action="{{ route('update_orders_status', $order) }}">
                        @csrf
                        @method('PUT')
                        <div class="">
                            <div class="mb-4">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    @foreach (\App\Models\Order::STATUS as $status)
                                        <option value="{{ $status }}"
                                        {{ (old('status') ? old('status') : $order->status ?? '') == $status ? 'selected' : '' }}>
                                        {{$status}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
