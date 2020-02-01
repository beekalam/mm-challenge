@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8 mb-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>
                            {{ $player->name }} ( member
                            of {{ $player->teams_count  . Str::plural('team', $player->teams_count) }} )
                        </h4>
                        <h5>

                            @if(Auth::check())
                                <form action="{{ route('players.destroy',$player->id) }}"
                                      style="display: none;"
                                      method="post" id="delete-player">
                                    @method('DELETE')
                                    @csrf
                                </form>
                                <button class="btn btn-danger btn-sm"
                                        onclick="document.getElementById('delete-player').submit()">Delete
                                </button>
                                <a href="{{ route('players.edit',$player->id) }}" class="btn btn-sm">
                                    Edit
                                </a>
                            @endif
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <ul class="col-sm-12 col-md-6">
                                @foreach($player->teams as $team)
                                    <li>
                                        <a href="{{ route('teams.show',$team->id) }}">
                                            {{ $team->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="col-sm-12 col-md-6">
                                <img src="{{ asset('storage/' . $player->avatar_path) }}" alt="">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
