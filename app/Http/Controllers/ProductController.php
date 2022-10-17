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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Stripe;

class  ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $categories = Category::whereNotNull('parent_id')->get();
        $products = Product::with('category')
            ->where('admin_id', $user->id)
            ->orderBy('id', 'ASC')
            ->paginate(5);
        return view('admin.products.index', compact('products', 'categories'));
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
            'in_stock_quantity' => ['required', 'string', 'max:255'],
            'slider_images' => ['required'],
            'category_id' => ['required'],
            'cover' => ['required'],
            'material_id' => ['required'],
            'size_id' => ['required'],
        ]);


        $input = $request->all();
        $input['category_id'] = 'default';
        $input['boutique_id'] = '1';
        $input['admin_id'] = Auth::user()->id;

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
                    'admin_id' => Auth::user()->id,
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

        return view('admin.products.create', compact('categories', 'materials', 'colorssd', 'sizes'));
    }

    public function GetSubCatAgainstMainCatEdit($id)
    {
        echo json_encode(Category::where('parent_id', $id)->get());
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $products = Product::with('category')->orderBy('id', 'ASC')->paginate(4);
        return view('products.product', compact('product', 'products'));

    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }

    public function cart()

    {
        $id = [];
        $cart = session()->get('cart', []);
        $result = array();
//            dd($cart);
        return view('products.cart', compact('cart', 'result'));

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
                session()->put('cart', $cart);
            } else {
                $newArray = [
                    'size' => (int)$request->size,
                    'color' => (int)$request->color,
                    'quantity' => (int)$request->quantity,
                ];
//                array_push($cart[$id]['color_items'], $newArray);
                $cart[$id]['color_items'][] = $newArray;

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
            session()->put('cart', $cart);
        }

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
        session()->flash('success', 'Cart updated successfully');

    }


    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
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
        session()->flash('success', 'Product removed successfully');
        return redirect(route('cart'));
    }

    public function clearCart()
    {
        session()->forget('cart');
        session()->flash('success', 'Cart cleared successfully');
        return redirect(route('cart'));
    }

    public function getCheckout(Request $request)
    {
        if (session()->has('cart')) {
            $oldCart = session()->get('cart');
        } else {
            return view('admin.products');
        }
        return view('admin.checkout', compact('oldCart'));
    }

    public function placeOrder(Request $request)
    {
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => auth()->user()->id,
            'status' => 'pending',
            'grand_total' => $request->grand_total,
            'item_count' => \Cart::getTotalQuantity(),
            'payment_status' => 0,
            'payment_method' => null,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'post_code' => $request->post_code,
            'phone_number' => $request->phone_number,
            'notes' => $request->notes
        ]);

        if ($order) {

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            Stripe\Charge::create([
                "amount" => 100 * $request->grand_total,
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
                    'product_id' => $details['id'],
                    'quantity' => $sum,
                    'price' => Product::find($details['id'])->price
                ]);

                $order->items()->save($orderItem);
            }
        }

        return $order;
    }

}
