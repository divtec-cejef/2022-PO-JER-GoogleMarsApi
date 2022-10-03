<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;


/**
 *
 */
class UserController extends Controller
{

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return User::with(['base', 'responsable'])->orderBy('id', 'ASC')->get()
            ->makeHidden(['website'])->toArray();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json(User::with(['base', 'badge', 'responsable'])->findOrFail($id));
    }


    public function delete($id)
    {
        $userToDelete = User::findOrFail($id);

        try {

            if ($userToDelete->base != null) {
                Base::where('user_id', $id)->firstOrFail()->delete();
            }
            $userToDelete->badge()->detach();
            $userToDelete->responsable()->detach();
            $userToDelete->delete();
        } catch (Exception $e) {
            if ($userToDelete->base != null) {
                Base::where('user_id', $id)->firstOrFail()->delete();
            }
            $userToDelete->delete();
        }

        return response()->json(['status' => 'successful', 'message' => 'Joueur supprimé avec succès !']);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function website(Request $request, $id)
    {

        $this->validate($request, [
            'website' => 'required'
        ]);

        $clean_html = strip_tags(($request->website), ['div', 'a', 'img', 'p', 'h1', 'hr', 'section', 'br']);

        $user = User::findOrFail($id);
        $user->website = $clean_html;

        $user->save();
        return response()->json(['status' => 'successful', 'message' => 'Site ajouté avec succès']);
    }
}
