<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

class prodtypeController extends Controller
{
    public function getTypes(){

        
        $types = DB::table('prod_type')->get();

        if($types){

            return response()->json([   
                'status' => 1,
                'types' => $types, 
            ]);
        }
        return response()->json([   
            'status' => 0,
            'msg' => 'Types can not be retrieved', 
        ]);

    }    
}
