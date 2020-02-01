@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1>List of Players</h1>
        </div>
        <div class="row justify-content-center">

            @foreach($players as $player)
                <div class="col-md-8 mb-2">
                    <div class="card">

                        <div class="card-header d-flex justify-content-between">
                            <h4>
                                {{ $player->name }} (member of {{ $player->teams_count }} teams)

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
                            <ul class="">
                                @forelse($player->teams as $team)
                                    <li>
                                        <a href="/teams/{{$team->id}}">
                                            {{ $team->name }}
                                        </a>
                                    </li>
                                @empty
                                    Is member of no Team yet.
                                @endforelse
                            </ul>

                        </div>
                    </div>
                </div>
            @endforeach
            {{ $players->links() }}

        </div>

    </div>
@endsection
