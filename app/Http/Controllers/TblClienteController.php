<?php

namespace App\Http\Controllers;

use App\Models\TblCliente;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class TblClienteController extends Controller
{
    /**
     * Muestra la vista con los clientes paginados.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $clientes = TblCliente::paginate(10);
        return view('components.clientes', ['clientes' => $clientes]);
    }

    /**
     * Devuelve los clientes en formato JSON (API).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function indexApi(Request $request): JsonResponse
    {
        $query = TblCliente::query();

        if ($request->has('nombre')) {
            $query->where('nombre', 'like', '%' . $request->query('nombre') . '%');
        }
        if ($request->has('telefono')) {
            $query->where('telefono', $request->query('telefono'));
        }
        if ($request->has('tipo_cliente')) {
            $query->where('tipo_cliente', $request->query('tipo_cliente'));
        }

        $perPage = $request->get('per_page', 10);
        $clientes = $query->paginate($perPage);

        return response()->json([
            'data' => $clientes->items(),
            'total' => $clientes->total(),
            'per_page' => $clientes->perPage(),
            'current_page' => $clientes->currentPage(),
            'last_page' => $clientes->lastPage(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required',
            'telefono' => 'required',
            'tipo_cliente' => 'required',
        ]);

        $cliente = TblCliente::create($request->all());
        return response()->json($cliente, 201);
    }

    public function show(int $id): JsonResponse
    {
        $cliente = TblCliente::find($id);
        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }
        return response()->json($cliente);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'nombre' => 'required',
            'telefono' => 'required',
            'tipo_cliente' => 'required',
        ]);

        $cliente = TblCliente::find($id);
        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $cliente->update($request->all());
        return response()->json($cliente);
    }

    public function destroy(int $id): JsonResponse
    {
        $cliente = TblCliente::find($id);
        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $cliente->delete();
        return response()->json(['message' => 'Cliente eliminado']);
    }

    public function edit(TblCliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }
}
