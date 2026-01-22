<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Battle;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Models\PlayerPerformance;
use Exception;

class BattleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $map = 'todos';
        $query = PlayerPerformance::with('player');
        $battle = ($map == 'todos') ?Battle::all() :Battle::where('map', $map)->get();
        $team = $query->get();
        
        $playersStatus = $team
            ->groupBy('player_id')
            ->map(function ($performances) {
                $matches = $performances->count();
                $kills = $performances->sum('individual_kills');

                return [
                    'player' => $performances->first()->player()->first(),
                    'matches' => $matches,
                    'kills' => $kills,
                    'kills_avg' => ($matches > 0) ? round($kills / $matches, 1) : 0,
                    'survival_avg' => ($matches > 0) ? round($performances->avg('individual_survive'), 1) : 0
                ];
            })->sortByDesc('kills_avg')->values();

        return view('team.home', [
            'playersStatus' => $playersStatus,
            'team' => $team,
            'battles' => $battle,
            'map' => $map,
        ]);
    }

    public function filterResultsByMap(Request $request)
    {
        $map = $request->query('map', 'todos');
        $query = PlayerPerformance::with('player');
        $battle = ($map == 'todos') ?Battle::all() :Battle::where('map', $map)->get();

        if ($map != 'todos') {
            $query->where('map', $map);
        }

        $team = $query->get();
        
        $playersStatus = $team
            ->groupBy('player_id')
            ->map(function ($performances) {
                $matches = $performances->count();
                $kills = $performances->sum('individual_kills');

                return [
                    'player' => $performances->first()->player()->first(),
                    'matches' => $matches,
                    'kills' => $kills,
                    'kills_avg' => ($matches > 0) ? round($kills / $matches, 1) : 0,
                    'survival_avg' => ($matches > 0) ? round($performances->avg('individual_survive'), 1) : 0
                ];
            })->sortByDesc('kills_avg')->values();

        return view('team.home', [
            'playersStatus' => $playersStatus,
            'team' => $team,
            'battles' => $battle,
            'map' => $map,
        ]);
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
        try {
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
                if ($playerData['survival_minutes'] < 1)
                    continue;

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
        } catch (Exception $e) {
            return redirect()->route('partidas.create')->with('warning', 'Preencha corretamente os campos');
        }
    }

    /**
     * Filter results by map
     */



}
