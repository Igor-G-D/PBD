<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreplaylistsRequest;
use App\Http\Requests\UpdateplaylistsRequest;
use App\Models\playlists;

class PlaylistsController extends Controller
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
    public function store(StoreplaylistsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(playlists $playlists)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(playlists $playlists)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateplaylistsRequest $request, playlists $playlists)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(playlists $playlists)
    {
        //
    }
}
