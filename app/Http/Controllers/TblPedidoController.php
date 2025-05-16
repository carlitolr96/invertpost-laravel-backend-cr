<?php

namespace App\Http\Controllers;

use App\Models\TblPedido;
use App\Models\TblCliente;
use App\Models\TblArticulo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TblPedidoController extends Controller
{
    /**
     * Muestra la vista con los pedidos paginados.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pedidos = TblPedido::with('cliente', 'articulo')->paginate(10);
        $clientes = TblCliente::all();
        $articulos = TblArticulo::all();
        return view('components.pedidos', compact('pedidos', 'clientes', 'articulos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:tblclientes,ClienteId',
            'articulo_id' => 'required|exists:tblarticulos,ArticuloId'
        ]);
        TblPedido::create([
            'ClienteId' => $request->cliente_id,
            'ArticuloId' => $request->articulo_id,
            'fecha_pedido' => now(),
        ]);
        
        return redirect()->route('pedidos.index')->with('success', 'Pedido agregado correctamente.');
    }

    public function indexApi(Request $request): JsonResponse
    {
        $pedidos = TblPedido::query();

        if ($request->has('ClienteId')) {
            $pedidos->where('ClienteId', $request->query('ClienteId'));
        }
        if ($request->has('fecha_pedido')) {
            $pedidos->where('fecha_pedido', $request->query('fecha_pedido'));
        }

        $perPage = $request->get('per_page', 10);
        $pedidos = $pedidos->with('cliente')->paginate($perPage);

        return response()->json([
            'data' => $pedidos->items(),
            'total' => $pedidos->total(),
            'per_page' => $pedidos->perPage(),
            'current_page' => $pedidos->currentPage(),
            'last_page' => $pedidos->lastPage(),
        ]);
    }

    public function storeApi(Request $request): JsonResponse
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
        $pedido = TblPedido::with('cliente', 'articulos', 'factura')->find($id);
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

    public function destroy($id)
    {
        $pedido = TblPedido::find($id);
        if (!$pedido) {
            return redirect()->route('pedidos.index')->with('error', 'Pedido no encontrado.');
        }

        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }
}
