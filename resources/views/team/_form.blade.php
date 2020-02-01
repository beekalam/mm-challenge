<div class="form-group">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name"
           class="form-control"
           value="{{ $team->name }}" required>
</div>

<div class="form-group">
    <label for="players">Players:</label>
    <select name="players[]" id="players" class="form-control" multiple="multiple">
        @foreach($players as $player)
            <option value="{{ $player->id }}"
                    @if($team->players->contains($player))
                    selected="selected"
                @endif>
                {{ $player->name }}
            </option>
        @endforeach
    </select>
</div>
