<?php

namespace App\Http\Controllers;

use App\Models\GaleriaVehiculo;
use App\Http\Requests\StoreGaleriaVehiculoRequest;
use App\Http\Requests\UpdateGaleriaVehiculoRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class GaleriaVehiculoController extends Controller
{
    public function uploadimage(Request $request){
        try{
            /*return response()->json([
                "isRequest"=> true,
                "success" => true,
                "messageError" => false,
                "message" => "Mensaje",
                "data" => $request->all()
            ]);*/
            
            $response = "";
            $path     = null;

            if($request->hasFile('file')){
                $model = GaleriaVehiculo::create([
                    "vehiculo_id" => $request->get("id"),
                    'created_at' => $request->created_at == null ? date_create('now')->format('Y-m-d H:i:s') : $request->created_at,
                    'updated_at' => $request->updated_at == null ? date_create('now')->format('Y-m-d H:i:s') : $request->updated_at
                ]);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filename= "cod".$model->id."-vehiculoid".$request->get("id").'.'.$extension;
                $path = $request->file('file')->storeAs('vehiculos', $filename, 'public');
                $url = Storage::url($path);
                $response = $model->update(['photo_path'=> $url,'detalle'=>$filename]);
            }
            return response()->json([
                "isRequest"=> true,
                "success" => $request->hasFile('file'),
                "messageError" => !$request->hasFile('file'),
                "message" => isset($path) ? "Archivos subidos" : "Archivos no subidos",
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

    public function getGaleriaVehiculo(Request $request){
        try{
            $responsse = GaleriaVehiculo::where('vehiculo_id','=',$request->get('vehiculo_id'))
                        ->with('vehiculo')
                        ->get();
            $cantidad = count( $responsse );
            $str = strval($cantidad);
            return response()->json([
                "isRequest"=> true,
                "success" => true,
                "messageError" => false,
                "message" => "$str datos encontrados",
                "data" => $responsse
            ]);
        }catch(\Exception $e){
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest"=> true,
                "success" => false,
                "messageError" => true,
                "message" => "Consulta galeria visitantes/ ".$message." Code: ".$code,
                "data" => []
            ]);
        }
    }

    public function query(Request $request){
        try{
            $responsse = GaleriaVehiculo::with('vehiculo')
                         ->get();
            $cantidad = count( $responsse );
            $str = strval($cantidad);
            return response()->json([
                "isRequest"=> true,
                "success" => true,
                "messageError" => false,
                "message" => "$str datos encontrados",
                "data" => $responsse
            ]);
        }catch(\Exception $e){
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest"=> true,
                "success" => false,
                "messageError" => true,
                "message" => "Consulta galeria vehiculos/ ".$message." Code: ".$code,
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
    public function store(StoreGaleriaVehiculoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GaleriaVehiculo $galeriaVehiculo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GaleriaVehiculo $galeriaVehiculo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGaleriaVehiculoRequest $request, GaleriaVehiculo $galeriaVehiculo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GaleriaVehiculo $galeriaVehiculo)
    {
        //
    }
}