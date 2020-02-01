@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8 mb-2">
                <div class="card">
                    <div class="card-header">{{ $player->name }} ( {{ $player->teams_count }} players)</div>

                    <div class="card-body">
                        <form action="{{ route('players.store') }}" method="post"
                              class="form">
                            @csrf
                            @include('player._form')


                            <button type="submit" class="btn btn-secondary">Store</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#teams').select2();
            });
        </script>
    @endpush

@endsection
