<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoremusicasRequest;
use App\Http\Requests\UpdatemusicasRequest;
use App\Models\musicas;

class MusicasController extends Controller
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
    public function store(StoremusicasRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(musicas $musicas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(musicas $musicas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatemusicasRequest $request, musicas $musicas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(musicas $musicas)
    {
        //
    }
}
