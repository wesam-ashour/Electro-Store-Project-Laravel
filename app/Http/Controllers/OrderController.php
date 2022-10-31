<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->orderBy('id', 'ASC')
            ->paginate(10);
        return view('user.orders.index', compact('orders'));
    }

    public function show_orders_all()
    {
        $orders = Order::orderBy('id', 'ASC')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
    public function edit_orders_status($id)
    {
        $order = Order::find($id);
        return view('admin.orders.edit', compact('order'));
    }
    public function update_orders_status(Order $order,Request $request)
    {
        $input = $request->all('status');
        $status = Order::find($order->id);
        $status->update($input);
        toastr()->success('Updated Successfully', 'Update');
        return redirect(route('show_orders_all'));
    }
    public function show_orders_all_details($id)
    {
        $orderItems = OrderItem::where('order_id',$id)->paginate(10);
        return view('admin.orders.show', compact('orderItems'));
    }
    public function address_for_order($id)
    {
        $addresses = Address::where('id',$id)->get();
        return view('admin.orders.address', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function show(Order $order, $id)
    {
        $orderDetails = DB::table('order_items')->where(['order_id' => $id])->get();
        return view('user.orders.show', compact('orderDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}