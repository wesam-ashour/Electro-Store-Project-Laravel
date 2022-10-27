@extends('layouts.master')
@section('content')
    <div class="container">
        <br>
        <strong>List of wishlists</strong>
        @if ($products->count())
    <table class="table">
        
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Product Name</th>
            <th scope="col">offer price</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($products as $product)
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{ $product->title }}</td>
            <td>{{ $product->offer_price }}</td>
            <td>
                <form action="{{ route('favorite.remove',$product->id) }}" method="POST"
                      onsubmit="return confirm('{{ trans('are You Sure ? ') }}');"
                      style="display: inline-block;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-danger"
                           value="Delete">
                </form>
            </td>
        </tr>
        @empty
            No products added to wish list yet!
        @endforelse
        </tbody>
    </table>
    @else
    <br>
    <br>
    <br>
    No products added to wish list yet!
    @endif
    </div>
@endsection
