<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\NuestroNumero;
use App\Models\Util;
use DB;
use Validator;


class NuestroNumeroController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('nuestro-numero.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('nuestro-numero.registrar',['estados'=>$estados]);
    }

    public function editar($id_nuestro_numero)
    {
        $nuestroNumero = NuestroNumero::findOrFail($id_nuestro_numero);
        $estados = Util::getEstados();
        return view('nuestro-numero.editar',['nuestroNumero'=>$nuestroNumero,'estados'=>$estados]);
    }

    public function listarNuestroNumero(Request $request)
    {
        $search = $request->input('search');
        $nuestrosNumeros = NuestroNumero::filtroNuestroNumero($search);
        $view = view('nuestro-numero.item-nuestro-numero',['nuestrosNumeros'=>$nuestrosNumeros]);
        return Response($view);
    }


    public function eliminarNuestroNumero(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            NuestroNumero::eliminarNuestroNumero($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Número correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarNuestroNumero(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:191',
            'subtitulo' => 'required|string|max:191',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            NuestroNumero::registrarNuestroNumero(
                $request->titulo,
                $request->subtitulo,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Número registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarNuestroNumero(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'titulo' => 'required|string|max:191',
            'subtitulo' => 'required|string|max:191',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            NuestroNumero::actualizarNuestroNumero(
                $request->id,
                $request->titulo,
                $request->subtitulo,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Número actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
