<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product\Product;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at')->get();

        // return Response::make($products, 200);
        return $this->getResponse($products);
    }

    public function read($id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            return $this->throwError(404);
        }

        // return Response::make($product, 200);
        return $this->getResponse($product);
    }

    public function create(Request $request)
    {
        $product = new Product;

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->discountPrice = $request->input('discountPrice');
        $product->totalDiscount = $request->input('totalDiscount');

        if(!empty(request()->image)) {
            $imageName = time().'.'.request()->image->getClientOriginalExtension();
         // $imageName = time().'.jpg';
            request()->image->move(public_path('images/product'), $imageName);
            $product->image = 'images/product/' . $imageName;
        }

        $product->save();

        return $this->getResponse($product, $request->input());
    }

    public function update(Request $request)
    {
        $product = Product::find($request->input('productId'));

        if (empty($product)) {
            return $this->throwError(404);
        }

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->discountPrice = $request->input('discountPrice');
        $product->totalDiscount = $request->input('totalDiscount');

        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images/product'), $imageName);
        $product->image = 'images/product/' . $imageName;

        $product->save();

        return $this->getResponse($product, $request->input());
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->input('productId'));

        if (empty($product)) {
            return $this->throwError(404, $request->input('productId'));
        }

        $product->delete();

        return $this->getResponse($product, $request->input());
    }
}
