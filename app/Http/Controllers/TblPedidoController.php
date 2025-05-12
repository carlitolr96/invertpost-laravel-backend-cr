<?php

namespace App\Http\Controllers;

use App\Models\TblPedido;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TblPedidoController extends Controller
{
     /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $pedidos = TblPedido::paginate(10);
        return view('components.pedidos', ['pedidos' => $pedidos]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function indexApi(Request $request): JsonResponse
    {
        $pedidos = TblPedido::query();

        // Filtros
        if ($request->has('ClienteId')) {
            $pedidos->where('ClienteId', $request->query('ClienteId'));
        }
        if ($request->has('fecha_pedido')) {
            $pedidos->where('fecha_pedido', $request->query('fecha_pedido'));
        }

        // Paginación
        $perPage = $request->get('per_page', 10);
        $pedidos = $pedidos->paginate($perPage);

        return response()->json([
            'data' => $pedidos->items(),
            'total' => $pedidos->total(),
            'per_page' => $pedidos->perPage(),
            'current_page' => $pedidos->currentPage(),
            'last_page' => $pedidos->lastPage(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'ClienteId' => 'required|exists:tblclientes,ClienteId',
            'fecha_pedido' => 'required|date',
        ]);

        $pedido = TblPedido::create($request->all());
        return response()->json($pedido, 201);
    }

    public function show(int $id): JsonResponse
    {
        $pedido = TblPedido::with('cliente', 'articulos', 'factura')->find($id); // Eager load relaciones
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }
        return response()->json($pedido);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'ClienteId' => 'required|exists:tblclientes,ClienteId',
            'fecha_pedido' => 'required|date',
        ]);

        $pedido = TblPedido::find($id);
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $pedido->update($request->all());
        return response()->json($pedido);
    }

    public function destroy(int $id): JsonResponse
    {
        $pedido = TblPedido::find($id);
        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        $pedido->delete();
        return response()->json(['message' => 'Pedido eliminado']);
    }
}
