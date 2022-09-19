<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class inventoryController extends Controller
{

    /* TODO:
    - Agregar Update
     */

    public function getInventory()
    {
        $user = Auth()->user();
        try {

            $inventories = DB::table('inventory')->where('user_id', '=', $user->id)->get();
            foreach ($inventories as $inventory) {
                $product_quantity = DB::table('product')->where('inventory_id', '=', $inventory->id)->count();
                $inventory->quantity = $product_quantity ;    
            }
           
            return response()->json([
                'status' => 1,
                'inventories' => $inventories,
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => 0,
                'msg' => 'This inventory can not be retrieved',
                'error_code' => $e->errorInfo[1],
            ]);

        }

    }
    public function createInventory(Request $request)
    {
        $user = Auth()->user();

        try {   
            Inventory::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return response()->json([
                'status' => 1,
                'msg' => 'Inventory successfully created',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 0,
                'msg' => 'Inventory can not be retrieved',
                'error_code' => $e->getMessage(),
            ]);
        }
    }
    public function deleteInventory(Request $request)
    {
        $user = auth()->user();
        try {

            $deleted = DB::table('inventory')
                ->where('id', '=', $request->id)
                ->where('user_id', '=', $user->id)
                ->delete();

            if ($deleted) {
                return response()->json([
                    'status' => 1,
                    'msg' => 'Inventary successfully deleted',
                ]);
            } else {

                return response()->json([
                    'status' => 0,
                    'msg' => 'The inventory can not be deleted',
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                'status' => 0,
                'msg' => 'Inventory can not be deleted',
                'error_code' => $e->errorInfo[1],
            ]);
        }
    }
    public function getBasicInfoFromInventory(Request $request){
        $arraydates = [];
        $products = DB::table('product')->where('inventory_id',$request->inventoryId)->get();
        
        
        foreach ($products as $product) {
            $arraydates[$product->id] = $product->expiration_date;
        }

        $quantity = count($products);
        return response()->json([
            'status' => 1,
            'cantidad' => $quantity,
        ]);

    
    }
}
