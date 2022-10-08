<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use App\Services\Alertcreator;
use Exception;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Carbon;

class productController extends Controller
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function createProduct(Request $request, Alertcreator $AlertCreator)
    {

        try {
            $validated = $request->validate([
                'inventory_id' => 'required',
                'name' => 'required',
                'buying_date' => 'required',
                'prod_type_id' =>'required',
                'expiration_date' => 'required',
                'image' => '',

            ], [
                'inventory_id.required' => 'Inventory  field is required.',
                'name.required' => 'Product name is required.',
                'prod_type_id.required' => 'Product type is required.',
                'buying_date.required' => 'Buying date is required.',
                'expiration_date.required' => 'Expiration date is required.',

            ]);
            $startTime = Carbon::parse($request->buying_date);
            $finishTime = Carbon::parse($request->expiration_date);
            
            $validated['days_left'] = $finishTime->diffInDays($startTime);
            
            if(!$finishTime->isAfter($startTime)){
                return response()->json([
                    'status' => 0,
                    'msg' => 'The experation date should be after the buying date.',
                ]);
            }
            
            $product = Product::create($validated);

            $AlertCreator($request->expiration_date, $product->id);

            if ($request->company_name) {
                Company::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->user()->id,
                    'name' => $request->company_name,
                    'location' => $request->companyLocation,
                ]);
            }

            return response()->json([   
                'status' => 1,
                'msg' => 'Product created',
            ]);

        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            return response()->json([
                'status' => 0,
                'msg' => $e->getMessage(),
            ]);
        }

    }

    public function deleteProduct(Request $request)
    {
        try {
            Product::where('id', '=', $request->id)->delete();

            return response()->json([
                'status' => 1,
                'msg' => 'Product deleted',
            ]);

        } catch (\Throwable$th) {
            $this->logger->error($th->getMessage());
            return response()->json([
                'status' => 0,
                'msg' => 'The product can not be deleted',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function updateProduct(Request $request)
    {
        try {

            Product::where('id', '=', $request->product_id)->update([
                'inventory_id' => $request->inventory_id,
                'name' => $request->name,
                'buying_date' => $request->buying_date,
                'expiration_date' => $request->expiration_date,
                'image' => $request->image,
            ]);

            return response()->json([
                'status' => 1,
                'msg' => 'Product updated',
            ]);

        } catch (\Throwable$th) {

            $this->logger->error($th->getMessage());
            return response()->json([
                'status' => 0,
                'msg' => 'The product can not be updated',
                'error' => $th->getMessage(),
            ]);
        }
    }
    public function getOneProduct(Request $request)
    {
        try {

            $product = Product::where('id', '=', $request->product_id)->first();

            return response()->json([
                'status' => 1,
                'product' => $product,
            ]);

        } catch (\Throwable$th) {

            $this->logger->error($th->getMessage());
            return response()->json([
                'status' => 0,
                'msg' => 'The product can not be found',
                'error' => $th->getMessage(),
            ]);
        }
    }
    public function getAllProduct(Request $request)
    {
        try {

            $products = Product::getProductsByInventoryID($request->inventory_id);

            return response()->json([
                'status' => 1,
                'products' => $products,

            ]);

        } catch (\Throwable$th) {

            $this->logger->error($th->getMessage());
            return response()->json([
                'status' => 0,
                'msg' => 'Products can not be retrieved',
                'error' => $th->getMessage(),
            ]);
        }
    }
}
