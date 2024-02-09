<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storecurte_playlistsRequest;
use App\Http\Requests\Updatecurte_playlistsRequest;
use App\Models\curte_playlists;

class CurtePlaylistsController extends Controller
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
    public function store(Storecurte_playlistsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(curte_playlists $curte_playlists)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(curte_playlists $curte_playlists)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatecurte_playlistsRequest $request, curte_playlists $curte_playlists)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(curte_playlists $curte_playlists)
    {
        //
    }
}
