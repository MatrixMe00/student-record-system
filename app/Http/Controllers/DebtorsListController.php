<?php

namespace App\Http\Controllers;

use App\Models\DebtorsList;
use App\Http\Requests\StoreDebtorsListRequest;
use App\Http\Requests\UpdateDebtorsListRequest;

class DebtorsListController extends Controller
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
    public function store(StoreDebtorsListRequest $request)
    {
        $validated = $request->validated();
        $data = array_slice($validated, 1);
    }

    /**
     * Display the specified resource.
     */
    public function show(DebtorsList $debtorsList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DebtorsList $debtorsList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDebtorsListRequest $request, DebtorsList $debtorsList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DebtorsList $debtorsList)
    {
        //
    }
}
