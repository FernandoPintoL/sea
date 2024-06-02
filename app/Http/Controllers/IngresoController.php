<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Visitante;
use App\Http\Requests\StoreIngresoRequest;
use App\Http\Requests\UpdateIngresoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngresoController extends Controller
{
    public function query(Request $request){
        try{
            $response = Ingreso::all();
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
    public function store(StoreIngresoRequest $request)
    {
        try{
            $perfil = [];
            return $perfil;
            /*if($request->isMobile){
                $visitante    = $request->visitante;
                $responsse = Visitante::create([
                    'perfil_id' => $perfil->id
                ]);
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
            ]);*/
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
    public function show(Ingreso $appingreso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingreso $appingreso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIngresoRequest $request, Ingreso $appingreso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingreso $appingreso)
    {
        //
    }
}