<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = Player::orderByDesc('score')->get();
        return view('index', compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        if(Player::where('name', $name)->exists()) {
            return redirect()->route('index')->with('error', 'Jogador Existente');
        }

        $player = new Player();
        $player->name = $request->input('name');
        $player->save();

        return redirect()->route('index');
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
    public function edit(string $id)
    {
        $player = Player::find($id);
        return view ('edit', compact('player'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $player = Player::find($id);
        $player->update($request->all());

        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $player = Player::find($id);
        $player->delete();

        return redirect()->route('index');
    }

    public function addPoint(Player $player) {
        $player->score++;
        $player->save();

        return redirect()->route('index');
    }

    public function exists(String $name): bool {
        return Player::where('name', $name)->exists();
    }
}
