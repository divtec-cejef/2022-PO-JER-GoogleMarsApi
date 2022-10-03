<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class BadgeCSSController extends Controller
{
    /**
     * @param Request $request
     * @param $badgeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function addBadgeCSS(Request $request, $badgeId)
    {
        $badges = [
            'CSS 1' => '1',
            'CSS 2' => '2',
            'CSS 3' => '3',
            'CSS 4' => '4',
            'CSS 5' => '5',
            'CSS 6' => '6'];

        $user = $request->user();

        if (!in_array($badgeId, $badges)) {
            return response()->json(['status' => 'error', 'message' => 'Impossible d\'ajouter ce badge'], 401);
        }

        if (DB::table('recevoir')->where('user_id', '=', $user->id)->where('badge_id', '=', $badgeId)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'L\'utilisateur possède déjà ce badge'], 409);
        }

        self::addCoins($user->id, $badgeId);
        $user->badge()->attach($badgeId);

        return response()->json(['status' => 'successful', 'message' => 'Badge ajouté avec succès']);
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