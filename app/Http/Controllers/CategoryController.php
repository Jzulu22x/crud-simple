<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Creamos una variable, y la igualamos al modelo, dandole el metodo all, que obtiene todos los datos de la tabla categoria;
        $categories = Category::all();

        //Retorno a la vista, de manera compacta los datos de la tabla categoria
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categoryEdit = Category::find($id);

        if (!$categoryEdit) {
            return redirect()->route('categories.index')->with('error', 'Category not found');
        }

        // Retorna la vista de edición, pasando la categoría a editar
        return view('categories.edit', compact('categoryEdit'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        // Encuentra la categoría por ID
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found');
        }

        // Actualiza los campos
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->save(); // Guarda los cambios

        // Redirige de vuelta a la lista de categorías con un mensaje de éxito
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categoryDelete = Category::find($id);

        if (!$categoryDelete) {
            return redirect()->route('categories.index')->with('error', 'Category not found');
        }

        $categoryDelete->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
