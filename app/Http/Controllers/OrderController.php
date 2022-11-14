<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
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
use Exception;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
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
                $res = ProductColor::where('product_id', $value->product_id)->where('color_id', $value->color_id)->increment('quantity', $qty);
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
            toastr()->success('Order Canceled Successfully', 'Canceled');
            try {
                $mailData = [
                    'title' => 'Mail from Store',
                    'body' => 'Update order status',
                    'order_number' => $order->order_number,
                ];

                Mail::to($user_email)->send(new CancelMail($mailData));
            } catch
            (Exception $e) {
                return redirect()->back();
            }
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
        if ($order->status = '5') {
            $order->status = '6';
            $order->payment_status = 1;
            $order->save();
            $transaction->status = 1;
            $transaction->save();
            toastr()->success('Order complete Successfully', 'Success');
            try {
                $mailData = [
                    'title' => 'Mail from Store',
                    'body' => 'Update order status',
                    'order_number' => $order->order_number,
                ];
                Mail::to($user_email)->send(new CompleteMail($mailData));
            } catch
            (Exception $e) {
                return redirect()->back();
            }
            return redirect()->back();
        } else {
            toastr()->error('There is something error', 'Erorr');
            return redirect()->back();
        }


    }

    public function show_orders_all(Request $request)
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        $status = Status::all();

        if ($request->filled('search')) {
            $orders = Order::where(
                    function ($query) {
                        return $query
                            ->where('order_number', 'Like', '%' . request('search') . '%');       
                    }
                )->paginate(10);
            
        } elseif ($request->filled('filter')) {

            if ($request->filter == 1 and $request->export == 1) {
            
                $orders = Order::where("created_at",">", Carbon::now()->subMonths(3))->get();
                $pdf = Pdf::loadView('admin.orders.myPDF', compact('orders'));
                return $pdf->download('Order.pdf');
            } elseif ($request->filter == 1 and $request->export == 2) {
                $orders = Order::where("created_at",">", Carbon::now()->subMonths(3))->get();
                return Excel::download(new OrdersExport($orders), 'Order-collection.xlsx');
            } elseif ($request->filter == 1 and $request->export == 3) {
                $orders = Order::where("created_at",">", Carbon::now()->subMonths(3))->get();
                return (new OrdersExport($orders))->download('Order.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 1) {
                $orders = Order::where("created_at",">", Carbon::now()->subMonths(3))->paginate(10);


            } elseif ($request->filter == 2 and $request->export == 1) {
                $orders = Order::where("created_at",">", Carbon::now()->subMonths(6))->get();
                $pdf = Pdf::loadView('admin.orders.myPDF', compact('orders'));
                return $pdf->download('orders.pdf');
            } elseif ($request->filter == 2 and $request->export == 2) {
                $orders = Order::where("created_at",">", Carbon::now()->subMonths(6))->get();
                return Excel::download(new OrdersExport($orders), 'orders-collection.xlsx');
            } elseif ($request->filter == 2 and $request->export == 3) {
                $orders = Order::where("created_at",">", Carbon::now()->subMonths(6))->get();
                return (new OrdersExport($orders))->download('orders.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 2) {
                $orders = Order::where("created_at",">", Carbon::now()->subMonths(6))->paginate(10);


            } elseif ($request->filter == 3 and $request->export == 1) {
                $orders = Order::where("created_at",">", Carbon::now()->subMonths(9))->get();
                $pdf = Pdf::loadView('admin.orders.myPDF', compact('orders'));
                return $pdf->download('orders.pdf');
            } elseif ($request->filter == 3 and $request->export == 2) {
                $orders = Order::where("created_at",">", Carbon::now()->subMonths(9))->get();
                return Excel::download(new OrdersExport($orders), 'orders-collection.xlsx');
            } elseif ($request->filter == 3 and $request->export == 3) {
                $orders = Order::where("created_at",">", Carbon::now()->subMonths(9))->get();
                return (new OrdersExport($orders))->download('orders.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 3) {
                $orders = Order::where("created_at",">", Carbon::now()->subMonths(9))->paginate(10);



            } elseif ($request->filter == 0 and $request->export == 1) {
                $orders = Order::all();
                $pdf = Pdf::loadView('admin.orders.myPDF', compact('orders'));
                return $pdf->download('orders.pdf');
            } elseif ($request->filter == 0 and $request->export == 2) {
                $orders = Order::all();
                return Excel::download(new OrdersExport($orders), 'orders-collection.xlsx');
            } elseif ($request->filter == 0 and $request->export == 3) {
                $orders = Order::all();
                return (new OrdersExport($orders))->download('orders.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 0) {
                $orders = Order::paginate(10);
            }

        } else {
            $orders = Order::paginate(10);
        }


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
            toastr()->success('Updated Successfully', 'Update');
            try {
                $mailData = [
                    'title' => 'Mail from Store',
                    'body' => 'Update order status : pending',
                    'order_number' => $status->order_number,
                ];
                Mail::to($user_email)->send(new StatusMail($mailData));
            } catch
            (Exception $e) {
                return redirect()->back();
            }
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
                $res = ProductColor::where('product_id', $value->product_id)->where('color_id', $value->color_id)->increment('quantity', $qty);
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
            toastr()->success('Updated Successfully', 'Update');
            try {
                $mailData = [
                    'title' => 'Mail from Store',
                    'body' => 'Update order status : canceled',
                    'order_number' => $status->order_number,
                ];
                Mail::to($user_email)->send(new StatusMail($mailData));
            } catch
            (Exception $e) {
                return redirect()->back();
            }
        } elseif ($request->status == '4') {
            $status->status = '4';
            $status->save();
            toastr()->success('Updated Successfully', 'Update');
            try {
                $mailData = [
                    'title' => 'Mail from Store',
                    'body' => 'Update order status : being bagged',
                    'order_number' => $status->order_number,
                ];
                Mail::to($user_email)->send(new StatusMail($mailData));
            } catch
            (Exception $e) {
                return redirect()->back();
            }
        } elseif ($request->status == '5') {
            $status->status = '5';
            $status->save();
            toastr()->success('Updated Successfully', 'Update');
            try {
                $mailData = [
                    'title' => 'Mail from Store',
                    'body' => 'Update order status : on the way',
                    'order_number' => $status->order_number,
                ];
                Mail::to($user_email)->send(new StatusMail($mailData));
            } catch
            (Exception $e) {
                return redirect()->back();
            }
        } elseif ($request->status == '6') {
            $status->status = '6';
            $status->payment_status = 1;
            $status->save();
            toastr()->success('Updated Successfully', 'Update');
            try {
                $mailData = [
                    'title' => 'Mail from Store',
                    'body' => 'Update order status : delivered',
                    'order_number' => $status->order_number,
                ];
                Mail::to($user_email)->send(new StatusMail($mailData));
            } catch
            (Exception $e) {
                return redirect()->back();
            }
        } else {
            toastr()->error('Something went error', 'Error');
            return redirect()->back();
        }

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
        $orderDetails = OrderItem::where('order_id', $id)->get();
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