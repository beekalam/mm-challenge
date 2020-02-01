<?php


namespace App\Http\Controllers\API;

use App\Player;
use App\Team;
use App\Traits\Responsive;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;

use Illuminate\Validation\ValidationException;
use Validator;

class PlayerController extends ResponseController
{
    use Responsive;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        return $this->respond(['players' => Player::with('teams')->paginate(5)]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $player = Player::findOrFail($id);
        return $this->respond(['player' => $player]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request)
    {
        $values = $this->validate($request, [
            'name' => 'required|string'
        ]);
        $player = Player::create($values);
        return $this->respond(['Player' => $player], trans('messages.created'), 201);
    }

    /**
     * @param         $id
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function edit($id, Request $request)
    {
        $player = Player::findOrFail($id);
        $values = $this->validate($request, [
            'name' => 'required|string'
        ]);

        $player->update($request->only(['name']));
        return $this->respond(['player' => $player]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $player = Player::findOrFail($id);
        $player->delete();
        return $this->respond([], trans('messages.delete', ['attr' => '']));
    }
}
