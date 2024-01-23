<?php

namespace App\Http\Controllers;

use App\Models\other;
use App\Http\Requests\StoreotherRequest;
use App\Http\Requests\UpdateotherRequest;

class OtherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreotherRequest $request)
    {
        $validated = $request->validated();
    }

    /**
     * Display the specified resource.
     */
    public function show(other $other)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(other $other)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateotherRequest $request, other $other)
    {
        $validated = $request->validated();
        $other->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(other $other)
    {
        //
    }
}
