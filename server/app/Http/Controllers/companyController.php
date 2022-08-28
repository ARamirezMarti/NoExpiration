<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class companyController extends Controller
{
    public function getAllCompanyByUser(Request $request){
       try {
        $companies = DB::table('company')->where('user_id','=',$request->user)
        ->get();
        return response()->json([
            'status' => 1,
            'companies' => $companies,
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
