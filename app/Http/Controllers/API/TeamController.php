<?php


namespace App\Http\Controllers\API;

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

class TeamController extends ResponseController
{
    use Responsive;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        return $this->respond(['teams' => Team::with('players')->paginate(5)]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $team = Team::findOrFail($id);
        return $this->respond(['team' => $team]);
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
        $team = Team::create($values);
        return $this->respond(['team' => $team], trans('messages.created'), 201);
    }

    /**
     * @param         $id
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function edit($id, Request $request)
    {
        $team = Team::findOrFail($id);
        $values = $this->validate($request, [
            'name' => 'required|string'
        ]);

        $team->update($request->only(['name']));
        return $this->respond(['team' => $team]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        return $this->respond([], trans('messages.delete', ['attr' => '']));
    }
}
