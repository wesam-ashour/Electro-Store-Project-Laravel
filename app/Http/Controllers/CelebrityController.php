<?php

namespace App\Http\Controllers;

use App\Exports\CelebrityExport;
use App\Exports\OrderItemExport;
use App\Exports\OrdersExport;
use App\Http\Requests\StoreCelebrity;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Celebrity;
use App\Models\OrderItem;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\Order;

class CelebrityController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $celebrity = Celebrity::find($user->id)->id;
        $categories = Category::where('celebrity_id', $celebrity)->count();
        $products = Product::where('celebrity_id', $celebrity)->count();
        $orders = OrderItem::where('celebrity_id', $celebrity)->count();
        $newOrders = OrderItem::where('celebrity_id', $celebrity)->orderBy('id', 'DESC')->take(4)->get();

        return view('celebrity.dashboard', compact('user', 'categories', 'products', 'orders', 'newOrders'));
    }

    public function celebrities_view(Request $request)
    {
        if ($request->filled('search')) {

            $celebrities = Celebrity::where(
                function ($query) {
                    return $query
                        ->where('id', 'Like', '%' . request('search') . '%')
                        ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                        ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                        ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                        ->orwhere('username', 'Like', '%' . request('search') . '%');
                }
            )->paginate(10);
            if ($request->filled('filter') or $request->filled('export')) {

                if ($request->filter == 0 and $request->export == 1) {
                    $celebrities;
                    $pdf = Pdf::loadView('admin.celebrities.myPDF', compact('celebrities'));
                    return $pdf->download('celebrities.pdf');
                } elseif ($request->filter == 0 and $request->export == 2) {
                    $celebrities;
                    return Excel::download(new CelebrityExport($celebrities), 'celebrities-collection.xlsx');
                } elseif ($request->filter == 0 and $request->export == 3) {
                    $celebrities;
                    return (new CelebrityExport($celebrities))->download('celebrities.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 0) {
                    $celebrities;
                }

                if ($request->filter == 1 and $request->export == 1) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        }
                    )->orderBy('first_name')->paginate(10);
                    $pdf = Pdf::loadView('admin.celebrities.myPDF', compact('celebrities'));
                    return $pdf->download('celebrities.pdf');
                } elseif ($request->filter == 1 and $request->export == 2) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        }
                    )->orderBy('first_name')->paginate(10);
                    return Excel::download(new CelebrityExport($celebrities), 'celebrities-collection.xlsx');
                } elseif ($request->filter == 1 and $request->export == 3) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        }
                    )->orderBy('first_name')->paginate(10);
                    return (new CelebrityExport($celebrities))->download('celebrities.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 1) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        }
                    )->orderBy('first_name')->paginate(10);
                }

                if ($request->filter == 2 and $request->export == 1) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        }
                    )->orderBy('id', 'DESC')->paginate(10);
                    $pdf = Pdf::loadView('admin.celebrities.myPDF', compact('celebrities'));
                    return $pdf->download('celebrities.pdf');
                } elseif ($request->filter == 2 and $request->export == 2) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        }
                    )->orderBy('id', 'DESC')->paginate(10);
                    return Excel::download(new CelebrityExport($celebrities), 'celebrities-collection.xlsx');
                } elseif ($request->filter == 2 and $request->export == 3) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        }
                    )->orderBy('id', 'DESC')->paginate(10);
                    return (new CelebrityExport($celebrities))->download('celebrities.csv', \Maatwebsite\Excel\Excel::CSV);
                } elseif ($request->filter == 2) {
                    $celebrities = Celebrity::where(
                        function ($query) {
                            return $query
                                ->where('id', 'Like', '%' . request('search') . '%')
                                ->orwhere('first_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('last_name', 'Like', '%' . request('search') . '%')
                                ->orwhere('mobile', 'Like', '%' . request('search') . '%')
                                ->orwhere('username', 'Like', '%' . request('search') . '%');
                        }
                    )->orderBy('id', 'DESC')->paginate(10);
                }
            }


        } elseif ($request->filled('filter')) {

            if ($request->filter == 1 and $request->export == 1) {
                $celebrities = Celebrity::orderBy('first_name')->paginate(10);
                $pdf = Pdf::loadView('admin.celebrities.myPDF', compact('celebrities'));
                return $pdf->download('celebrities.pdf');
            } elseif ($request->filter == 1 and $request->export == 2) {
                $celebrities = Celebrity::orderBy('first_name')->paginate(10);
                return Excel::download(new CelebrityExport($celebrities), 'celebrities-collection.xlsx');
            } elseif ($request->filter == 1 and $request->export == 3) {
                $celebrities = Celebrity::orderBy('first_name')->paginate(10);
                return (new CelebrityExport($celebrities))->download('celebrities.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 1) {
                $celebrities = Celebrity::orderBy('first_name')->paginate(10);


            } elseif ($request->filter == 2 and $request->export == 1) {
                $celebrities = Celebrity::orderBy('id', 'DESC')->paginate(10);
                $pdf = Pdf::loadView('admin.celebrities.myPDF', compact('celebrities'));
                return $pdf->download('Most_orders.pdf');
            } elseif ($request->filter == 2 and $request->export == 2) {
                $celebrities = Celebrity::orderBy('id', 'DESC')->paginate(10);
                return Excel::download(new CelebrityExport($celebrities), 'celebrities-collection.xlsx');
            } elseif ($request->filter == 2 and $request->export == 3) {
                $celebrities = Celebrity::orderBy('id', 'DESC')->paginate(10);
                return (new CelebrityExport($celebrities))->download('celebrities.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 2) {
                $celebrities = Celebrity::orderBy('id', 'DESC')->paginate(10);


            } elseif ($request->filter == 0 and $request->export == 1) {
                $celebrities = Celebrity::paginate(10);
                $pdf = Pdf::loadView('admin.celebrities.myPDF', compact('celebrities'));
                return $pdf->download('Date_of_registration.pdf');
            } elseif ($request->filter == 0 and $request->export == 2) {
                $celebrities = Celebrity::paginate(10);
                return Excel::download(new CelebrityExport($celebrities), 'celebrities-collection.xlsx');
            } elseif ($request->filter == 0 and $request->export == 3) {
                $celebrities = Celebrity::paginate(10);
                return (new CelebrityExport($celebrities))->download('celebrities.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 0) {
                $celebrities = Celebrity::paginate(10);
            }

        } else {
            $celebrities = Celebrity::paginate(10);
        }
        return view('admin.celebrities.index', compact('celebrities'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCelebrity $request)
    {

        $user = Auth::user()->id;
        $admin_username = 'Admin: ' . ' ' . Admin::find($user)->first_name . ' ' . Admin::find($user)->last_name;

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['add_by'] = $admin_username;

        $user = Celebrity::create($input);

        return redirect()->route('celebrities_view')
            ->with('success', 'Celebrity created successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.celebrities.create');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Celebrity $celebrity
     * @return \Illuminate\Http\Response
     */
    public function show(Celebrity $celebrity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Celebrity $celebrity
     * @return \Illuminate\Http\Response
     */
    public function edit(Celebrity $celebrity)
    {
        return view('admin.celebrities.edit', compact('celebrity'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Celebrity $celebrity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Celebrity::find($id)->delete();
        return redirect()->route('celebrities_view')
            ->with('success', 'Celebrity deleted successfully');
    }

    public function get_all_orders(Request $request)
    {
        $id = Auth::user()->id;
        $celebrity_id = Celebrity::find($id)->id;
        $orders = OrderItem::where('celebrity_id', $celebrity_id)->paginate(10);

        if ($request->filled('filter')) {

            if ($request->filter == 1 and $request->export == 1) {

                $orders = OrderItem::where('celebrity_id', $celebrity_id)->where("created_at", ">", Carbon::now()->subMonths(3))->get();
                $pdf = Pdf::loadView('celebrity.orders.myPDF', compact('orders'));
                return $pdf->download('Order.pdf');
            } elseif ($request->filter == 1 and $request->export == 2) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->where("created_at", ">", Carbon::now()->subMonths(3))->get();
                return Excel::download(new OrderItemExport($orders), 'Order-collection.xlsx');
            } elseif ($request->filter == 1 and $request->export == 3) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->where("created_at", ">", Carbon::now()->subMonths(3))->get();
                return (new OrderItemExport($orders))->download('Order.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 1) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->where("created_at", ">", Carbon::now()->subMonths(3))->paginate(10);


            } elseif ($request->filter == 2 and $request->export == 1) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->where("created_at", ">", Carbon::now()->subMonths(6))->get();
                $pdf = Pdf::loadView('celebrity.orders.myPDF', compact('orders'));
                return $pdf->download('orders.pdf');
            } elseif ($request->filter == 2 and $request->export == 2) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->where("created_at", ">", Carbon::now()->subMonths(6))->get();
                return Excel::download(new OrderItemExport($orders), 'orders-collection.xlsx');
            } elseif ($request->filter == 2 and $request->export == 3) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->where("created_at", ">", Carbon::now()->subMonths(6))->get();
                return (new OrderItemExport($orders))->download('orders.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 2) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->where("created_at", ">", Carbon::now()->subMonths(6))->paginate(10);


            } elseif ($request->filter == 3 and $request->export == 1) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->where("created_at", ">", Carbon::now()->subMonths(9))->get();
                $pdf = Pdf::loadView('celebrity.orders.myPDF', compact('orders'));
                return $pdf->download('orders.pdf');
            } elseif ($request->filter == 3 and $request->export == 2) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->where("created_at", ">", Carbon::now()->subMonths(9))->get();
                return Excel::download(new OrderItemExport($orders), 'orders-collection.xlsx');
            } elseif ($request->filter == 3 and $request->export == 3) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->where("created_at", ">", Carbon::now()->subMonths(9))->get();
                return (new OrderItemExport($orders))->download('orders.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 3) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->where("created_at", ">", Carbon::now()->subMonths(9))->paginate(10);


            } elseif ($request->filter == 0 and $request->export == 1) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->get();
                $pdf = Pdf::loadView('celebrity.orders.myPDF', compact('orders'));
                return $pdf->download('orders.pdf');
            } elseif ($request->filter == 0 and $request->export == 2) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->get();
                return Excel::download(new OrderItemExport($orders), 'orders-collection.xlsx');
            } elseif ($request->filter == 0 and $request->export == 3) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->get();
                return (new OrderItemExport($orders))->download('orders.csv', \Maatwebsite\Excel\Excel::CSV);
            } elseif ($request->filter == 0) {
                $orders = OrderItem::where('celebrity_id', $celebrity_id)->paginate(10);
            }

        } else {
            $orders = OrderItem::where('celebrity_id', $celebrity_id)->paginate(10);
        }

        return view('celebrity.orders.index', compact('orders'));
    }

    public function profile($id)
    {
        $celebrity = Celebrity::find($id);
        return view('celebrity.auth.profile', compact('celebrity'));
    }

    public function update_profile_celebrity(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => 'required|unique:celebrities,username,' . $id,
            'password' => $request->password != null ? 'sometimes|required|min:8' : '',
            'mobile' => ['required', 'string', 'max:15', 'min:10'],
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = Celebrity::find($id);
        $user->update($input);

        return redirect()->back()->with('success', 'Celebrity Information updated successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Celebrity $celebrity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => 'required|unique:celebrities,username,' . $id,
            'password' => $request->password != null ? 'sometimes|required|min:8' : '',
            'mobile' => ['required', 'string', 'max:15', 'min:10'],
            'status' => 'required|min:1|max:50',
        ]);


        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = Celebrity::find($id);

        $user->update($input);

        if ($request->status == 0) {
            $products = Product::where('celebrity_id', $id)->get();
            foreach ($products as $key => $product) {
                $product->status = 0;
                $product->save();
            }
        }

        if ($request->status == 1) {
            $products = Product::where('celebrity_id', $id)->get();
            foreach ($products as $key => $product) {
                $product->status = 1;
                $product->save();
            }
        }

        return redirect()->route('celebrities_view')
            ->with('success', 'Celebrity updated successfully');

    }
}
