<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Todo::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        return Todo::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $id)
    {
        return $id;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $id)
    {
        $data = $request->all();
        $id->fill($data);
        $id->save();
        return $id;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
//        $id->delete();
        $todo = Todo::find($id);
        $todo->delete();
        return $todo;
    }
}
