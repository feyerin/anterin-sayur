<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product\Product;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at')->get();

        $productArray = $products->toArray();

        $result = array_map(function ($row) {
            $mapResult = $row;
            $mapResult['imageurl'] = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $row['image'];

            return $mapResult;
        }, $productArray);

        // return Response::make($products, 200);
        return $this->getResponse($result);
    }

    public function read($id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            return $this->throwError(404);
        }

        $result = $product->toArray();
        $result['imageUrl'] = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $product['image'];

        // return Response::make($product, 200);
        return $this->getResponse($result);
    }

    public function create(Request $request)
    {
        $product = new Product;

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->discountPrice = $request->input('discountPrice');
        $product->totalDiscount = $request->input('totalDiscount');

        // if(!empty(request()->image)) {
        //     $imageName = time().'.'.request()->image->getClientOriginalExtension();
        //  // $imageName = time().'.jpg';
        //     request()->image->move(public_path('images/product'), $imageName);
        //     $product->image = 'images/product/' . $imageName;
        // }
        
        $product->save();

        try{
            $filePath = '';
            if (!empty(request()->image)) {
                // $file = $request->file('image');
                $file = request()->image;
                $name = time() . $file->getClientOriginalName();
                $filePath = 'sayur/images/product/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
            }

            $product->image = $filePath;
            $product->save();

        } catch (Exception $e) {
            return $e;
        }

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

        // if(!empty(request()->image)) {
        //     $imageName = time().'.'.request()->image->getClientOriginalExtension();
        //  // $imageName = time().'.jpg';
        //     request()->image->move(public_path('images/product'), $imageName);
        //     $product->image = 'images/product/' . $imageName;
        // }

        $product->save();

        try{
            $filePath = '';
            if (!empty(request()->image)) {
                // $file = $request->file('image');
                $file = request()->image;
                $name = time() . $file->getClientOriginalName();
                $filePath = 'sayur/images/product/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
            }

            $product->image = $filePath;
            $product->save();

        } catch (Exception $e) {
            return $e;
        }

        return $this->getResponse($product, $request->input());
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->input('productId'));

        if (empty($product)) {
            return $this->throwError(404, $request->input('productId'));
        }

        Storage::disk('s3')->delete($product->image);
        $product->delete();

        return $this->getResponse($product, $request->input());
    }
}
