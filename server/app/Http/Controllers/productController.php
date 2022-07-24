<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use App\Models\ProdType;
use Illuminate\Http\Request;
use Exception;
use Psr\Log\LoggerInterface;
use App\Services\Alertcreator;
use Illuminate\Support\Facades\DB;


class productController extends Controller
{
    private $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function createProduct(Request $request, Alertcreator $AlertCreator){

       
        try {
            $validated= $request->validate([
                'inventory_id'=>'required',
                'name'=>'required',
                'buying_date'=>'required',
                'expiration_date'=>'required',
                'product_type'=>'required',
                'image'=>'',
                
            ],[
                'inventory_id.required' => 'Inventory  field is required.',
                'name.required' => 'Product name is required.',
                'buying_date.required' => 'Buying date is required.',
                'expiration_date.required' => 'Expiration date is required.',
                'product_type.required'=>'The type of this product is required.',

            ]);
            $product = Product::create($validated);
            
            $AlertCreator->createAlerts($request->expiration_date,$product->id);
            var_dump($product->id);

            var_dump(auth()->user()->id);
            ProdType::create([
                'product_id' => $product->id,
                'user_id' => auth()->user()->id,
                'type' => $request->product_type
            ]);

             if ($request->company_name){
                Company::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->user()->id,
                    'name' => $request->company_name,
                    'location' => $request->companyLocation
                ]);
            }
 
            return response()->json([
                'status' => 1,
                'msg' => 'Producto creado',
                'alertas'=>$product
            ]);

           
            
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            return response()->json([
                'status' => 0,
                'msg' => 'No se ha podido crear el producto',                     
                'error'=>$e->getMessage()
            ]);
        }
        
    }

    public function deleteProduct(Request $request){
        try {
            Product::where('id','=',$request->id)->delete();           
            
            return response()->json([
                'status' => 1,
                'msg' => 'Product borrado',
            ]);

        } catch (\Throwable $th) {
            $this->logger->error($th->getMessage());
            return response()->json([
                'status' => 0,
                'msg' => 'No se ha borrar el producto',                     
                'error'=>$th->getMessage()
            ]);
        }
    }

    public function updateProduct(Request $request){
        try {
            
            Product::where('id','=',$request->product_id)->update([
                'inventory_id'=> $request->inventory_id,            
                'name'=> $request->name,
                'buying_date'=> $request->buying_date,
                'expiration_date'=> $request->expiration_date,
                'image'=> $request->image,
            ]); 

            return response()->json([
                'status' => 1,
                'msg' => 'Producto actualizado',
            ]);

        } catch (\Throwable $th) {
            
            $this->logger->error($th->getMessage());
            return response()->json([
                'status' => 0,
                'msg' => 'No se ha podido actualizar el producto',                     
                'error'=>$th->getMessage()
            ]);
        }
    }
    public function getOneProduct(Request $request){
        try {
            
            $product = Product::where('id','=',$request->product_id)->first();

            return response()->json([
                'status' => 1,
                'product' =>  $product,
            ]);

        } catch (\Throwable $th) {
            
            $this->logger->error($th->getMessage());
            return response()->json([
                'status' => 0,
                'msg' => 'No se ha encontrado este producto',                     
                'error'=>$th->getMessage()
            ]);
        }
    }
    public function getAllProduct(Request $request){
        try {
            
            $products = DB::table('product')->where('inventory_id','=',$request->inventory_id)
            ->get();

         
            return response()->json([
                'status' => 1,
                'products' =>  $products,
                
            ]);

        } catch (\Throwable $th) {
            
            $this->logger->error($th->getMessage());
            return response()->json([
                'status' => 0,
                'msg' => 'No se ha encontrado productos',                     
                'error'=>$th->getMessage()
            ]);
        }
    }
}
