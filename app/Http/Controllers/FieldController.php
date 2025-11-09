<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $field = Field::select('id', 'name', 'description', 'price')->get();

        return response()->json([
            'status' => 'Success',
            'message' => 'Berhasil Index Field',
            'data' => $field
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|min:10|max:25',
            'description' => 'required',
            'price' => 'required|numeric|min:50000'

        ]);

        $field = new Field();
        $field->name = $request->name;
        $field->description = $request->description;
        $field->price = $request->price;
        $field->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Field Berhasil di simpan',
            'data' => $field
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $field = Field::find($id);

        return response()->json([
            'status' => 'Succes',
            'message' => 'detail field berhasil disimpan',
            'data' => $field
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required|min:10|max:25',
            'description' => 'required',
            'price' => 'required|numeric|min:50000'

        ]);

        $field = Field::find($id);
        $field->name = $request->name;
        $field->description = $request->description;
        $field->price = $request->price;
        $field->save();

        return response()->json([
            'status' => 'Success',
            'message' => 'Update Product Berhasil Disimpan',
            'data' => $field
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $field = Field::find($id);
        $field->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Delete Field Berhasil Disimpan!',
            'data' => $field
        ]);
    }
}
