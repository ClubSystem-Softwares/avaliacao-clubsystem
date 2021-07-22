<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Retornar todos os produtos

    public function index()
    {
        $products = Product::all()->toArray();
        return array_reverse($products);
    }

    // Adicionar produto

    public function add(Request $request)
    {
        $product = new Product([
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'quantidade' => $request->quantidade
        ]);
        $product->save();

        return response()->json([
            'message' => 'Produto adicionado com sucesso'
        ], 201);
    }

    // Editar produto

    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    // Atualizar produto

    public function update($id, Request $request)
    {
        $product = Product::find($id);
        $product->update($request->all());

        return response()->json('Produto atualizado');
    }

    // Deletar produto

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json([
            'message' => 'Produto deletado com sucesso'
        ], 410);
    }
}
