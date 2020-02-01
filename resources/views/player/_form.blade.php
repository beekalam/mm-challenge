<div class="form-group">
    <input type="file" name="avatar" id="avatar">
</div>

<div class="form-group">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name"
           class="form-control"
           value="{{ $player->name }}" required>
</div>

<div class="form-group">
    <label for="players">Teams:</label>
    <select name="teams[]" id="teams" class="form-control" multiple="multiple">
        @foreach($teams as $team)
            <option value="{{ $team->id }}"
                    @if($player->teams->contains($team))
                    selected="selected"
                @endif>
                {{ $team->name }}
            </option>
        @endforeach
    </select>
</div>
