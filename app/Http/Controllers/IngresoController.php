<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Perfil;
use App\Models\Visitante;
use App\Models\Vehiculo;
use App\Http\Requests\StoreIngresoRequest;
use App\Http\Requests\UpdateIngresoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngresoController extends Controller
{
    public function query(Request $request){
        try{
            $response = Ingreso::with('vivienda')->with('autoriza')->with('vehiculo')->get();
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
            /* return response()->json([
                "isRequest"=> true,
                "success" => true,
                "messageError" => false,
                "message" => "Llegando de la api..",
                "data" => $request->perfil
            ]); */
            if($request->isMobile){
                $perfilrequest = $request->perfil;
                $vehiculorequest = $request->vehiculo;

                //creamos perfil
                if($request->isNewVisitante){
                    $perfil = Perfil::create($perfilrequest);
                    $visitante = Visitante::create([
                        'perfil_id' => $perfil->id
                    ]);
                    $idVisitante = $visitante->id;
                }

                if($request->isIngresoConVehiculo){
                    if($request->isNewVehiculo){
                        $vehiculo = Vehiculo::create( $vehiculorequest );
                        $idVehiculo = $vehiculo->id;
                    }else{
                        $idVehiculo = $request->vehiculo_id;
                    }
                }else{
                    $idVehiculo = null;
                }

                $responsse = Ingreso::create([
                    'tipo_ingreso' => $request->tipo_ingreso,
                    'detalle'=> $request->detalle,
                    'isAutorizado' => $request->isAutorizado,
                    'visitante_id' => $request->isNewVisitante ? $visitante->id : $request->visitante_id, ///FK
                    'vivienda_id' => $request->vivienda_id, ///FK
                    'autoriza_habitante_id'=> $request->autoriza_habitante_id,
                    'vehiculo_id'=> $idVehiculo, ///FK
                    'tipo_visita_id' => $request->tipo_visita_id, ///FK
                    'user_id' => $request->user_id,///FK
                ]);
            }else{
                // $perfil = Perfil::create($request->all());
                //TODAVIA NO CREA DESDE LA WEB
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