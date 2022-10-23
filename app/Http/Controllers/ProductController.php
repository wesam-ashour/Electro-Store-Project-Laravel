<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Image;
use App\Models\Material;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\Size;
use App\Models\Coupons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Stripe;

class  ProductController extends Controller
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
        return view('products.store', compact('products', 'categories'));
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


        }else{

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
            if (!request()->has($object['color']) & $object['quantity']) {

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
        toastr()->error('Deleted Successfully','Delete');
        return redirect(route('products.index'));
    }

    public function cart()

    {
        $id = [];
        $cart = session()->get('cart', []);
        $remains = session()->get('remain', []);

        $result = array();
        //    dd($remains);
        return view('products.cart', compact('cart', 'result','remains'));

    }

    public function addToCart(Request $request, $id)

    {

        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            foreach ($cart[$id]['color_items'] as $index => $item)
                $_item = $item;
            if ($_item['color'] == $request->color) {
                $_item['quantity'] += $request->quantity;
                unset($cart[$id]['color_items'][$index]);
//                array_push($cart[$id]['color_items'], $_item);
                $cart[$id]['color_items'][] = $_item;

                session()->put('cart', []);
                session()->forget('remain');
                session()->put('cart', $cart);
            } else {
                $newArray = [
                    'size' => (int)$request->size,
                    'color' => (int)$request->color,
                    'quantity' => (int)$request->quantity,
                ];
//                array_push($cart[$id]['color_items'], $newArray);
                $cart[$id]['color_items'][] = $newArray;
                session()->forget('remain');
                session()->put('cart', $cart);
            }

        } else {

            $cart[$id] = [
                'id' => $product->id,
                'color_items' => [
                    [
                        'size' => (int)$request->size,
                        'color' => (int)$request->color,
                        'quantity' => (int)$request->quantity,
                    ]
                ],
            ];
            session()->forget('remain');
            session()->put('cart', $cart);
        }
        session()->forget('remain');
        $carts = session()->get('remain', []);

        return redirect(route('cart'))->with('success', 'Product added to cart successfully!');
    }

    public function checkoutDetails(Request $request, $id)
    {
        $carts = session()->get('cart', '[]')[$id];
        return view('products.detailsCart', compact('carts'));
    }

    public function updateCart(Request $request)
    {
        $carts = session()->get('cart');
        $cart = session()->get('cart', [])[$request->idCart]['color_items'];
        $cart[$request->idItem]["quantity"] = (int)$request->quantity;
        unset($carts[$request->idCart]['color_items']);
        $carts[$request->idCart]['color_items'] = $cart;
        session()->put('cart', []);
        session()->put('cart', $carts);

        $remains = session()->get('remain', []);
        session()->forget('remain');

        session()->flash('success', 'Cart updated successfully');


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
        $remain = 0;
        $oldCart = session()->get('cart');
        $remains = session()->get('remain', []);
        if (Auth::check()) {
            
        if (count($remains)){
            $result =DB::table('coupons')->where(['code'=>$remains['code']])->get();
            $remain = 0;
            if (isset($result[0])){
                if ($result[0]->status == 1){
                    if ($result[0]->is_one_time == 1){

                        $status="error";
                        $msg = "coupon code already used";
                    }else{
                        $status="success";
                        $msg = "coupon code applied";
                    }

                }else{
                    $status="error";
                    $msg = "coupon code deactivated";
                }
            }else{
                $status="error";
                $msg = "Please enter valid coupon code";
            }


            if ($status=='success'){
                $total = $request->total;
                $value = $result[0]->value;
                // $remain = ((int)$total - (int)$value);
                $remain = ($value/100) * $total;
                if (session()->has('cart')) {
                    $oldCart = session()->get('cart');
                } else {
                    return view('admin.products');
                }
            }

        }else{


        if (session()->has('cart')) {
            $oldCart = session()->get('cart');
        } else {
            toastr()->error('Please chose at leat one product to make checkout','Faild');
            return redirect()->route('product.view');
        }

        }
        
        return view('products.checkout', compact('oldCart','remain','remains'));

    }else{
        toastr()->error('Need login or rigster to compleate checkout','Faild');
        return redirect()->back();
    }
    }

    public function placeOrder(Request $request)
    {
        
        $cart = session()->get('cart', []);
        $remains = session()->get('remain', []);
        $sum = 0;
        $total = 0;

        

        foreach ($cart as $id => $details) {
            foreach($details['color_items'] as $key=> $c){
                $sum += $c['quantity'];
            }                                                   
          $total += Product::find($details['id'])->price * $sum ;
        }


        if (count($remains)) {
            $total  = $remains['remain'];
            $r = DB::table('coupons')->where(['code'=>$remains['code']])->get();
           
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => auth()->user()->id,
                'status' => 'pending',
                'grand_total' => $total,
                'item_count' => $sum,
                'payment_status' => 0,
                'payment_method' => null,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'post_code' => $request->post_code,
                'phone_number' => $request->phone_number,
                'notes' => $request->notes,
                'coupon_id' => $r[0]->id,
            ]);

            Coupons::find($r[0]->id)->decrement('min_order_amt');

    
            if ($order) {

                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                Stripe\Charge::create ([
                "amount" => 100 * $total,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment " 
                ]);
    
    
                Session::flash('success', 'Payment has been successfully processed.');
    
    
                $items = session()->get('cart');
    
    
                foreach (session('cart') as $id => $details) {
                    $sum = 0;
                    foreach ($details['color_items'] as $key => $c) {
                        $sum += $c['quantity'];
                    }
                    // A better way will be to bring the product id with the cart items
                    // you can explore the package documentation to send product id with the cart
                    $product = Product::where('title', Product::find($details['id'])->title)->first();
    
                    $orderItem = new OrderItem([
                        'order_id' => $order->id,
                        'product_id' => $details['id'],
                        'quantity' => $sum,
                        'price' => Product::find($details['id'])->price
                    ]);
    
                    $order->items()->save($orderItem);
                    session()->forget('remain');
                    session()->forget('cart');
                }
            }
    
            return $order;

        }else{
            
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => auth()->user()->id,
                'status' => 'pending',
                'grand_total' => $total,
                'item_count' => $sum,
                'payment_status' => 0,
                'payment_method' => null,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'post_code' => $request->post_code,
                'phone_number' => $request->phone_number,
                'notes' => $request->notes,
                'coupon_id' => null,
            ]);

    
            if ($order) {
    
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                Stripe\Charge::create([
                    "amount" => 100 * $total,
                    "currency" => "usd",
                    "source" => $request->stripeToken,
                    "description" => "Making test payment."
                ]);
    
                Session::flash('success', 'Payment has been successfully processed.');
    
    
                $items = session()->get('cart');
    
    
                foreach (session('cart') as $id => $details) {
                    $sum = 0;
                    foreach ($details['color_items'] as $key => $c) {
                        $sum += $c['quantity'];
                    }
                    // A better way will be to bring the product id with the cart items
                    // you can explore the package documentation to send product id with the cart
                    $product = Product::where('title', Product::find($details['id'])->title)->first();
    
                    $orderItem = new OrderItem([
                        'order_id' => $order->id,
                        'product_id' => $details['id'],
                        'quantity' => $sum,
                        'price' => Product::find($details['id'])->price
                    ]);
    
                    $order->items()->save($orderItem);
                    session()->forget('remain');
                    session()->forget('cart');
                }
            }
    
            return $order;
        }
        

        
    }

    public function applyCouponCode(Request $request){

        $result =DB::table('coupons')->where(['code'=>$request->coupon_code])->get();
        $remains = session()->get('remain', []);
        
        $remain = 0;
        $value = 0;
        $code = 0;

        if (isset($result[0])){
            if ($result[0]->status == 1){
                if ($result[0]->is_one_time == 1){

                    $status="error";
                    $msg = "coupon code already used";
                }else{
                    $status="success";
                    $msg = "coupon code applied";
                }

            }else{
                $status="error";
                $msg = "coupon code deactivated";
            }
        }else{
            $status="error";
            $msg = "Please enter valid coupon code";
        }

        

        if ($status=='success'){
            $total = $request->total;
            $value = $result[0]->value;
            $code = $result[0]->code;
            // $remain = ((int)$total - (int)$value);
            $remain = ((100 - ($value))/100) * $total;

            $remains = [
                "remain" => $remain,
                "code" => $result[0]->code,
                "value" => $result[0]->value,
            ];
            session()->put('remain', []);
            session()->put('remain', $remains);

        }

        session()->put('remain', $remains);
        return response()->json(['status'=>$status,'msg'=>$msg,'remain'=>$remain,'value'=>$value,'code'=>$code]);
    }

    public function removeCouponCode()
    {
        $remains = session()->get('remain', []);
        session()->forget('remain');
        session()->flash('success', 'coupon code removed successfully');
        return redirect(route('cart'));
    }

}
