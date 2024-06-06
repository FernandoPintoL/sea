<?php

namespace App\Http\Controllers;

use App\Models\Visitante;
use App\Models\Perfil;
use App\Http\Requests\StoreVisitanteRequest;
use App\Http\Requests\UpdateVisitanteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class VisitanteController extends Controller
{
    public function query(Request $request){
        try{
            $queryStr    = $request->get('query');
            $response = DB::table('visitantes as v')
                        ->select('v.*','p.*')
                        ->join('perfils as p', 'v.perfil_id', '=', 'p.id')
                        ->where('p.name','LIKE',"%".$queryStr."%")
                        ->orWhere('v.id','LIKE',"%".$queryStr."%")
                        ->get();
            return response()->json([
                "isRequest"=> true,
                "success" => true,
                "messageError" => false,
                "message" => "Listado correctamente..",
                "data" => $response
            ]);
        }catch(\Exception $e){
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest"=> true,
                "success" => false,
                "messageError" => true,
                "message" => $message." Code: ".$code,
                "data" => []
            ]);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVisitanteRequest $request)
    {
        try{
            $perfil = [];
            if($request->isMobile){
                $perfil    = $request->perfil;
                $validator = Validator::make($perfil, [
                    'name' => ['required', 'string', 'max:255', 'min:5'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:perfils'],
                    'nroDocumento' => ['required','min:5'],
                    'tipo_documento_id' => ['required', 'numeric']
                ]);
                if ($validator->fails()) {
                    return response()->json( [ 
                        "isRequest" => true,
                        "success" => false,
                        "messageError" => true,
                        "message" => $validator->errors(),
                        "data" => []
                    ], 422 );
                }
                $perfil = Perfil::create($perfil);
            }else{
                $perfil = Perfil::create($request->all());
            }
            $responsse = Visitante::create([
                'perfil_id' => $perfil->id
            ]);
            return response()->json([
                "isRequest"=> true,
                "success" => $responsse != null,
                "messageError" => $responsse != null,
                "message" => $responsse != null ? "Registro completo" : "Error!!!",
                "data" => $responsse
            ]);
        }catch(\Exception $e){
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest"=> true,
                "success" => false,
                "messageError" => true,
                "message" => $message." Code: ".$code,
                "data" => []
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Visitante $visitante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visitante $visitante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVisitanteRequest $request, Visitante $appvisitante)
    {
        try{
            $responsse = 0;
            $perfil = Perfil::findOrFail($appvisitante->perfil_id);
            if($request->isMobile){
                //ACTUALIZACION DESDE EL MOVIL
                $responsse = $perfil->update($request->perfil);
            }else{
                //ACTUALIZAR DESDE LA WEB
                $responsse = $perfil->update($request->all());
            }
            return response()->json([
                "isRequest"=> true,
                "success" => $responsse != null,
                "messageError" => $responsse != null,
                "message" => $responsse != null ? "Registro completo" : "Error!!!",
                "data" => $responsse
            ]);
        }catch(\Exception $e){
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest"=> true,
                "success" => false,
                "messageError" => true,
                "message" => $message." Code: ".$code,
                "data" => []
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visitante $appvisitante)
    {
        try{
            /* return response()->json([
                "isRequest"=> true,
                "success" => false,
                "messageError" => true,
                "message" => "Verificacion",
                "data" => $appvisitante
            ]); */
            $id       = $appvisitante->perfil_id;
            $response = $appvisitante->delete();
            $model = Perfil::findOrFail($id);
            $response = $model->delete();
            //$model = Visitante::findOrFail($appvisitante->id);
            //$response = $model->delete();
            return response()->json([
                "isRequest"=> true,
                "success" => $response,
                "messageError" => !$response,
                "message" => $response != null ? "Eliminado Correctamente" : "Error!!!",
                "data" => $model
            ]);
        }catch(\Exception $e){
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest"=> true,
                "success" => false,
                "messageError" => true,
                "message" => $message." Code: ".$code,
                "data" => []
            ]);
        }
    }
}