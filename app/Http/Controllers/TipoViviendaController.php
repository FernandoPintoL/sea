<?php

namespace App\Http\Controllers;

use App\Models\TipoVivienda;
use App\Http\Requests\StoreTipoViviendaRequest;
use App\Http\Requests\UpdateTipoViviendaRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class TipoViviendaController extends Controller
{
    public function query(Request $request)
    {
        try {
            $queryStr = $request->get('query');
            $responsse = TipoVivienda::where('sigla', 'LIKE', '%' . $queryStr . '%')
                ->orWhere('detalle', 'LIKE', '%' . $queryStr . '%')
                ->get();
            $cantidad = count($responsse);
            $str = strval($cantidad);
            return response()->json([
                "isRequest" => true,
                "isSuccess" => true,
                "isMessageError" => false,
                "message" => "$str datos encontrados",
                "messageError" => "",
                "data" => $responsse,
                "statusCode" => 200
            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest" => true,
                "isSuccess" => false,
                "isMessageError" => true,
                "message" => $message,
                "messageError" => "",
                "data" => [],
                "statusCode" => $code
            ]);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', TipoVivienda::class);
        $listado = TipoVivienda::all();
        $user = auth()->user();
        $crear = $user->canCrear('TIPO_VIVIENDA');
        $editar = $user->canEditar('TIPO_VIVIENDA');
        $eliminar = $user->canEliminar('TIPO_VIVIENDA');
        return Inertia::render("TipoVivienda/Index", [
            'listado' => $listado,
            'crear' => $crear,
            'editar' => $editar,
            'eliminar' => $eliminar
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', TipoVivienda::class);
        $user = auth()->user();
        $crear = $user->canCrear('TIPO_VIVIENDA');
        $editar = $user->canEditar('TIPO_VIVIENDA');
        $eliminar = $user->canEliminar('TIPO_VIVIENDA');
        return Inertia::render("TipoVivienda/CreateUpdate", ['crear' => $crear, 'editar' => $editar, 'eliminar' => $eliminar]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoViviendaRequest $request)
    {
        try {
            $model = TipoVivienda::create($request->all());
            return response()->json([
                "isRequest" => true,
                "isSuccess" => $model != null,
                "isMessageError" => $model != null,
                "message" => $model != null ? "Solicitud completada" : "Error!!!",
                "messageError" => "",
                "data" => $model,
                "statusCode" => 200
            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest" => true,
                "isSuccess" => false,
                "isMessageError" => true,
                "message" => $message,
                "messageError" => "",
                "data" => [],
                "statusCode" => $code
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoVivienda $tipoVivienda)
    {
        try {
            // $habitante = Habitante::where('vivienda_id','=',$idvivienda)->first();
            // $perfil    = Perfil::findOrFail( $habitante->perfil_id );
            return response()->json([
                "isRequest" => true,
                "isSuccess" => true,
                "isMessageError" => false,
                "message" => "Solicitud realizada correctamente...",
                "messageError" => "",
                "data" => $tipoVivienda,
                "statusCode" => 200
            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest" => true,
                "isSuccess" => false,
                "isMessageError" => true,
                "message" => $message,
                "messageError" => "",
                "data" => [],
                "statusCode" => $code
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoVivienda $tipovivienda)
    {
        Gate::authorize('update', $tipovivienda);
        $user = auth()->user();
        $crear = $user->canCrear('TIPO_VIVIENDA');
        $editar = $user->canEditar('TIPO_VIVIENDA');
        $eliminar = $user->canEliminar('TIPO_VIVIENDA');
        return Inertia::render("TipoVivienda/CreateUpdate", ['model' => $tipovivienda, 'crear' => $crear, 'editar' => $editar, 'eliminar' => $eliminar]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoVivienda $tipovivienda)
    {
        try {
            if ($request->sigla != $tipovivienda->sigla) {
                $model     = $request->all();
                $validator = Validator::make($model, [
                    'sigla' => ['unique:tipo_viviendas']
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        "isRequest" => true,
                        "isSuccess" => false,
                        "isMessageError" => true,
                        "message" => $validator->errors(),
                        "messageError" => $validator->errors(),
                        "data" => [],
                        "statusCode" => 422
                    ], 422);
                }
            }
            $response = $tipovivienda->update($request->all());
            return response()->json([
                "isRequest" => true,
                "isSuccess" => $response,
                "isMessageError" => !$response,
                "message" => $response ? "Datos actualizados correctamente" : "Datos no actualizados",
                "messageError" => "",
                "data" => $response,
                "statusCode" => 200
            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest" => true,
                "isSuccess" => false,
                "isMessageError" => true,
                "message" => $message,
                "messageError" => "",
                "data" => [],
                "statusCode" => $code
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoVivienda $tipoVivienda)
    {
        try {
            $response = $tipoVivienda->delete();
            return response()->json([
                "isRequest" => true,
                "isSuccess" => $response,
                "isMessageError" => !$response,
                "message" => $response ? "Datos eliminados correctamente" : "Los datos no pudieron ser eliminados",
                "messageError" => "",
                "data" => $response,
                "statusCode" => 200
            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            return response()->json([
                "isRequest" => true,
                "isSuccess" => false,
                "isMessageError" => true,
                "message" => $message,
                "messageError" => "",
                "data" => [],
                "statusCode" => $code
            ]);
        }
    }
}
