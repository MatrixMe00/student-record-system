<?php

namespace App\Http\Controllers;

use App\Models\BECEResults;
use App\Http\Requests\StoreBECEResultsRequest;
use App\Http\Requests\UpdateBECEResultsRequest;

class BECEResultsController extends Controller
{
    private const DEFAULT_SUBJECTS = [
        "English Language", "Mathematics", "Integrated Science",
        "Social Studies", "Religious and Moral Education",
        "Information and Communication Technology", "Ghanaian Language"
    ];

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
    public function store(StoreBECEResultsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BECEResults $bECEResults)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BECEResults $bECEResults)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBECEResultsRequest $request, BECEResults $bECEResults)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BECEResults $bECEResults)
    {
        //
    }
}
