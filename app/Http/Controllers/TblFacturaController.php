<?php

namespace App\Http\Controllers;

use App\Models\TblFactura;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class TblFacturaController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $facturas = TblFactura::paginate(10);
        return view('components.facturas', ['facturas' => $facturas]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function indexApi(Request $request): JsonResponse
    {
        $facturas = TblFactura::query();

        if ($request->has('PedidoId')) {
            $facturas->where('PedidoId', $request->query('PedidoId'));
        }
        if ($request->has('fecha_factura')) {
            $facturas->where('fecha_factura', $request->query('fecha_factura'));
        }

        $perPage = $request->get('per_page', 10);
        $facturas = $facturas->paginate($perPage);

        return response()->json([
            'data' => $facturas->items(),
            'total' => $facturas->total(),
            'per_page' => $facturas->perPage(),
            'current_page' => $facturas->currentPage(),
            'last_page' => $facturas->lastPage(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'PedidoId' => 'required|exists:tblpedidos,PedidoId',
            'monto_total' => 'required|numeric|min:0',
            'fecha_factura' => 'required|date',
        ]);

        $factura = TblFactura::create($request->all());
        return response()->json($factura, 201);
    }

    public function show(int $id): JsonResponse
    {
        $factura = TblFactura::with('pedido')->find($id); // Eager load relación
        if (!$factura) {
            return response()->json(['message' => 'Factura no encontrada'], 404);
        }
        return response()->json($factura);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'PedidoId' => 'required|exists:tblpedidos,PedidoId',
            'monto_total' => 'required|numeric|min:0',
            'fecha_factura' => 'required|date',
        ]);

        $factura = TblFactura::find($id);
        if (!$factura) {
            return response()->json(['message' => 'Factura no encontrada'], 404);
        }

        $factura->update($request->all());
        return response()->json($factura);
    }

    public function destroy(int $id): JsonResponse
    {
        $factura = TblFactura::find($id);
        if (!$factura) {
            return response()->json(['message' => 'Factura no encontrada'], 404);
        }

        $factura->delete();
        return response()->json(['message' => 'Factura eliminada']);
    }
}
