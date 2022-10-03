<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


/**
 *
 */
class BaseController extends Controller
{

    /**
     * @return mixed
     */
    public function index()
    {
        return Base::orderBy('id', 'ASC')->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(['base' => Base::findOrFail($id), 'user' => User::findOrFail(Base::findOrFail($id)->user_id)]);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|void
     * @throws Exception
     */
    public function register($id)
    {
        $user = User::findOrFail($id);

        try {

            $base = new Base();
            $base->nom = "Base de " . $user->username;
            $base->user_id = $id;

            list($position_x, $position_y) = self::setLocationBase();
            $base->position_x = $position_x;
            $base->position_y = $position_y;
            $base->img_base = random_int(1, 3);

            if ($base->save()) {
                return response()->json(['status' => 'successful', 'message' => 'Base ajoutée avec succès']);
            }
        } catch (ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e], 422);
        }
    }

    /**
     * @return array
     */
    public function setLocationBase()
    {
        try {
            return self::getRandomLocationBase(4);
        } catch (Exception $e) {
            return self::getRandomLocationBase(2);
        }
    }

    /**
     * @param $espacement
     * @return array
     * @throws Exception
     */
    public function getRandomLocationBase($espacement): array
    {
        do {
            $position_x = random_int(5, 79);
            $position_y = random_int(10, 290);

        } while (DB::table('bases')
            ->where('position_x', '<', $position_x + $espacement)
            ->where('position_x', '>', $position_x - $espacement)
            ->where('position_y', '<', $position_y + $espacement)
            ->where('position_y', '>', $position_y - $espacement)
            ->exists());
        return [$position_x, $position_y];
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function oxygenDepletion()
    {
        $allBases = Base::where('oxygene', '>', 0)->get();
        foreach ($allBases as $base) {

            if ($base->oxygene < 2)
                $base->oxygene -= 1;
            else
                $base->oxygene -= 2;

            $base->update();
        }

        $allDeadBases = Base::where('oxygene', 0)->where('date_fin', '=', null)->get();
        foreach ($allDeadBases as $deadBase) {
            $deadBase->date_fin = Carbon::now();
            $deadBase->update();
        }
        return response()->json(['status' => 'successful', 'message' => 'Niveau d\'oxygène descendu avec succès']);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function oxygenReplenishment(Request $request)
    {

        $MAX_OXYGENE = 100;
        $base = Base::where('user_id', $request->user()->id)->firstOrFail();
        $creditBase = $base->credit;
        $oxygeneBase = $base->oxygene;
        $oxygeneARajouter = 0;

        do {
            $oxygeneARajouter += 1;
        } while (($creditBase - $oxygeneARajouter * 5) >= 5 && ($oxygeneBase + $oxygeneARajouter) < $MAX_OXYGENE);

        if ($creditBase < 5) // si il n'a pas assez d'argent
            return response()->json(['status' => 'error', 'message' => 'Crédits insuffisants !'], 409);


        if ($oxygeneBase == $MAX_OXYGENE) {
            return response()->json(['status' => 'error', 'message' => 'Niveau d\'oxygène au maximum !'], 409);
        }

        if ($base->date_fin != null) {
            return response()->json(['status' => 'error', 'message' => 'Réapprovisionnement impossibe !'], 409);
        }

        $base->credit = $creditBase - $oxygeneARajouter * 5;
        $base->oxygene = ($oxygeneBase + $oxygeneARajouter >= 100) ? (100) : ($oxygeneBase + $oxygeneARajouter);

        $base->update();
        return response()->json(['status' => 'successful', 'message' => 'Réapprovisionnement d\'oxygène avec succès']);
    }

}