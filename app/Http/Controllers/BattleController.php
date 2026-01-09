<?php

namespace App\Http\Controllers;

use App\Models\Battle;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Models\PlayerPerformance;

class BattleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $performance = Player::all();
        return view('team.home', compact('performance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $players = Player::all();
        return view('team.create', compact('players'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    
        $playersData = $request->players;
        $totalKills = array_sum(array_column($playersData, 'kills'));
        $surviveTime = max(array_column($playersData, 'survival_minutes'));

        $battle = Battle::create([
            'score' => $request->score,
            'placing' => $request->placing,
            'map' => $request->map,
            'total_kills' => $totalKills,
            'survive_time' => $surviveTime
        ]);

        foreach ($request->players as $playerData) {
            $player = Player::find($playerData['id']);
            if ($playerData['survival_minutes']<1) continue; 

            $player->kills += $playerData['kills'];
            $player->average_survive = 
                ($player->average_survive * $player->matches_amount + $playerData['survival_minutes'])
                / ($player->matches_amount + 1);
            $player->matches_amount++;
            $player->save();
            
            PlayerPerformance::create([
                'match_id' => $battle->id,
                'player_id' => $player->id,
                'kills' => $playerData['kills'],
                'individual_survive' => $playerData['survival_minutes'],
            ]);
        }

        return redirect()->route('partidas.index')->with('success', 'Resultado cadastrado!');
}


    /**
     * Display the specified resource.
     */
    public function show(Battle $battle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Battle $battle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Battle $battle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Battle $battle)
    {
        //
    }
}
