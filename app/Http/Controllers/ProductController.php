<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrder;
use App\Http\Requests\StoreProducts;
use App\Http\Requests\UpdateProducts;
use App\Mail\PlaceOrderMail;
use App\Models\Address;
use App\Models\Category;
use App\Models\Celebrity;
use App\Models\Color;
use App\Models\Coupons;
use App\Models\Material;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\Size;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Session;
use Stripe\StripeClient;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $products = Product::with('category')->where('celebrity_id', $user->id)->orderBy('id', 'ASC')->paginate(10);
        return view('celebrity.products.index', compact('products'));
    }

    public function view(Request $request)
    {


        $query = Product::query()->with('category')->with('material')->where('status', 1);

        if ($request->ajax()) {
            $categoryId = $request->category;
            $products = Product::whereHas('category', function ($Q) use ($categoryId) {
                $Q->where('category_id', $categoryId)->where('status', 1);
            })->get();

            $renderview = view('render.renderView', compact('products'))->render();
            return response()->json(['success' => true, 'html' => $renderview, 'products' => $products]);

        } elseif ($request->filled('search')) {
            $categories = Category::whereNotNull('parent_id')->get();
            $products = Product::with('category')->where('title', 'Like', '%' . request('search') . '%')->where('status', 1)->orderBy('id', 'ASC')->paginate(9);
        } else {
            $categories = Category::whereNotNull('parent_id')->get();
            $products = Product::with('category')->where('status', 1)->orderBy('id', 'ASC')->paginate(9);
            // $products = $query->paginate(9);


        }
        $topSellings = Product::withCount('order')->where('status', 1)->orderBy('order_count', 'desc')->take(4)->get();
        return view('products.store', compact('products', 'categories', 'topSellings'));
    }

    public function store(StoreProducts $request)
    {


//        $file = $request->file('cover');
//        $resized_img = Image::make($file);
//        $resized_img->fit(600, 600)->save($file);
//        $fileName = 'cover-' . time() . '.' . $file->getClientOriginalExtension();
//        $path = $file->storeAs('files/cover', $fileName);

        $value = $request->file('cover');
        $name = time() . rand(1, 100) . '.' . $value->extension();
        $value->move('images/cover/', $name);

        $create_product = new Product();
        $create_product->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
        $create_product->description = ['en' => $request->description_en, 'ar' => $request->description_ar];
        $create_product->celebrity_id = Auth::user()->id;
        $create_product->cover = $name;
        $create_product->price = $request->price;
        $create_product->offer_price = $request->offer_price;
        $create_product->status = $request->status;
        $create_product->save();

        $article = Product::latest()->first();
        $article->category()->attach($request->category_id);
        $article->material()->attach($request->material_id);
        $article->size()->attach($request->size_id);


        foreach ($request->product_colors as $index => $object) {
            if (isset($object['color'], $object['quantity'], $object['logo'])) {
                $key = $object['logo'];
                $resized_img = Image::make($key);
                $resized_img->fit(600, 600)->save($key);
                $name = 'product_color-' . now($index) . '.' . $key->getClientOriginalExtension();
                $color_image = $key->storeAs('files/color_images', $name);

                ProductColor::create(['product_id' => $article->id, 'color_id' => $object['color'], 'quantity' => $object['quantity'], 'logo' => $color_image,]);

            }

        }

        return redirect(route('products.index'))->with('success', 'Product added successfully!');

    }

    public function create()
    {
        $user = Celebrity::find(auth()->user()->id);
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $materials = Material::with('product')->where('celebrity_id', $user->id)->get();
        $colorssd = Color::all()->where('celebrity_id', $user->id);
        $sizes = Size::all()->where('celebrity_id', $user->id);

        return view('celebrity.products.create', compact('categories', 'materials', 'colorssd', 'sizes'));
    }

    public function GetSubCatAgainstMainCatEdit($id)
    {
        $user = Celebrity::find(auth()->user()->id);
        echo json_encode(Category::where('parent_id', $id)->where('celebrity_id', $user->id)->get());
    }

    public function show($id)
    {
        $r = Product::where('id', $id)->first();
        $p = Product::find($id);

        if ($p->deleted_at !== null) {
            toastr()->error('No Product found', 'Erorr');
            return redirect(route('product.view'));
        } else {
            if ($r->status != 0) {
                $product = Product::find($id);
                $products = Product::with('category')->where('status', 1)->orderBy('id', 'ASC')->paginate(4);
                return view('products.product', compact('product', 'products'));
            } else {
                toastr()->error('No Product found', 'Erorr');
                return redirect(route('product.view'));
            }
        }
    }

    public function edit(Product $product)
    {
        foreach ($product->category as $item) {
            $r = $item->parent_id;
        }
        $user = Celebrity::find(auth()->user()->id);
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $materials = Material::with('product')->where('celebrity_id', $user->id)->get();
        $colorssd = Color::all()->where('celebrity_id', $user->id);
        $sizes = Size::all()->where('celebrity_id', $user->id);
        return view('celebrity.products.edit', compact('product', 'categories', 'materials', 'colorssd', 'sizes', 'r'));
    }

    public function edit_all_details_products(Request $request, $id)
    {
        $products = $id;
        $productsColor = ProductColor::where('product_id', $id)->get();
        return view('celebrity.products.product_detials', compact('productsColor', 'products'));
    }

    public function edit_details_products(Request $request, $id)
    {
        // dd($id);

        $productsColor = ProductColor::where('id', $id)->get();
        return view('celebrity.products.edit_product_detials', compact('productsColor'));
    }

    public function update_details_products(Request $request, $id)
    {
        // dd($request->file('logo'));
        $request->validate(['quantity' => ['required', 'integer', 'min:0'], 'logo' => ['sometimes', 'mimes:jpeg,png,jpg,gif'],]);

        $input = $request->all('quantity');

        if ($request->file('logo')) {
            $key = $request->file('logo');
            $name = 'product_color-' . time() . '.' . $key->getClientOriginalExtension();
            $color_image = $key->storeAs('files/color_images', $name);
            $input['logo'] = $color_image;
        }

        $productColor = ProductColor::find($id);
        $productColor->update($input);
        toastr()->info('Updated Successfully', 'Update');
        return redirect()->route('edit_all_details_products', ['id' => $productColor->product_id]);

    }

    public function update(UpdateProducts $request, Product $product)
    {
        $input = $request->all();
//        dd(request()->hasFile('cover'));
        $input['celebrity_id'] = Auth::user()->id;
        $input['title'] = ['en' => $request->title_en, 'ar' => $request->title_ar];
        $input['description'] = ['en' => $request->description_en, 'ar' => $request->description_ar];

        if (request()->hasFile('cover')) {
            $value = $request->file('cover');
            $name = time() . rand(1, 100) . '.' . $value->extension();
            $value->move('images/cover/', $name);
            $input['cover'] = $name;
        } else {
//            $file = $request->file('cover');
//            $resized_img = Image::make($file);
//            $resized_img->fit(600, 600)->save($file);
//            $fileName = 'cover-' . time() . '.' . $file->getClientOriginalExtension();
//            $path = $file->storeAs('files/cover', $fileName);
//            $input['cover'] = $path;
            $input['cover'] = $product->cover;
        }

        $product->update($input);
        $product->category()->sync($request->category_id);
        $product->material()->sync($request->material_id);
        $product->size()->sync($request->size_id);

        toastr()->info('Updated Successfully', 'Update');
        return redirect(route('products.index'));
    }

    public function create_color_product($id)
    {
        $product = $id;
        $colors = Color::all();
        return view('celebrity.products.create_product_color', compact('colors', 'product'));
    }

    public function store_color_product(Request $request, $id)
    {
        $request->validate(['quantity' => ['required', 'integer', 'min:0'], 'logo' => ['required', 'mimes:jpeg,png,jpg,gif'],]);

        $input = $request->all('quantity');

        if ($request->file('logo')) {
            $key = $request->file('logo');
            $name = 'product_color-' . time() . '.' . $key->getClientOriginalExtension();
            $color_image = $key->storeAs('files/color_images', $name);
            $input['logo'] = $color_image;
        }
        $input['product_id'] = $id;
        $input['color_id'] = $request->color_id;

        $productColor = ProductColor::create($input);
        toastr()->info('Created Successfully', 'Update');
        return redirect()->route('edit_all_details_products', ['id' => $id]);
    }

    public function delete_color_products($id)
    {
        ProductColor::find($id)->delete();
        toastr()->error('Deleted Successfully', 'Delete');
        return Redirect()->back();

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
        $request->validate(['size' => ['required', 'integer', 'min:1'], 'color' => ['required', 'integer', 'min:1'], 'quantity' => ['required', 'integer', 'min:1'],]);

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

            $res = ProductColor::where('product_id', $product->id)->where('color_id', $request->color)->first();

            if ($request->quantity <= $res->quantity) {


                foreach ($cart[$id]['color_items'] as $index => $item) $_item = $item;
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
                    $newArray = ['size' => (int)$request->size, 'color' => (int)$request->color, 'quantity' => (int)$request->quantity,];
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

                    $remains = ["remain" => $remain, "code" => $code, "value" => $value,];

                    session()->put('remain', []);
                    session()->put('remain', $remains);
                }


            } else {
                toastr()->error('Please enter an available quantity in stock', 'Failed');
                return back();
            }

        } else {
            $res = ProductColor::where('product_id', $product->id)->where('color_id', $request->color)->first();

            if ($request->quantity <= $res->quantity) {

                $cart[$id] = ['id' => $product->id, 'color_items' => [['size' => (int)$request->size, 'color' => (int)$request->color, 'quantity' => (int)$request->quantity,]],];

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

                $remains = ["remain" => $remain, "code" => $code, "value" => $value,];

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
        return view('products.detailsCart', compact('carts', 'id'));
    }

    public function updateCart(Request $request)
    {
        // dd($request->input());

        $res = ProductColor::where('product_id', $request->idProduct)->where('color_id', $request->color)->first();

        if ($request->quantity <= $res->quantity) {

            $carts = session()->get('cart');
            $cart = session()->get('cart', [])[$request->idCart]['color_items'];
            $cart[$request->idItem]["quantity"] = (int)$request->quantity;
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

                $remains = ["remain" => $remain, "code" => $code, "value" => $value,];

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
            return redirect(route('cart'));
        }
    }

    public function removeCartItems(Request $request)
    {

        $carts = session()->get('cart');
        $cart = session()->get('cart', [])[$request->id]['color_items'];
        unset($cart[$request->idItem]);
        $carts[$request->id]['color_items'] = $cart;
        session()->put('cart', []);
        session()->put('cart', $carts);

        if (count($carts[$request->id]['color_items']) == 0) {
            $carts = session()->get('cart');
            $cart = session()->get('cart', []);
            unset($cart[$request->id]);
            $carts = $cart;
            session()->put('cart', []);
            session()->put('cart', $carts);
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
            $addresss = Address::where('user_id', $users)->orderBy('id', 'ASC')->get();
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
        } catch (Exception $e) {
            toastr()->error('Need login or rigster to compleate checkout', 'Failed');
            return redirect(route('cart'));
        }
    }

    public function placeOrder(StoreOrder $request)
    {
        // dd($request->input());
        $user = Auth::user()->id;
        $user_email = User::find($user)->email;

        if ($request->input('payment') == 'CODE') {

            $cart = session()->get('cart', []);
            $remains = session()->get('remain', []);


            if (count($remains)) {

                try {
                    $sum = 0;
                    $total = 0;
                    $total = $remains['remain'];
                    $money = $total;
                    $r = DB::table('coupons')->where(['code' => $remains['code']])->get();
                    foreach ($cart as $id => $details) {
                        foreach ($details['color_items'] as $key => $c) {
                            $sum += $c['quantity'];
                        }
                    }


                    $order = Order::create(['order_number' => 'ORD-' . strtoupper(uniqid()), 'user_id' => auth()->user()->id, 'status' => '2', 'grand_total' => $money, 'item_count' => $sum, 'payment_status' => 0, 'payment_method' => 'COD', 'address_id' => $request->address, 'notes' => $request->notes, 'coupon_id' => $r[0]->id,]);


                    Coupons::find($r[0]->id)->decrement('min_order_amt');

                    $items = session()->get('cart');

                    foreach (session('cart') as $id => $details) {

                        $product = Product::where('title', Product::find($details['id'])->title)->first();

                        foreach ($details['color_items'] as $key => $c) {
                            $celebrity_id = Product::find($details['id'])->celebrity_id;
                            $orderItem = new OrderItem(['order_id' => $order->id, 'product_id' => $details['id'], 'celebrity_id' => $celebrity_id, 'quantity' => $c['quantity'], 'color_id' => $c['color'], 'size_id' => $c['size'], 'price' => Product::find($details['id'])->offer_price]);

                            $color = ProductColor::where('product_id', $details['id'])->where('color_id', $c['color'])->decrement('quantity', $c['quantity']);

                            $order->items()->save($orderItem);

                        }
                    }

                    Transaction::create(['user_id' => Auth()->user()->id, 'order_id' => $order->id, 'order_amount' => $money, 'payment_method' => 'COD', 'response' => 'No response', 'status' => 'pending']);

                    if ($order->items()->save($orderItem)) {
                        session()->forget('remain');
                        session()->forget('cart');
                        return redirect()->route('cart')->with('success', 'Yor order successfully placed');
                    } else {
                        return redirect()->route('checkout.index')->with('error', 'Invalid Activity!');
                    }

                    try {
                        $mailData = ['title' => 'Mail from Store', 'body' => 'Placed Order', 'order_number' => $order->order_number,];
                        Mail::to($user_email)->send(new PlaceOrderMail($mailData));
                    } catch (Exception $e) {
                        return redirect()->back();
                    }

                } catch (Exception $e) {
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
                    $order = Order::create(['order_number' => 'ORD-' . strtoupper(uniqid()), 'user_id' => auth()->user()->id, 'status' => '2', 'grand_total' => $total, 'item_count' => $sum, 'payment_status' => 0, 'payment_method' => 'COD', 'address_id' => $request->address, 'notes' => $request->notes, 'coupon_id' => null,]);

                    $items = session()->get('cart');

                    foreach (session('cart') as $id => $details) {

                        foreach ($details['color_items'] as $key => $c) {
                            $celebrity_id = Product::find($details['id'])->celebrity_id;

                            $orderItem = new OrderItem(['order_id' => $order->id, 'product_id' => $details['id'], 'celebrity_id' => $celebrity_id, 'quantity' => $c['quantity'], 'color_id' => $c['color'], 'size_id' => $c['size'], 'price' => Product::find($details['id'])->offer_price]);

                            $color = ProductColor::where('product_id', $details['id'])->where('color_id', $c['color'])->decrement('quantity', $c['quantity']);

                            $order->items()->save($orderItem);

                        }

                    }

                    Transaction::create(['user_id' => Auth()->user()->id, 'order_id' => $order->id, 'order_amount' => $total, 'payment_method' => 'COD', 'response' => 'No response', 'status' => 'pending']);

                    if ($order->items()->save($orderItem)) {
                        session()->forget('remain');
                        session()->forget('cart');
                        return redirect()->route('cart')->with('success', 'Yor order successfully placed');
                    } else {
                        return redirect()->route('checkout.index')->with('error', 'Invalid Activity!');
                    }

                    try {
                        $mailData = ['title' => 'Mail from Store', 'body' => 'Placed Order', 'order_number' => $order->order_number,];
                        Mail::to($user_email)->send(new PlaceOrderMail($mailData));
                    } catch (Exception $e) {
                        return redirect()->back();
                    }

                } catch (Exception $e) {
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
                    $money = $total;
                    $stripe = new StripeClient('sk_test_51LrHn8Lw9BmBv7zE61pS9iDdrgVW1hK03LoUwvsVhBpIhwFtFUqXxahbT1MHI6PlWLo43hWpOa4wvKuZLZiNbF7Q00EF0ytbDt');
                    $res = $stripe->charges->create(['amount' => 100 * $total, 'currency' => 'usd', 'source' => 'tok_amex', 'description' => 'My First Test Charge (created for API docs at https://www.stripe.com/docs/api)',]);

                    $response = $stripe->charges->retrieve($res->id, []);

                    foreach ($cart as $id => $details) {
                        foreach ($details['color_items'] as $key => $c) {
                            $sum += $c['quantity'];
                        }
                        $total += Product::find($details['id'])->offer_price * $sum;
                    }

                    $order = Order::create(['order_number' => 'ORD-' . strtoupper(uniqid()), 'user_id' => auth()->user()->id, 'status' => '2', 'grand_total' => $money, 'item_count' => $sum, 'payment_status' => 1, 'payment_method' => 'credit card', 'address_id' => $request->address, 'notes' => $request->notes, 'coupon_id' => $r[0]->id, 'charge_id' => $res->id,]);

                    Coupons::find($r[0]->id)->decrement('min_order_amt');

                    $items = session()->get('cart');

                    foreach (session('cart') as $id => $details) {
                        foreach ($details['color_items'] as $key => $c) {
                            $celebrity_id = Product::find($details['id'])->celebrity_id;

                            $orderItem = new OrderItem(['order_id' => $order->id, 'product_id' => $details['id'], 'celebrity_id' => $celebrity_id, 'quantity' => $c['quantity'], 'color_id' => $c['color'], 'size_id' => $c['size'], 'price' => Product::find($details['id'])->offer_price]);

                            $color = ProductColor::where('product_id', $details['id'])->where('color_id', $c['color'])->decrement('quantity', $c['quantity']);


                            $order->items()->save($orderItem);

                        }
                    }

                    Transaction::create(['user_id' => Auth()->user()->id, 'order_id' => $order->id, 'order_amount' => $money, 'payment_method' => 'credit card', 'response' => $response, 'status' => '1']);

                    if ($order->items()->save($orderItem)) {
                        session()->forget('remain');
                        session()->forget('cart');
                        return redirect()->route('cart')->with('success', 'Yor order successfully placed');
                    } else {
                        return redirect()->route('checkout.index')->with('error', 'Invalid Activity!');
                    }

                    try {
                        $mailData = ['title' => 'Mail from Store', 'body' => 'Placed Order', 'order_number' => $order->order_number,];
                        Mail::to($user_email)->send(new PlaceOrderMail($mailData));
                    } catch (Exception $e) {
                        return redirect()->back();
                    }

                } catch (Exception $e) {
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

                    $stripe = new StripeClient('sk_test_51LrHn8Lw9BmBv7zE61pS9iDdrgVW1hK03LoUwvsVhBpIhwFtFUqXxahbT1MHI6PlWLo43hWpOa4wvKuZLZiNbF7Q00EF0ytbDt');
                    $res = $stripe->charges->create(['amount' => 100 * $total, 'currency' => 'usd', 'source' => 'tok_amex', 'description' => 'My First Test Charge (created for API docs at https://www.stripe.com/docs/api)',]);

                    $response = $stripe->charges->retrieve($res->id, []);

                    $order = Order::create(['order_number' => 'ORD-' . strtoupper(uniqid()), 'user_id' => auth()->user()->id, 'status' => '2', 'grand_total' => $total, 'item_count' => $sum, 'payment_status' => 1, 'payment_method' => 'credit card', 'address_id' => $request->address, 'notes' => $request->notes, 'coupon_id' => null, 'charge_id' => $res->id,]);

                    $items = session()->get('cart');

                    foreach (session('cart') as $id => $details) {
                        foreach ($details['color_items'] as $key => $c) {
                            $celebrity_id = Product::find($details['id'])->celebrity_id;

                            $orderItem = new OrderItem(['order_id' => $order->id, 'product_id' => $details['id'], 'celebrity_id' => $celebrity_id, 'quantity' => $c['quantity'], 'color_id' => $c['color'], 'size_id' => $c['size'], 'price' => Product::find($details['id'])->offer_price]);
                            $color = ProductColor::where('product_id', $details['id'])->where('color_id', $c['color'])->decrement('quantity', $c['quantity']);
                            // dd($color);

                            $order->items()->save($orderItem);

                        }
                    }

                    Transaction::create(['user_id' => Auth()->user()->id, 'order_id' => $order->id, 'order_amount' => $total, 'payment_method' => 'credit card', 'response' => $response, 'status' => '1']);

                    if ($order->items()->save($orderItem)) {
                        session()->forget('remain');
                        session()->forget('cart');
                        return redirect()->route('cart')->with('success', 'Yor order successfully placed');
                    } else {
                        return redirect()->route('checkout.index')->with('error', 'Invalid Activity!');
                    }

                    try {
                        $mailData = ['title' => 'Mail from Store', 'body' => 'Placed Order', 'order_number' => $order->order_number,];
                        Mail::to($user_email)->send(new PlaceOrderMail($mailData));
                    } catch (Exception $e) {
                        return redirect()->back();
                    }

                } catch (Exception $e) {
                    return redirect(route('cart'))->with('error', 'Invalid Activity!');
                }
            }
        }
    }

    public function applyCouponCode(Request $request)
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
            $status = "error1";
            $msg = "Please enter valid coupon code";
        }


        if ($status == 'success') {
            $total = $request->total;
            $value = $result[0]->value;
            $code = $result[0]->code;

            $remain = ((100 - ($value)) / 100) * $total;

            $remains = ["remain" => $remain, "code" => $result[0]->code, "value" => $result[0]->value,];
            session()->put('remain', []);
            session()->put('remain', $remains);
        }

        session()->put('remain', $remains);
        return response()->json(['status' => $status, 'msg' => $msg, 'remain' => $remain, 'value' => $value, 'code' => $code]);
    }

    public function removeCouponCode()
    {
        $remains = session()->get('remain', []);
        session()->forget('remain');
        session()->flash('success', 'coupon code removed successfully');
        return redirect(route('cart'));
    }

}
