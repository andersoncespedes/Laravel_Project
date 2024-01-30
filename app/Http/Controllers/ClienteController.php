<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Exception;
class ClienteController extends Controller
{
    public function GetAll() : JsonResponse{
        try{
            $lista = DB::transaction(function() : Collection{
                        return Cliente::where("nombre","like", "%x%")
                        ->get();
                    });
            return response()->json(["datos" => $lista, "status" => 200]);
        }catch(Exception $err){
            return response()->json(["error"=> $err->getMessage(), "status" => 400]);
        }

    }
    public function AddOne(Request $arr) : JsonResponse{
        try{
            if (preg_match('/[^0-9]/', $arr->cedula)) {
                throw new QueryException("", [12345], new Exception("No Pueden ser numeros pana"), 311);
            }
            CLiente::insert($arr->all());
            return response()->json(["datos"=> $arr->all(), "status" => 201]);
        }catch(QueryException $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }

    }

}
