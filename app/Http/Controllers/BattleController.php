<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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
    // Load all performances with related player and battle
    $team = PlayerPerformance::with(['player', 'battle'])->get();

    // Default map filter
    $mapa = 'todos';

    // Get unique players from the performances
    $players = $team->pluck('player')->unique('id');

    $battles = Battle::all();
    // dd($battles);
    // dd(vars: $team);
    return view('team.home', compact('team', 'mapa', 'players', 'battles'));
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
            if ($playerData['survival_minutes'] < 1) continue; 

            $player->kills += $playerData['kills'];
            $player->average_survive =
                ($player->average_survive * $player->matches_amount + $playerData['survival_minutes'])
                / ($player->matches_amount + 1);
            $player->matches_amount++;
            $player->save();

            PlayerPerformance::create([
                'match_id' => $battle->id,
                'player_id' => $player->id,
                'map' => $request->map,
                'individual_kills' => $playerData['kills'],
                'individual_survive' => $playerData['survival_minutes'],
            ]);
        }
        return redirect()->route('partidas.index')->with('success', 'Resultado cadastrado!');
    }

    /**
     * Filter results by map
     */
    public function filterResultsByMap(Request $request)
{
    $mapa = $request->query('map', 'todos');

    // Get performances
    $team = PlayerPerformance::with(['battle', 'player'])
        ->when($mapa != 'todos', fn($q) => $q->where('map', $mapa))
        ->get();

    $players = $team->pluck('player')->unique('id');

    // Get battles that exist in the performances
    $battleIds = $team->pluck('match_id')->unique();
    $battles = Battle::whereIn('id', $battleIds)->get();

    return view('team.home', compact('team', 'mapa', 'players', 'battles'));
}


}
