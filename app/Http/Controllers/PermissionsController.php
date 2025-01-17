<?php

namespace App\Http\Controllers;

use App\Models\Permissions;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionsRequest;
use App\Http\Requests\UpdatePermissionsRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class PermissionsController extends Controller
{
    public function query(Request $request)
    {
        try {
            $queryStr    = $request->get('query');
            $queryUpper = strtoupper($queryStr);
            $responsse = Permission::where('name', 'LIKE', '%' . $queryStr . '%')
                ->get();
            $cantidad = count($responsse);
            $str = strval($cantidad);
            return response()->json([
                "isRequest" => true,
                "isSuccess" => true,
                "isMesageError" => false,
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
        Gate::authorize('viewAny', Permission::class);
        $listado = Permission::all();
        $user = auth()->user();
        $crear = $user->canCrear('PERMISSION');
        $editar = $user->canEditar('PERMISSION');
        $eliminar = $user->canEliminar('PERMISSION');
        return Inertia::render("Permissions/Index", [
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
        Gate::authorize('create', Permission::class);
        $user = auth()->user();
        $crear = $user->canCrear('PERMISSION');
        $editar = $user->canEditar('PERMISSION');
        return Inertia::render("Permissions/CreateUpdate", [
            'crear' => $crear,
            'editar' => $editar,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionsRequest $request)
    {
        try {
            $model = Permission::create([
                'name' => $request->name
            ]);
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
    public function show(Permission $permissions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        Gate::authorize('create', $permission);
        $user = auth()->user();
        $crear = $user->canCrear('PERMISSION');
        $editar = $user->canEditar('PERMISSION');
        return Inertia::render("Permissions/CreateUpdate", ['model' => $permission, 'crear' => $crear, 'editar' => $editar]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        try {
            if ($request->name != $permission->name) {
                $model     = $request->all();
                $validator = Validator::make($model, [
                    'name' => ['unique:permissions']
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
            $response = $permission->update([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
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
    public function destroy(Permission $permission)
    {
        try {
            $responseData = $permission->delete();
            return response()->json([
                "isRequest" => true,
                "isSuccess" => $responseData != 0 && $responseData != null,
                "isMessageError" => !$responseData != 0 || $responseData == null,
                "message" => $responseData != 0 && $responseData != null ? "TRANSACCION CORRECTA" : "TRANSACCION INCORRECTA",
                "messageError" => "",
                "data" => [],
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
