<?php

namespace App\Http\Controllers;

use App\Models\TblArticulo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class TblArticuloController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $articulos = TblArticulo::paginate(10);
        return view('components.articulos', ['articulos' => $articulos]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function indexApi(Request $request): JsonResponse
    {
        $articulos = TblArticulo::query();

        if ($request->has('nombre')) {
            $articulos->where('descripcion', 'like', '%' . $request->query('nombre') . '%');
        }
        if ($request->has('precio_min') && $request->has('precio_max')) {
            $articulos->whereBetween('precio', [$request->query('precio_min'), $request->query('precio_max')]);
        }
        if ($request->has('stock_min')) {
            $articulos->where('stock', '>=', $request->query('stock_min'));
        }

        $perPage = $request->get('per_page', 10);
        $articulos = $articulos->paginate($perPage);

        return response()->json([
            'data' => $articulos->items(),
            'total' => $articulos->total(),
            'per_page' => $articulos->perPage(),
            'current_page' => $articulos->currentPage(),
            'last_page' => $articulos->lastPage(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fabricante' => 'required|string|max:255',
            'codigo_barras' => 'required|string|unique:tblarticulos|max:20',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $articulo = TblArticulo::create($request->all());
        return response()->json($articulo, 201);
    }

    public function show(int $id): JsonResponse
    {
        $articulo = TblArticulo::find($id);
        if (!$articulo) {
            return response()->json(['message' => 'Artículo no encontrado'], 404);
        }
        return response()->json($articulo);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fabricante' => 'required|string|max:255',
            'codigo_barras' => 'required|string|unique:tblarticulos,codigo_barras,' . $id . '|max:20',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $articulo = TblArticulo::find($id);
        if (!$articulo) {
            return response()->json(['message' => 'Artículo no encontrado'], 404);
        }

        $articulo->update($request->all());
        return response()->json($articulo);
    }

    public function destroy(int $id): JsonResponse
    {
        $articulo = TblArticulo::find($id);
        if (!$articulo) {
            return response()->json(['message' => 'Artículo no encontrado'], 404);
        }

        $articulo->delete();
        return response()->json(['message' => 'Artículo eliminado']);
    }
}
