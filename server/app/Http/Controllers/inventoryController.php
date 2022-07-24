<?php

namespace App\Http\Controllers;


use App\Models\Inventory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class inventoryController extends Controller
{

    /* TODO:
        - Agregar Update
     */
    
     public function getInventory(){
        $user = Auth()->user();
        try{

            $inventory = Inventory::where('user_id','=',$user->id)->first();
         
            return response()->json([
                'status' => 1,
                'inventario'=>$inventory
            ]);
        }catch(Exception $e){
            
            
            return response()->json([
                'status' => 0,
                'msg' => 'No se ha podido recuperar el inventario',                     
                'error_code'=>$e->errorInfo[1]
            ]);

        }


    } 
    public function createInventory(Request $request){
        $user = Auth()->user();
        
        try{          
            Inventory::create([
                'user_id'=>$user->id,
                'name'=>$request->name
            ]);
            
            return response()->json([
                'status' => 1,
                'msg'=>'Done',
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 0,
                'msg' => 'No se ha podido recuperar el inventario',                     
                'error_code'=>$e->errorInfo[1]
            ]);
        }
    } 
    public function deleteInventory(Request $request){
        $user= auth()->user();
        try{         

            $deleted = DB::table('inventory')
                ->where('id', '=',$request->id)
                ->where('user_id', '=',$user->id)
                ->delete();

            if($deleted){
                return response()->json([
                    'status' => 1,
                    'msg'=>'Inventario borrado'
                ]);
            }else{

                return response()->json([
                    'status' => 0,
                    'msg'=>'Este inventario no le pertenece a este usuario',                    
                ]);
            }

        }catch(Exception $e){
            return response()->json([
                'status' => 0,
                'msg' => 'No se ha podido recuperar el inventario',                     
                'error_code'=>$e->errorInfo[1]
            ]);
        }
    } 
}
