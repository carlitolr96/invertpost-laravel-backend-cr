<?php

namespace App\Http\Controllers;

use App\Models\TblPY1;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class TblPY1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $users = TblPY1::query();

        // Filtros
        if ($request->has('usuario')) {
            $users->where('usuario', 'like', '%' . $request->query('usuario') . '%');
        }
        if ($request->has('cedula')) {
            $users->where('cedula', $request->query('cedula'));
        }

        // Paginación
        $perPage = $request->get('per_page', 10);
        $users = $users->paginate($perPage);

        return response()->json([
            'data' => $users->items(),
            'total' => $users->total(),
            'per_page' => $users->perPage(),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'usuario' => 'required|string|unique:tblpy1s|max:255',
            'password' => 'required|string|min:8',
            'cedula' => 'required|string|unique:tblpy1s|max:20',
            'telefono' => 'required|string|max:20',
            'tipo_sangre' => 'required|string|max:5',
        ]);

        $userData = $request->all();
        $userData['password'] = Hash::make($userData['password']);

        $user = TblPY1::create($userData);
        return response()->json($user, 201);
    }

    public function show(int $id): JsonResponse
    {
        $user = TblPY1::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        return response()->json($user);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'usuario' => 'string|unique:tblpy1s,usuario,' . $id . '|max:255',
            'password' => 'string|min:8',
            'cedula' => 'string|unique:tblpy1s,cedula,' . $id . '|max:20',
            'telefono' => 'string|max:20',
            'tipo_sangre' => 'string|max:5',
        ]);

        $userData = $request->all();
        if ($request->has('password')) {
            $userData['password'] = Hash::make($userData['password']);
        }

        $user = TblPY1::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->update($userData);
        return response()->json($user);
    }

    public function destroy(int $id): JsonResponse
    {
        $user = TblPY1::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'Usuario eliminado']);
    }
}