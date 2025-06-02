<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\ConfiguracionIncompany;
use App\Models\Util;
use DB;
use Validator;


class ConfiguracionIncompanyController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('configuracion-incompany.index');
    }

    public function editar($id_configuracion)
    {
        $configuracionIncompany = ConfiguracionIncompany::findOrFail($id_configuracion);
        $estados = Util::getEstados();
        return view('configuracion-incompany.editar',['configuracionIncompany'=>$configuracionIncompany,'estados'=>$estados]);
    }

    public function listarConfiguracionIncompany(Request $request)
    {
        $search = $request->input('search');
        $configuracionIncompany = ConfiguracionIncompany::filtroConfiguracionIncompany($search);
        $view = view('configuracion-incompany.item-configuracion-incompany',['configuracionIncompany'=>$configuracionIncompany]);
        return Response($view);
    }


    

    public function actualizarConfiguracionIncompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'correo' => 'required',
            'codigo_area' => 'required',
            'celular' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            ConfiguracionIncompany::actualizarConfiguracionIncompany(
                $request->id,
                $request->correo,
                $request->codigo_area,
                $request->celular
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Configuracion de incompany actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
