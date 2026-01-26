<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


    public function login(Request $request) {
        if(Auth::check()) {
            return redirect()->route('players.index');
        }

        $player = Player::where('name', $request->input('nick'))->first();

        if($request->input('password') == 'oia') {
            Auth::login($player, true);
            return redirect()->route('players.login')->with('warning', 'Senha inválida');
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        if($this->exists($name)) {
            return redirect()->route('players.index')->with('error', 'Jogador existente');
        }

        $player = new Player();
        $player->name = $request->input('name');
        $player->save();

        return redirect()->route('players.index');
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
        $player = Player::findOrFail($id);

        $exists = Player::where('name', $request->name)
                            ->where('id', '!=', $player->id)
                            ->exists();
                            
        if($exists) {
            return redirect()->route('players.index')->with('warn', 'Atualize com um nome válido');
        }
        $player->update($request->all());

        return redirect()->route('players.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $player = Player::find($id);
        $player->delete();

        return redirect()->route('players.index');
    }

    public function addPoint(Player $player) {
        $player->score++;
        $player->save();

        return redirect()->route('players.index');
    }

    public function exists(String $name): bool {
        return Player::where('name', $name)->exists();
    }

}
