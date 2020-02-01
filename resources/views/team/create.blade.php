@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8 mb-2">
                <div class="card">
                    <div class="card-header">{{ $team->name }} ( {{ $team->players_count }} players)</div>

                    <div class="card-body">
                        <form action="{{ route('teams.store') }}" method="post"
                              class="form">
                            @csrf
                            @include('team._form')

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
                $('#players').select2();
            });
        </script>
    @endpush

@endsection
