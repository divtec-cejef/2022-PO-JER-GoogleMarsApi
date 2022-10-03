<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Base;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 *
 */
class BadgeController extends Controller
{

    /**
     * @return mixed
     */
    public function index()
    {
        return Badge::orderBy('id', 'ASC')->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(Badge::findOrFail($id));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id, Request $request)
    {
        $this->validate($request, Badge::validateRules());

        $badge = Badge::findOrFail($id);

        $badge->nom = $request->nom;
        $badge->prix = $request->prix;
        $badge->section_id = $request->section_id;
        $badge->update();

        return response()->json(['status' => 'successful', 'message' => 'Badge modifié avec succès !']);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, Badge::validateRules());

        $badge = new Badge();

        $badge->nom = $request->nom;
        $badge->prix = $request->prix;
        $badge->section_id = $request->section_id;

        $badge->save();
        return response()->json(['status' => 'successful', 'message' => 'Badge créé avec succès !']);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        Badge::findOrFail($id)->delete();
        return response()->json(['status' => 'successful', 'message' => 'Badge supprimé avec succès !']);
    }


    /**
     * @param $id
     * @param $badgeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id, $badgeId)
    {

        $user = User::findOrFail($id);

        if (DB::table('recevoir')->where('user_id', '=', $id)->where('badge_id', '=', $badgeId)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'L\'utilisateur possède déjà ce badge !'], 409);
        }

        $user->badge()->attach($badgeId);
        self::addCoins($id, $badgeId);

        return response()->json(['status' => 'successful', 'message' => 'Badge ajouté avec succès !']);
    }


    /**
     * @param $id
     * @param $badgeId
     * @return void
     */
    public static function addCoins($id, $badgeId)
    {
        $badge = Badge::findOrFail($badgeId);
        $base = Base::where('user_id', $id)->firstOrFail();
        $credits = $base->credit;
        $reward = $badge->prix;
        $credits += $reward;
        $base->credit = $credits;
        $base->save();
    }
}
