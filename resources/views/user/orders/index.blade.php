@extends('layouts.master')
@section('content')
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
<table class="table">
    <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">order number</th>
            <th scope="col">status</th>
            <th scope="col">total</th>
            <th scope="col">item count</th>
            <th scope="col">payment status</th>
            <th scope="col">address</th>
          </tr>
    </thead>
    <tbody>
        @foreach ($orders as  $order)
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$order->order_number}}</td>
            <td>{{$order->status}}</td>
            <td>{{$order->grand_total}}</td>
            <td>{{$order->item_count .' '. 'items'}}     <a style="color:blue; " href="{{route('orders.show',$order->id)}}">Details</a></td>
            <td>
              @if ($order->payment_status == 1)
              Success
              @endif
            </td>
            <td>{{$order->address}}</td>
          </tr>
        @endforeach
        
          
    </tbody>
  </table>
    </div></div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

@endsection