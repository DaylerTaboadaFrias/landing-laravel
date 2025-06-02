<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\PortadaInicio;
use App\Models\Util;
use DB;
use Validator;


class PortadaInicioController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('portada-inicio.index');
    }

    public function editar($id_portada_inicio)
    {
        $portada = PortadaInicio::findOrFail($id_portada_inicio);
        $estados = Util::getEstados();
        return view('portada-inicio.editar',['portada'=>$portada,'estados'=>$estados]);
    }

    public function listarPortadaInicio(Request $request)
    {
        $search = $request->input('search');
        $portadas = PortadaInicio::filtroPortadaInicio($search);
        $view = view('portada-inicio.item-portada-inicio',['portadas'=>$portadas]);
        return Response($view);
    }


    public function actualizarPortadaInicio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'titulo' => 'required|string|max:191',
            'subtitulo' => 'required|string|max:191',
        ]); 

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            PortadaInicio::actualizarPortadaInicio(
                $request->id,
                $request->titulo,
                $request->subtitulo,
                $request->imagen
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Portada de inicio actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }


}
