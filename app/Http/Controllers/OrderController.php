<?php

namespace App\Http\Controllers;

use App\Mail\CancelMail;
use App\Mail\CompleteMail;
use App\Mail\StatusMail;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductColor;
use App\Models\Status;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->orderBy(
                'id',
                'ASC'
            )
            ->paginate(
                10
            );

        return view('user.orders.index', compact('orders'));
    }

    public function trackOrder(Request $request, $id)
    {
        $order = Order::find($id);
        return view('user.orders.track', compact('order'));
    }

    public function cancelOrder($id)
    {
        $user = Auth::user()->id;
        $user_email = User::find($user)->email;
        $order = Order::find($id);
        $transaction = Transaction::where('order_id', $order->id)->first();

        if ($order->status == '3' || $order->status == '2') {


            if ($order->payment_method == 'COD') {
                $transaction = Transaction::where('order_id', $order->id)->first();

                $order->status = '1';
                $order->payment_status = 3;
                $order->save();
                $transaction->status = 3;
                $transaction->save();

            }

            foreach (OrderItem::where('order_id', $id)->get() as $key => $value) {
                $qty = $value->quantity;
                $res = ProductColor::where('product_id', $value->product_id)->where('color_id',$value->color_id)->increment('quantity', $qty);
            }

            if ($order->payment_method == 'credit card') {
                $transaction = Transaction::where('order_id', $order->id)->first();

                $stripe = new \Stripe\StripeClient(
                    'sk_test_51LrHn8Lw9BmBv7zE61pS9iDdrgVW1hK03LoUwvsVhBpIhwFtFUqXxahbT1MHI6PlWLo43hWpOa4wvKuZLZiNbF7Q00EF0ytbDt'
                    );
                $stripe->refunds->create(
                    [
                        'charge' => $order->charge_id,
                    ]
                );
                $order->status = 'refunded';
                $order->payment_status = 4;
                $order->save();
                $transaction->status = 3;
                $transaction->save();
            }

            $mailData = [
                'title' => 'Mail from Store',
                'body' => 'Update order status',
                'order_number' => $order->order_number,
            ];

            Mail::to($user_email)->send(new CancelMail($mailData));
            toastr()->success('Order Canceled Successfully', 'Canceled');
            return redirect()->back();

        } else {
            toastr()->error('There is something error', 'Erorr');
            return redirect()->back();
        }
    }

    public function completeOrder($id)
    {
        $user = Auth::user()->id;
        $user_email = User::find($user)->email;
        $order = Order::find($id);
        $transaction = Transaction::where('order_id', $order->id)->first();
        // dd($transaction);
        if ($order->status = '5') {
            $order->status = '6';
            $order->payment_status = 1;
            $order->save();
            $transaction->status = 1;
            $transaction->save();
            $mailData = [
                'title' => 'Mail from Store',
                'body' => 'Update order status',
                'order_number' => $order->order_number,
            ];

            Mail::to($user_email)->send(new CompleteMail($mailData));
            toastr()->success('Order complete Successfully', 'Success');
            return redirect()->back();
        } else {
            toastr()->error('There is something error', 'Erorr');
            return redirect()->back();
        }


    }

    public function show_orders_all()
    {
        $orders = Order::orderBy('id', 'ASC')->paginate(10);
        $status = Status::all();
        return view('admin.orders.index', compact('orders', 'status'));
    }
    public function edit_orders_status($id)
    {
        $order = Order::find($id);
        return view('admin.orders.edit', compact('order'));
    }
    public function update_orders_status(Order $order, Request $request)
    {
        // dd($request->input());

        $status = Order::find($order->id);
        $user_email = User::find($status->user_id)->email;
        $transaction = Transaction::where('order_id', $order->id)->first();

        if ($request->status == '3') {
            $status->status = '3';
            $status->save();
            $mailData = [
                'title' => 'Mail from Store',
                'body' => 'Update order status : pending',
                'order_number' => $status->order_number,
            ];
            Mail::to($user_email)->send(new StatusMail($mailData));
        } elseif ($request->status == '1') {

            if ($status->payment_method == 'COD') {

                $status->status = '1';
                $status->payment_status = 3;
                $status->save();
                $transaction->status = 3;
                $transaction->save();

            }

            foreach (OrderItem::where('order_id', $order->id)->get() as $key => $value) {
                $qty = $value->quantity;
                $res = ProductColor::where('product_id', $value->product_id)->where('color_id',$value->color_id)->increment('quantity', $qty);
            }

            if ($status->payment_method == 'credit card') {

                $stripe = new \Stripe\StripeClient(
                    'sk_test_51LrHn8Lw9BmBv7zE61pS9iDdrgVW1hK03LoUwvsVhBpIhwFtFUqXxahbT1MHI6PlWLo43hWpOa4wvKuZLZiNbF7Q00EF0ytbDt'
                    );
                $stripe->refunds->create(
                    [
                        'charge' => $status->charge_id,
                    ]
                );
                $status->status = 'refunded';
                $status->payment_status = 4;
                $status->save();
                $transaction->status = 3;
                $transaction->save();

            }

            $mailData = [
                'title' => 'Mail from Store',
                'body' => 'Update order status : canceled',
                'order_number' => $status->order_number,
            ];
            Mail::to($user_email)->send(new StatusMail($mailData));
        } elseif ($request->status == '4') {
            $status->status = '4';
            $status->save();
            $mailData = [
                'title' => 'Mail from Store',
                'body' => 'Update order status : being bagged',
                'order_number' => $status->order_number,
            ];
            Mail::to($user_email)->send(new StatusMail($mailData));
        } elseif ($request->status == '5') {
            $status->status = '5';
            $status->save();
            $mailData = [
                'title' => 'Mail from Store',
                'body' => 'Update order status : on the way',
                'order_number' => $status->order_number,
            ];
            Mail::to($user_email)->send(new StatusMail($mailData));
        } elseif ($request->status == '6') {
            $status->status = '6';
            $status->payment_status = 1;
            $status->save();
            $mailData = [
                'title' => 'Mail from Store',
                'body' => 'Update order status : delivered',
                'order_number' => $status->order_number,
            ];
            Mail::to($user_email)->send(new StatusMail($mailData));
        } else {
            toastr()->error('Something went error', 'Error');
            return redirect()->back();
        }



        // $input = $request->all('status');
        // $status = Order::find($order->id);
        // $status->update($input);
        toastr()->success('Updated Successfully', 'Update');
        return redirect()->back();
    }
    public function show_orders_all_details($id)
    {
        $orderItems = OrderItem::where('order_id', $id)->paginate(10);
        return view('admin.orders.show', compact('orderItems'));
    }
    public function address_for_order($id)
    {
        $order = Order::find($id);
        $addresses = Address::where('id', $order->address_id)->get();
        return view('admin.orders.address', compact('addresses', 'order'));
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