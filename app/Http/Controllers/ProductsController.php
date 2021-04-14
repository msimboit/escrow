<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tdetails;
use App\Vendors;
use App\Clients;
use App\Product;
use Log;
use Auth;



class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $arr['prds'] = Product::paginate(10);
        return view('products.index')->with($arr);
    }

    public function create()
    {
            return view('products.create');
    }

    public function show()
    {
        return view('products.show');
    }

    public function edit($id)
    {
        $prod = Product::where('id', $id)->first();
        return view('products.edit', compact('prod'))->with($id);
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        $prod = new Product;

        $prod->name = $request->productname;
        $prod->price = $request->productprice;
        $prod->save();

        return redirect()->route('products')->with('success', 'Product Added!');
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);

        $product->name=$request->productname;
        $product->price = $request->productprice;
        $product->save();

        return redirect()->route('products')->with('success', 'Product Updated!');
    
    }


}
