<?php

namespace App\Http\Controllers;

use App\Models\TipoVisita;
use App\Http\Requests\StoreTipoVisitaRequest;
use App\Http\Requests\UpdateTipoVisitaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class TipoVisitaController extends Controller
{
    public function query(Request $request){
        try{
            $response = TipoVisita::all();
            return response()->json([
                "isRequest"=> true,
                "success" => true,
                "messageError" => false,
                "message" => "Consulta conrrectamente..",
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
    public function store(StoreTipoVisitaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoVisita $tipoVisita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoVisita $tipoVisita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoVisitaRequest $request, TipoVisita $tipoVisita)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoVisita $tipoVisita)
    {
        //
    }
}