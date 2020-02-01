@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">


            <div class="col-md-8 mb-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>
                            {{ $team->name }} ( {{ $team->players_count }} players)
                        </h4>
                        <h5>
                            @if(Auth::check())
                                <form action="{{ route('teams.destroy',$team->id) }}"
                                      style="display: none;"
                                      method="post" id="delete-team">
                                    @method('DELETE')
                                    @csrf
                                </form>
                                <button class="btn btn-danger btn-sm"
                                        onclick="document.getElementById('delete-team').submit()">Delete
                                </button>
                                <a href="{{ route('teams.edit',$team->id) }}" class="btn btn-sm">
                                    Edit
                                </a>
                            @endif
                        </h5>
                    </div>

                    <div class="card-body">
                        <ul>
                            @foreach($team->players as $player)
                                <li>
                                    <a href="{{ route('players.show',$player->id) }}">
                                        {{ $player->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
