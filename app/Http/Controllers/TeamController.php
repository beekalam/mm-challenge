<?php

namespace App\Http\Controllers;

use App\Player;
use App\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    /**
     * TeamController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        return view('team.index', [
            'teams' => Team::withCount('players')->with('players')->latest()->paginate(5)
        ]);
    }

    public function show($id)
    {
        $team = Team::where('id', $id)->withCount('players')->with('players')->firstOrFail();
        return view('team.show', [
            'team' => $team
        ]);
    }

    public function create()
    {
        return view('team.create', [
            'team'    => new Team(),
            'players' => Player::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $team = Team::create([
            'name' => $request->input('name'),
        ]);
        $team->players()->attach($request->input('players', []));
        return redirect()->route('teams.show', $team->id);
    }

    public function edit($id)
    {
        $team = Team::where('id', $id)->withCount('players')->with('players')->firstOrFail();
        return view('team.edit', [
            'team'    => $team,
            'players' => Player::all()
        ]);
    }

    public function update($id, Request $request)
    {
        $team = Team::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        $team->update(['name' => request('name')]);
        $team->players()->sync($request->input('players', []));
        return redirect()->route('teams.show', $team->id);
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        return redirect()->route("teams.index");
    }
}
