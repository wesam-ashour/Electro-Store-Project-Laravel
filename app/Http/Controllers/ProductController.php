<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Category;
use App\Models\Color;
use App\Models\Coupons;
use App\Models\Image;
use App\Models\Material;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\Size;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
use Session;
use Stripe;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $products = Product::with('category')
            ->where('celebrity_id', $user->id)
            ->orderBy('id', 'ASC')
            ->paginate(5);
        return view('celebrity.products.index', compact('products'));
    }

    public function view(Request $request)
    {
        $query = Product::query()->with('category')->with('material');

        if ($request->ajax()) {
            $categoryId = $request->category;
            $products = Product::whereHas('category', function ($Q) use ($categoryId) {
                $Q->where('category_id', $categoryId);
            })->get();

            $renderview = view('render.renderView', compact('products'))->render();
            return response()->json([
                'success' => true,
                'html' => $renderview,
                'products' => $products
            ]);

        } else {
            $categories = Category::whereNotNull('parent_id')->get();
            $products = Product::with('category')->orderBy('id', 'ASC')->paginate(9);
            

        }
        $products = $query->paginate(9);
        $topSellings = Product::withCount('order')->orderBy('order_count','desc')->get();
        return view('products.store', compact('products', 'categories','topSellings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'offer_price' => ['required', 'string', 'max:255'],
            'slider_images' => ['required'],
            'cover' => ['required'],
            'material_id' => ['required'],
            'size_id' => ['required'],
        ]);


        $input = $request->all();
        $input['celebrity_id'] = Auth::user()->id;

        $file = $request->file('cover');
        $fileName = 'cover-' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('files/cover', $fileName);
        $input['cover'] = $path;

        Product::create($input);
        $article = Product::latest()->first();
        $article->category()->attach($request->category_id);
        $article->material()->attach($request->material_id);
        $article->size()->attach($request->size_id);

        if ($request->hasfile('slider_images')) {
            $images = $request->file('slider_images');
            $product_id = Product::latest()->first()->id;

            foreach ($images as $index => $image) {

                $name = 'product-slider_images-' . now(+$index) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('files/slider_images', $name);
                Image::create([
                    'name' => $name,
                    'path' => $path,
                    'product_id' => $product_id,
                    'celebrity_id' => Auth::user()->id,
                ]);
            }
        }

        foreach ($request->product_colors as $index => $object) {

            $key = $object['logo'];
            $name = 'product_color-' . now($index) . '.' . $key->getClientOriginalExtension();
            $color_image = $key->storeAs('files/color_images', $name);

            ProductColor::create([
                'product_id' => $article->id,
                'color_id' => $object['color'],
                'quantity' => $object['quantity'],
                'logo' => $color_image,
            ]);

        }

        return redirect(route('products.index'))->with('success', 'Product added successfully!');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $materials = Material::with('product')->get();
        $colorssd = Color::all();
        $sizes = Size::all();

        return view('celebrity.products.create', compact('categories', 'materials', 'colorssd', 'sizes'));
    }

    public function GetSubCatAgainstMainCatEdit($id)
    {
        echo json_encode(Category::where('parent_id', $id)->get());
    }

    public function show($id)
    {
        $product = Product::find($id);
        $products = Product::with('category')->orderBy('id', 'ASC')->paginate(4);
        return view('products.product', compact('product', 'products'));

    }

    public function edit(Product $product)
    {
        //        foreach ($product->color_product as $items) {
//            dd($items);
//        }

        foreach ($product->category as $item) {
            $r = $item->parent_id;
        }
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $materials = Material::with('product')->get();
        $colorssd = Color::all();
        $sizes = Size::all();
        return view('celebrity.products.edit', compact('product', 'categories', 'materials', 'colorssd', 'sizes', 'r'));
    }

    public function update(Request $request, Product $product)
    {

        //        dd($request->input());
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'offer_price' => ['required', 'string', 'max:255'],
            'slider_images' => ['sometimes'],
            'category_id' => ['required'],
            'cover' => ['sometimes'],
            'material_id' => ['required'],
            'size_id' => ['required'],
        ]);

        $input = $request->all();

        $input['category_id'] = 'default';
        $input['boutique_id'] = '1';
        $input['admin_id'] = Auth::user()->id;

        if (!request()->filled('cover')) {
            $input['cover'] = $product->cover;
        } else {
            $file = $request->file('cover');
            $fileName = 'cover-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('files/cover', $fileName);
            $input['cover'] = $path;
        }

        //        Product::update($input);
        $product->update($input);
        $article = $product->id;
        $product->category()->sync($request->category_id);
        $product->material()->sync($request->material_id);
        $product->size()->sync($request->size_id);

        if (!request()->filled('slider_images')) {
            if ($request->hasfile('slider_images')) {
                $images = $request->file('slider_images');
                $product_id = $product;

                foreach ($images as $index => $image) {

                    $name = 'product-slider_images-' . now(+$index) . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('files/slider_images', $name);
                    Image::create([
                        'name' => $name,
                        'path' => $path,
                        'product_id' => $product_id,
                        'admin_id' => Auth::user()->id,
                    ]);
                }
            }


        } else {

            $product_id = $product;
            foreach ($product->images as $p) {
                Image::query()
                    ->update([
                        'name' => $p->name,
                        'path' => $p->path,
                        'product_id' => $product_id,
                        'admin_id' => Auth::user()->id,
                    ]);
            }
        }

        foreach ($product->color_product as $index => $object) {
            dd($request->has('product_colors'));
            if (!request()->has($object['color'])& $object['quantity']) {

                ProductColor::query()
                    ->update([
                        'product_id' => $article,
                        'color_id' => $p->color_id,
                        'quantity' => $p->quantity,
                        'logo' => $p->logo,
                    ]);

            } else {

                $key = $object['logo'];
                $name = 'product_color-' . now($index) . '.' . $key->getClientOriginalExtension();
                $color_image = $key->storeAs('files/color_images', $name);

                ProductColor::create([
                    'product_id' => $article,
                    'color_id' => $object['color'],
                    'quantity' => $object['quantity'],
                    'logo' => $color_image,
                ]);


            }

        }

        return redirect(route('products.index'))->with('success', 'Product added successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        toastr()->error('Deleted Successfully', 'Delete');
        return redirect(route('products.index'));
    }

    public function cart()
    {
        $id = [];
        $cart = session()->get('cart', []);
        $remains = session()->get('remain', []);

        $result = array();
        //    dd($cart);
        return view('products.cart', compact('cart', 'result', 'remains'));

    }

    public function addToCart(Request $request, $id)
    {
        // dd($request->input());
        $request->validate([
            'size' => ['required', 'integer', 'min:1'],
            'color' => ['required', 'integer', 'min:1'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $remains = session()->get('remain', []);
        $total = 0;
        $sum = 0;

        if (isset($cart[$id])) {

            foreach ($cart[$id]['color_items'] as $key => $value) {
                if ($value['color'] == $request->color) {
                    toastr()->info('This product in the same color has already been added to the cart, You can adjust the required quantity from here', 'Info');
                    return redirect()->route('checkout.details', [$id]);
                }
            }

            $res = ProductColor::find($product->id);

            if ($request->quantity <= $res->quantity) {

                foreach ($cart[$id]['color_items'] as $index => $item)
                    $_item = $item;
                if ($_item['color'] == $request->color) {
                    $_item['quantity'] += $request->quantity;
                    unset($cart[$id]['color_items'][$index]);
                    //                array_push($cart[$id]['color_items'], $_item);
                    $cart[$id]['color_items'][] = $_item;

                    session()->put('cart', []);
                    // dd(1);
                    // session()->forget('remain');
                    session()->put('cart', $cart);
                } else {
                    $newArray = [
                        'size' => (int) $request->size,
                        'color' => (int) $request->color,
                        'quantity' => (int) $request->quantity,
                    ];
                    //                array_push($cart[$id]['color_items'], $newArray);
                    $cart[$id]['color_items'][] = $newArray;
                    // session()->forget('remain');
                    session()->put('cart', $cart);
                }

                if (session()->get('remain', [])) {
                    $total = 0;
                    foreach (session()->get('cart', []) as $key => $value) {
                        $sum = 0;
                        foreach ($value['color_items'] as $c) {
                            $sum += $c['quantity'];
                        }
                        $total += (Product::find($value['id'])->offer_price) * ($sum);
                    }

                    $totals = $total;
                    $value = session()->get('remain', [])['value'];
                    $code = session()->get('remain', [])['code'];

                    $remain = ((100 - ($value)) / 100) * $totals;

                    $remains = [
                        "remain" => $remain,
                        "code" => $code,
                        "value" => $value,
                    ];

                    session()->put('remain', []);
                    session()->put('remain', $remains);
                }



            } else {
                toastr()->error('Please enter an available quantity in stock', 'Failed');
                return back();
            }

        } else {
            $res = ProductColor::find($product->id);

            if ($request->quantity <= $res->quantity) {

                $cart[$id] = [
                    'id' => $product->id,
                    'color_items' => [
                        [
                            'size' => (int) $request->size,
                            'color' => (int) $request->color,
                            'quantity' => (int) $request->quantity,
                        ]
                    ],
                ];

                // session()->forget('remain');
                session()->put('cart', $cart);

            } else {
                toastr()->error('Please enter an available quantity in stock', 'Failed');
                return back();
            }

            if (session()->get('remain', [])) {

                foreach (session()->get('cart', []) as $key => $value) {
                    $sum = 0;
                    foreach ($value['color_items'] as $c) {
                        $sum += $c['quantity'];
                    }
                    $total += (Product::find($value['id'])->offer_price) * ($sum);
                }

                $totals = $total;
                $value = session()->get('remain', [])['value'];
                $code = session()->get('remain', [])['code'];

                $remain = ((100 - ($value)) / 100) * $totals;

                $remains = [
                    "remain" => $remain,
                    "code" => $code,
                    "value" => $value,
                ];

                session()->put('remain', []);
                session()->put('remain', $remains);
            }


        }
        // session()->forget('remain');
        $carts = session()->get('remain', []);



        toastr()->success('Product added to cart successfully!', 'Success');
        return redirect(route('cart'));
    }

    public function checkoutDetails(Request $request, $id)
    {
        $carts = session()->get('cart', '[]')[$id];
        return view('products.detailsCart', compact('carts'));
    }

    public function updateCart(Request $request)
    {

        $res = ProductColor::find($request->idProduct);

        if ($request->quantity <= $res->quantity) {

            $carts = session()->get('cart');
            $cart = session()->get('cart', [])[$request->idCart]['color_items'];
            $cart[$request->idItem]["quantity"] = (int) $request->quantity;
            unset($carts[$request->idCart]['color_items']);
            $carts[$request->idCart]['color_items'] = $cart;
            session()->put('cart', []);
            session()->put('cart', $carts);


            if (session()->get('remain', [])) {
                $total = 0;
                foreach (session()->get('cart', []) as $key => $value) {
                    $sum = 0;
                    foreach ($value['color_items'] as $c) {
                        $sum += $c['quantity'];
                    }
                    $total += (Product::find($value['id'])->offer_price) * ($sum);
                }

                $totals = $total;
                $value = session()->get('remain', [])['value'];
                $code = session()->get('remain', [])['code'];

                $remain = ((100 - ($value)) / 100) * $totals;

                $remains = [
                    "remain" => $remain,
                    "code" => $code,
                    "value" => $value,
                ];

                session()->put('remain', []);
                session()->put('remain', $remains);
            }

            session()->flash('success', 'Cart updated successfully');
            return back();

        } else {
            toastr()->error('Please enter an available quantity in stock', 'Failed');
            return back();
        }


    }


    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
                session()->forget('remain');
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function removeCartItems(Request $request)
    {
        $cart = session()->get('cart', []);

        $carts_ = session()->get('cart');
        $carts = session()->get('cart', [])[$request->idCart]['color_items'];
        unset($carts[$request->idItem]);
        $carts_[$request->idCart]['color_items'] = $carts;
        session()->put('cart', []);
        session()->put('cart', $carts_);
        if (count($carts) == 0) {
            $remove = session()->get('cart', [])[$request->idCart];
            unset($remove);
            $carts_ = $carts;
            session()->put('cart', $carts_);
        }
        session()->forget('remain');
        session()->flash('success', 'Product removed successfully');
        return redirect(route('cart'));
    }

    public function clearCart()
    {
        session()->forget('cart');
        session()->forget('remain');
        session()->flash('success', 'Cart cleared successfully');
        return redirect(route('cart'));
    }

    public function getCheckout(Request $request)
    {
        try {
            $remain = 0;
            $oldCart = session()->get('cart');
            $remains = session()->get('remain', []);
            $users = Auth::user()->id;
            $addresss = Address::where('user_id', $users)->orderBy('id', 'ASC')->paginate(3);
            if (Auth::check()) {

                if (count($remains)) {
                    $result = DB::table('coupons')->where(['code' => $remains['code']])->get();
                    $remain = 0;
                    if (isset($result[0])) {
                        if ($result[0]->status == 1) {
                            if ($result[0]->is_one_time == 1) {

                                $status = "error";
                                $msg = "coupon code already used";
                            } else {
                                $status = "success";
                                $msg = "coupon code applied";
                            }

                        } else {
                            $status = "error";
                            $msg = "coupon code deactivated";
                        }
                    } else {
                        $status = "error";
                        $msg = "Please enter valid coupon code";
                    }


                    if ($status == 'success') {
                        $total = $request->total;
                        $value = $result[0]->value;
                        // $remain = ((int)$total - (int)$value);
                        $remain = ($value / 100) * $total;
                        if (session()->has('cart')) {
                            $oldCart = session()->get('cart');
                        } else {
                            return view('admin.products');
                        }
                    }

                } else {


                    if (session()->has('cart')) {
                        $oldCart = session()->get('cart');
                    } else {
                        toastr()->error('Please chose at leat one product to make checkout', 'Faild');
                        return redirect()->route('product.view');
                    }

                }

                return view('products.checkout', compact('oldCart', 'remain', 'remains', 'addresss'));

            } else {
                toastr()->error('Need login or rigster to compleate checkout', 'Failed');
                return redirect()->back();
            }
        } catch
        (Exception $e) {
            toastr()->error('Need login or rigster to compleate checkout', 'Failed');
            return redirect(route('cart'));
        }
    }

    public function placeOrder(Request $request)
    {
        if ($request->input('payment') == 'CODE') {

            $cart = session()->get('cart', []);
            $remains = session()->get('remain', []);


            if (count($remains)) {

                try {
                    $sum = 0;
                    $total = 0;
                    $total = $remains['remain'];
                    $r = DB::table('coupons')->where(['code' => $remains['code']])->get();
                    foreach ($cart as $id => $details) {
                        foreach ($details['color_items'] as $key => $c) {
                            $sum += $c['quantity'];
                        }
                    }


                    $order = Order::create([
                        'order_number' => 'ORD-' . strtoupper(uniqid()),
                        'user_id' => auth()->user()->id,
                        'status' => 'new',
                        'grand_total' => $total,
                        'item_count' => $sum,
                        'payment_status' => 0,
                        'payment_method' => 'COD',
                        'address_id' => $request->address,
                        'notes' => $request->notes,
                        'coupon_id' => $r[0]->id,
                    ]);

                    Coupons::find($r[0]->id)->decrement('min_order_amt');

                    $items = session()->get('cart');

                    foreach (session('cart') as $id => $details) {

                        $product = Product::where('title', Product::find($details['id'])->title)->first();

                        foreach ($details['color_items'] as $key => $c) {

                            $orderItem = new OrderItem([
                                'order_id' => $order->id,
                                'product_id' => $details['id'],
                                'quantity' => $c['quantity'],
                                'color_id' => $c['color'],
                                'size_id' => $c['size'],
                                'price' => Product::find($details['id'])->offer_price
                            ]);

                            $color = ProductColor::where('product_id',$details['id'])->decrement('quantity', $c['quantity']);

                            $order->items()->save($orderItem);

                        }
                    }

                    Transaction::create([
                        'user_id' => Auth()->user()->id,
                        'order_id' => $order->id,
                        'order_amount' => $total,
                        'payment_method' => 'COD',
                        'response' => 'No response',
                        'status' => 'pending'
                    ]);

                    if ($order->items()->save($orderItem)) {
                        session()->forget('remain');
                        session()->forget('cart');
                        return redirect()->route('cart')->with('success', 'Yor order successfully placed');
                    } else {
                        return redirect()->route('checkout.index')->with('error', 'Invalid Activity!');
                    }

                } catch
                (Exception $e) {
                    return redirect(route('cart'))->with('error', 'Invalid Activity!');
                }

            } else {

                $sum = 0;
                $total = 0;

                foreach ($cart as $id => $details) {
                    foreach ($details['color_items'] as $key => $c) {
                        $sum += $c['quantity'];
                    }
                    $total += Product::find($details['id'])->offer_price * $sum;
                }

                try {

                    $order = Order::create(['order_number' => 'ORD-' . strtoupper(uniqid()),
                        'user_id' => auth()->user()->id,
                        'status' => 'new',
                        'grand_total' => $total,
                        'item_count' => $sum,
                        'payment_status' => 0,
                        'payment_method' => 'COD',
                        'address_id' => $request->address,
                        'notes' => $request->notes,
                        'coupon_id' => null,]);

                    $items = session()->get('cart');

                    foreach (session('cart') as $id => $details) {

                        foreach ($details['color_items'] as $key => $c) {

                            $orderItem = new OrderItem([
                                'order_id' => $order->id,
                                'product_id' => $details['id'],
                                'quantity' => $c['quantity'],
                                'color_id' => $c['color'],
                                'size_id' => $c['size'],
                                'price' => Product::find($details['id'])->offer_price
                            ]);

                            $color = ProductColor::where('product_id',$details['id'])->decrement('quantity', $c['quantity']);

                            $order->items()->save($orderItem);

                        }

                    }

                    Transaction::create([
                        'user_id' => Auth()->user()->id,
                        'order_id' => $order->id,
                        'order_amount' => $total,
                        'payment_method' => 'COD',
                        'response' => 'No response',
                        'status' => 'pending'
                    ]);

                    if ($order->items()->save($orderItem)) {
                        session()->forget('remain');
                        session()->forget('cart');
                        return redirect()->route('cart')->with('success', 'Yor order successfully placed');
                    } else {
                        return redirect()->route('checkout.index')->with('error', 'Invalid Activity!');
                    }

                } catch
                (Exception $e) {
                    return redirect(route('cart'))->with('error', 'Invalid Activity!');
                }
            }

        } else {

            $cart = session()->get('cart', []);
            $remains = session()->get('remain', []);

            if (count($remains)) {
                $sum = 0;
                $total = 0;
                try {
                    $total = $remains['remain'];
                    $r = DB::table('coupons')->where(['code' => $remains['code']])->get();

                    $stripe = new \Stripe\StripeClient(
                        'sk_test_51LrHn8Lw9BmBv7zE61pS9iDdrgVW1hK03LoUwvsVhBpIhwFtFUqXxahbT1MHI6PlWLo43hWpOa4wvKuZLZiNbF7Q00EF0ytbDt'
                        );
                    $res = $stripe->charges->create([
                        'amount' => 100 * $total,
                        'currency' => 'usd',
                        'source' => 'tok_amex',
                        'description' => 'My First Test Charge (created for API docs at https://www.stripe.com/docs/api)',
                    ]);

                    $response = $stripe->charges->retrieve($res->id, []);

                    foreach ($cart as $id => $details) {
                        foreach ($details['color_items'] as $key => $c) {
                            $sum += $c['quantity'];
                        }
                        $total += Product::find($details['id'])->offer_price * $sum;
                    }

                    $order = Order::create([
                        'order_number' => 'ORD-' . strtoupper(uniqid()),
                        'user_id' => auth()->user()->id,
                        'status' => 'new',
                        'grand_total' => $total,
                        'item_count' => $sum,
                        'payment_status' => 1,
                        'payment_method' => 'credit card',
                        'address_id' => $request->address,
                        'notes' => $request->notes,
                        'coupon_id' => $r[0]->id,
                    ]);

                    Coupons::find($r[0]->id)->decrement('min_order_amt');

                    $items = session()->get('cart');

                    foreach (session('cart') as $id => $details) {
                        foreach ($details['color_items'] as $key => $c) {

                            $orderItem = new OrderItem([
                                'order_id' => $order->id,
                                'product_id' => $details['id'],
                                'quantity' => $c['quantity'],
                                'color_id' => $c['color'],
                                'size_id' => $c['size'],
                                'price' => Product::find($details['id'])->offer_price
                            ]);

                            $color = ProductColor::where('product_id',$details['id'])->decrement('quantity', $c['quantity']);


                            $order->items()->save($orderItem);

                        }
                    }

                    Transaction::create([
                        'user_id' => Auth()->user()->id,
                        'order_id' => $order->id,
                        'order_amount' => $total,
                        'payment_method' => 'credit card',
                        'response' => $response,
                        'status' => 'success'
                    ]);

                    if ($order->items()->save($orderItem)) {
                        session()->forget('remain');
                        session()->forget('cart');
                        return redirect()->route('cart')->with('success', 'Yor order successfully placed');
                    } else {
                        return redirect()->route('checkout.index')->with('error', 'Invalid Activity!');
                    }

                } catch
                (Exception $e) {
                    return redirect(route('cart'))->with('error', 'Invalid Activity!');
                }


            } else {

                $sum = 0;
                $total = 0;

                foreach ($cart as $id => $details) {
                    foreach ($details['color_items'] as $key => $c) {
                        $sum += $c['quantity'];
                    }
                    $total += Product::find($details['id'])->offer_price * $sum;
                }

                try {

                    $stripe = new \Stripe\StripeClient(
                        'sk_test_51LrHn8Lw9BmBv7zE61pS9iDdrgVW1hK03LoUwvsVhBpIhwFtFUqXxahbT1MHI6PlWLo43hWpOa4wvKuZLZiNbF7Q00EF0ytbDt'
                        );
                    $res = $stripe->charges->create([
                        'amount' => 100 * $total,
                        'currency' => 'usd',
                        'source' => 'tok_amex',
                        'description' => 'My First Test Charge (created for API docs at https://www.stripe.com/docs/api)',
                    ]);

                    $response = $stripe->charges->retrieve($res->id, []);

                    $order = Order::create(['order_number' => 'ORD-' . strtoupper(uniqid()),
                        'user_id' => auth()->user()->id,
                        'status' => 'new',
                        'grand_total' => $total,
                        'item_count' => $sum,
                        'payment_status' => 1,
                        'payment_method' => 'credit card',
                        'address_id' => $request->address,
                        'notes' => $request->notes,
                        'coupon_id' => null,]);

                    $items = session()->get('cart');

                    foreach (session('cart') as $id => $details) {
                        foreach ($details['color_items'] as $key => $c) {
                            $orderItem = new OrderItem([
                                'order_id' => $order->id,
                                'product_id' => $details['id'],
                                'quantity' => $c['quantity'],
                                'color_id' => $c['color'],
                                'size_id' => $c['size'],
                                'price' => Product::find($details['id'])->offer_price
                            ]);
                            $color = ProductColor::where('product_id',$details['id'])->decrement('quantity', $c['quantity']);
                            // dd($color);

                            $order->items()->save($orderItem);

                        }
                    }

                    Transaction::create([
                        'user_id' => Auth()->user()->id,
                        'order_id' => $order->id,
                        'order_amount' => $total,
                        'payment_method' => 'credit card',
                        'response' => $response,
                        'status' => 'success'
                    ]);

                    if ($order->items()->save($orderItem)) {
                        session()->forget('remain');
                        session()->forget('cart');
                        return redirect()->route('cart')->with('success', 'Yor order successfully placed');
                    } else {
                        return redirect()->route('checkout.index')->with('error', 'Invalid Activity!');
                    }

                } catch
                (Exception $e) {
                    return redirect(route('cart'))->with('error', 'Invalid Activity!');
                }


            }
        }
    }

    public
        function applyCouponCode(Request $request)
    {

        $result = DB::table('coupons')->where(['code' => $request->coupon_code])->get();
        $remains = session()->get('remain', []);

        $remain = 0;
        $value = 0;
        $code = 0;

        if (isset($result[0])) {
            if ($result[0]->status == 1) {
                if ($result[0]->is_one_time == 1) {

                    $status = "error";
                    $msg = "coupon code already used";
                } else {
                    $status = "success";
                    $msg = "coupon code applied";
                }

            } else {
                $status = "error";
                $msg = "coupon code deactivated";
            }
        } else {
            $status = "error";
            $msg = "Please enter valid coupon code";
        }


        if ($status == 'success') {
            $total = $request->total;
            $value = $result[0]->value;
            $code = $result[0]->code;

            $remain = ((100 - ($value)) / 100) * $total;

            $remains = [
                "remain" => $remain,
                "code" => $result[0]->code,
                "value" => $result[0]->value,
            ];
            session()->put('remain', []);
            session()->put('remain', $remains);
        }

        session()->put('remain', $remains);
        return response()->json(['status' => $status, 'msg' => $msg, 'remain' => $remain, 'value' => $value, 'code' => $code]);
    }

    public
        function removeCouponCode()
    {
        $remains = session()->get('remain', []);
        session()->forget('remain');
        session()->flash('success', 'coupon code removed successfully');
        return redirect(route('cart'));
    }

}