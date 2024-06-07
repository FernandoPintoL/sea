<?php

namespace App\Http\Controllers;

use App\Models\Vivienda;
use App\Http\Requests\StoreViviendaRequest;
use App\Http\Requests\UpdateViviendaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ViviendaController extends Controller
{
    public function query(Request $request){
        try{
            $response = Vivienda::all()->with('tipoVivienda');
            return response()->json([
                "isRequest"=> true,
                "success" => true,
                "messageError" => false,
                "message" => "Consulta vivienda realizada correctamente...",
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
    public function store(StoreViviendaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Vivienda $vivienda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vivienda $vivienda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateViviendaRequest $request, Vivienda $vivienda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vivienda $vivienda)
    {
        //
    }
}