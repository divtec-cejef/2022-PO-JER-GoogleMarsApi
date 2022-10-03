<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

/**
 *
 */
class AdminController extends Controller
{
    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ResetPasswordUser($id, Request $request)
    {

        $this->validate($request, [
                'password' => 'required|string|max:20',
            ]
        );

        $user = User::findOrFail($id);
        $user->password = app('hash')->make($request->password);
        $user->update();

        return response()->json(['status' => 'successful', 'message' => 'Mot de passe modifié avec succès !']);


    }
}
