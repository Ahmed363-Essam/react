<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Helpers\ApiResponse;

use App\Traits\ImageTraint;

class ProductController extends Controller
{
    use ImageTraint;

    public function index()
    {
        try {
            $products = Product::select('id', 'title', 'price', 'description', 'image')->get();
            if (count($products) != 0) {
                return ApiResponse::sendResponse(200, $products, 'Get All Succesfuly');
            }
            return ApiResponse::sendResponse(200, $products, 'Products Is Empty');
        } catch (\Exception $e) {
            return ApiResponse::sendResponse(400, [], $e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {

            $input = $request->only(['title', 'description', 'price']);

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $image_name = $request->title . '' . $imageFile->getClientOriginalName();
                $input['image'] = $image_name;

                // param 1 => folder_name  in public//assets
                // param 2 image name inside product folder
                // disk => 'product

                $this->StoreImage('product', $request, 'product');
            }
            $added_product = Product::create($input);

            return ApiResponse::sendResponse(200, $added_product, 'Products Is Added successfully');
        } catch (\Exception $e) {
            return ApiResponse::sendResponse(200, $e->getMessage(), 'Products Is Added successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            if ($id) {
                $products = Product::where('id', $id)->select('image', 'price', 'title', 'description')->get();
                if (count($products) != 0) {
                    return ApiResponse::sendResponse(200, $products, 'Get One Succesfuly');
                }
                return ApiResponse::sendResponse(200, $products, 'Products Is Empty');
            }
            return ApiResponse::sendResponse(404, [], 'You Must SEnd Write Id');
        } catch (\Exception $e) {
            return ApiResponse::sendResponse(400, [], $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $id = $product->id;
            if ($id) {


                if ($product->image !== null) {
                    // this trait accept image name , path inside public path
                    $this->DeleteImage($product->image, 'assets/product/');
                }


                $product->delete();
                return ApiResponse::sendResponse(200, [], 'Deleted Succesfuly');

                return ApiResponse::sendResponse(200, [], 'the product donot exist');
            }
        } catch (\Exception $e) {
            return ApiResponse::sendResponse(200, $e->getMessage(), 'Products Is Deleted successfully');
        }
    }
}
