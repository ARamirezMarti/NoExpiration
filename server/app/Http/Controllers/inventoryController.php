<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;


class inventoryController extends Controller
{

    /* TODO:
    - Agregar Update
     */

    public function getInventory()
    {
        $user = Auth()->user();
        try {

            $inventories = Inventory::getInventoriesByUserId($user->id); 
            foreach ($inventories as $inventory) {
                $product_quantity = Product::getCountProductsByInventoryID($inventory->id); 
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
                'msg' => 'Inventory can not be created',
                'error_code' => $e->getMessage(),
            ]);
        }
    }
    public function deleteInventory(Request $request)
    {
        $user = auth()->user();
        try {

            $deleted = Inventory::deleteInventory($user->id,$request->id); 

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
    
}
