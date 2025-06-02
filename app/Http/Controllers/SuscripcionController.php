<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Suscripcion;
use App\Models\Util;
use DB;
use Validator;


class SuscripcionController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('suscripcion.index');
    }

    public function listarSuscripcion(Request $request)
    {
        $search = $request->input('search');
        $suscripciones = Suscripcion::filtroSuscripcion($search);
        $view = view('suscripcion.item-suscripcion',['suscripciones'=>$suscripciones]);
        return Response($view);
    }


    public function eliminarSuscripcion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Suscripcion::eliminarSuscripcion($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Suscripción eliminada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }


}
