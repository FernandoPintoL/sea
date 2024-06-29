<?php

namespace App\Http\Controllers;

use App\Models\Habitante;
use App\Models\Perfil;
use App\Http\Requests\StoreHabitanteRequest;
use App\Http\Requests\UpdateHabitanteRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class HabitanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function query(Request $request){
        try{
            $responsse = Habitante::with('perfil')
                         ->with('vivienda')
                         ->orderBy('id', 'DESC')
                         ->get();
            /**$queryStr  = $request->get( 'query' );
            $responsse = DB::table('habitantes as h')
                        ->select('h.*','p.*','td.*','vd.*')
                        ->join('perfils as p', 'h.perfil_id', '=', 'p.id')
                        ->join('viviendas as vd', 'h.vivienda_id', '=', 'h.id')
                        ->join('tipo_documentos as td', 'p.tipo_documento_id', '=', 'td.id')
                        ->where('h.id','LIKE','%'.$queryStr.'%')
                        ->orWhere('p.nroDocumento','LIKE','%'.$queryStr.'%')
                        ->orWhere('p.name','LIKE','%'.$queryStr.'%')
                        ->orWhere('vd.nroVivienda','LIKE','%'.$queryStr.'%')
                        ->get();**/
            return response()->json([
                "isRequest"=> true,
                "success" => true,
                "messageError" => false,
                "message" => "Consulta de habitantes conrrectamente..",
                "data" => $responsse
            ]);
        }catch(\Exception $e){
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest"=> true,
                "success" => false,
                "messageError" => true,
                "message" => "Consulta habitante/ ".$message." Code: ".$code,
                "data" => []
            ]);
        }
    }
    public function queryAutoriza(Request $request){
        try{
            $habitantes = Habitante::with('perfil')->with('responsable')->get();
            return response()->json([
                "isRequest"=> true,
                "success" => true,
                "messageError" => false,
                "message" => "Session cerrada conrrectamente..",
                "data" => $habitantes
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
    public function index()
    {
        $habitantes = Habitante::all();
        return Inertia::render("Habitante/Index", ['habitantes'=> $habitantes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("Habitante/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHabitanteRequest $request)
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
            $responsse = Habitante::create([
                'isDuenho' => $request->isDuenho,
                'isDependiente' => $request->isDependiente,
                'responsable_id' => $request->responsable_id,
                'perfil_id' => $perfil->id,
                'profile_photo_path' => '',
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
    public function show(Habitante $apphabitante)
    {
           
    }

    public function getVivienda($idvivienda)
    {
        try{
            $habitante = Habitante::where('vivienda_id','=',$idvivienda)->first();
            // $perfil    = Perfil::findOrFail( $habitante->perfil_id );
            return response()->json([
                "isRequest"=> true,
                "success" => true,
                "messageError" => false,
                "message" => "Consulta Habitante realizada correctamente...",
                "data" => $habitante->perfil
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

    public function getResidente($idresidente)
    {
        try{
            $responsse = DB::table('habitantes as h')
                        ->select('h.*','p.*','td.*','vd.*')
                        ->join('perfils as p', 'h.perfil_id', '=', 'p.id')
                        ->join('viviendas as vd', 'h.vivienda_id', '=', 'h.id')
                        ->join('tipo_documentos as td', 'p.tipo_documento_id', '=', 'td.id')
                        ->where('h.id','=',$idresidente)
                        ->first();
            return response()->json([
                "isRequest"=> true,
                "success" => true,
                "messageError" => false,
                "message" => "Consulta Residente realizada correctamente...",
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
     * Show the form for editing the specified resource.
     */
    public function edit(Habitante $habitante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHabitanteRequest $request, Habitante $apphabitante)
    {
        try{
            /* return response()->json([
                "isRequest"=> true,
                "success" => false,
                "messageError" => true,
                "message" => "Verificacion",
                "data" => $apphabitante
            ]);  */
            $perfil = Perfil::findOrFail($apphabitante->perfil_id);
            if($request->isMobile){
                /* $array    = $request->perfil;
                $validator = Validator::make($array, [
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
                } */
                $perfil->update($request->perfil);
            }else{
                //ACTUALIZAR DESDE LA WEB
                $perfil->update($request->all());
            }
            $responsse = $apphabitante->update([
                'isDuenho' => $request->isDuenho,
                'isDependiente' => $request->isDependiente,
                'responsable_id' => $request->responsable_id,
                'perfil_id' => $request->perfil_id,
                'profile_photo_path' => '',
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
     * Remove the specified resource from storage.
     */
    public function destroy(Habitante $apphabitante)
    {
        try{
            /* return response()->json([
                "isRequest"=> true,
                "success" => false,
                "messageError" => true,
                "message" => "Verificacion",
                "data" => $apphabitante
            ]);  */
            $perfil = Perfil::findOrFail($apphabitante->perfil_id);
            $response = $perfil->delete();
            $habitante = Habitante::findOrFail($apphabitante->id);
            $response = $habitante->delete();
            return response()->json([
                "isRequest"=> true,
                "success" => $response,
                "messageError" => $response,
                "message" => $response != null ? "completo" : "Error!!!",
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
}