<?php

namespace App\Http\Controllers;

use App\Models\TipoVivienda;
use App\Http\Requests\StoreTipoViviendaRequest;
use App\Http\Requests\UpdateTipoViviendaRequest;
use Illuminate\Http\Request;

class TipoViviendaController extends Controller
{
    public function query(Request $request){
        try{
            $response = TipoVivienda::all();
            return response()->json([
                "isRequest"=> true,
                "success" => true,
                "messageError" => false,
                "message" => "Consulta TipoVivienda realizada correctamente...",
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
    public function store(StoreTipoViviendaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoVivienda $tipoVivienda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoVivienda $tipoVivienda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoViviendaRequest $request, TipoVivienda $tipoVivienda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoVivienda $tipoVivienda)
    {
        //
    }
}