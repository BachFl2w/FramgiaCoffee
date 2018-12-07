<?php

namespace App\Http\Controllers;

use App\Category;
use App\Feedback;
use App\Image;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Topping;
use App\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    public function index()
    {
        $best_discount_product = Product::with('images')->orderBy('discount', 'desc')
            ->orderBy('id', 'desc')
            ->first();
        $best_discount_product->image = $best_discount_product->images[0]->name;

        $best_products = OrderDetail::with('product')->groupBy('product_id')
            ->orderBy('product_price', 'desc')
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();

        $best_product_ids = [];
        $best_product_ids[] = $best_discount_product->id;

        $products = [];
        foreach ($best_products as $product) {
            $best_product_ids[] = $product->product_id;
            $products[] = $product->product;
        }
        if (count($best_products) < 6) {
            $newest_products = Product::whereNotIn('id', $best_product_ids)
                ->limit(6 - count($best_products))
                ->get();
            foreach ($newest_products as $product) {
                $products[] = $product;
            }
        }
        for ($i = 0; $i < count($products); $i++) {
            $image = Image::where('product_id', $products[$i]->id)
                ->orderBy('active', 'desc')
                ->orderBy('id', 'desc')
                ->first();
            $products[$i]->image = $image->name;
        }

        return view('index', compact('products', 'best_discount_product'));
    }

    public function listProduct()
    {
        $products = Product::with(['category' => function ($query) {
            $query->get();
        }])->paginate(4);

        return view('list_product', compact('products'));
    }

    public function liveSearch(Request $request)
    {
        $keyword = $request->keyword;
        $data = [];
        if ($keyword != null) {
            $data = Product::where('name', 'like', '%' . $keyword . '%')->limit(4)->get();
        }

        return $data;
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $products = [];
        if ($keyword != null) {
            $products = Product::where('name', 'like', '%' . $keyword . '%')->paginate(5);
        }

        return view('list_result_search', compact('products'));
    }

    public function filterProductByCategory(Request $request)
    {
        $category_id = $request->category_id;

        $products = [];

        if ($category_id == 0) {
            $products = Product::paginate(4);
        } else {
            $products = Product::where('category_id', $category_id)->paginate(4);
        }

        return view('list_product', compact('products'));
    }

    public function detailProduct($id)
    {
        $product = Product::with('category')->with(['images' => function($query) {
            $query->orderBy('active', 'desc')
            ->orderBy('id', 'desc')->first();
        }])->findOrFail($id);

        $feedback = Product::with(['feedbacks' => function($query) {
            $query->where('status', 1)->orderBy('id', 'desc')->get();
        }])->findOrFail($id);

        return view('product_detail', compact('product', 'feedback'));
    }

    public function detailProductData($id)
    {
        $product = Product::with('category')->with(['images' => function($query) {
            $query->orderBy('active', 'desc')
            ->orderBy('id', 'desc')->first();
        }])->findOrFail($id);
       
        return $product;
    }

    public function comment(Request $request)
    {
        $feedback = new Feedback();

        $feedback->user_id = Auth::id();

        $feedback->product_id = $request->product_id;

        $feedback->content = $request->comment;

        $feedback->status = 0;

        $feedback->save();
    }

    public function orders()
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $orders = Order::where('user_id', $user_id)->orderBy('id', 'desc')->paginate(8);

            return view('list_order', compact('orders'));
        }

        return abort(404);
    }

    public function order_details($order_id)
    {
        $orderDetails = OrderDetail::with('product', 'size', 'toppings')->where('order_id', $order_id)->get();

        return $orderDetails;
    }

    public function cancel_order($order_id)
    {
        $order = Order::findOrfail($order_id);

        $order->status = -1;

        $order->save();
    }

    public function cart()
    {
        $carts = [];
        if (Session::has('cart')) {
            $carts = Session('cart');
        }

        return view('cart', compact('carts'));
    }

    public function demo()
    {
        $category = Category::with(['products'])->get()->map(function ($query) {
            $query->setRelation('products', $query->products->take(5));
            return $query;
        });

        return $category;
    }


}
