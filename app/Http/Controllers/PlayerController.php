<?php

namespace App\Http\Controllers;

use App\Player;
use App\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{

    /**
     * PlayerController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        return view('player.index', [
            'players' => Player::withCount('teams')->with('teams')->latest()->paginate(5)
        ]);
    }

    public function edit($id, Request $request)
    {
        $player = Player::findOrFail($id);
        return view('player.edit', [
            'teams'  => Team::all(),
            'player' => $player
        ]);

    }

    public function update($id, Request $request)
    {
        $player = Player::findOrFail($id);
        $this->validate($request, [
            'name'   => 'required|string',
            'avatar' => 'filled|image'
        ]);

        $player->update([
            'name' => request('name'),
        ]);

        if ($request->hasFile('avatar')) {
            $player->update([
                'avatar_path' => request()->file('avatar')->store('avatars', 'public')
            ]);
        }

        $player->teams()->sync($request->input('teams', []));
        return redirect()->route('players.show', $player->id);
    }

    public function show($id)
    {
        $player = Player::where('id', $id)
                        ->with('teams')
                        ->withCount('teams')
                        ->firstOrFail();

        return view('player.show', [
            'player' => $player
        ]);
    }

    public function create()
    {
        return view('player.create', [
            'teams'  => Team::all(),
            'player' => new Player()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        $player = Player::create(['name' => request('name')]);
        if ($request->hasFile('avatar')) {
            $player->update([
                'avatar_path' => request()->file('avatar')->store('avatars', 'public')
            ]);
        }
        $player->teams()->attach($request->input('teams', []));
        return redirect()->route('players.show', $player->id);
    }

    public function destroy($id)
    {
        $player = Player::findOrFail($id);
        $player->delete();
        return redirect()->route("players.index");
    }
}
