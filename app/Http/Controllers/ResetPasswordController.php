<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Lumen\Routing\Controller as BaseController;
use voku\helper\AntiXSS;

/**
 *
 */
class ResetPasswordController extends BaseController
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send(Request $request)
    {
        $this->validate($request, User::emailSendValidation());

        $antiXss = new AntiXSS();
        $email = $antiXss->xss_clean($request->email);

        if (!User::where('email', $email)->first()) {
            return response()->json(['status' => 'error', 'message' => 'Email invalide !'], 404);
        }
        $token = $this->createToken($email);

        $this->sendMailReset(User::where('email', $email)->first(), $email, $token);
        return response()->json(['status' => 'successful', 'message' => 'Email de réinitialisation envoyé !']);

    }


    /**
     * @param $email
     * @return mixed|string
     */
    public function createToken($email)
    {
        $oldToken = DB::table('password_resets')->where('email', $email)->first();

        if ($oldToken) {
            return $oldToken->token;
        }

        $token = Str::random(40);
        $this->saveToken($token, $email);
        return $token;
    }


    /**
     * @param $token
     * @param $email
     * @return void
     */
    public function saveToken($token, $email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    public function sendMailReset($name, $email, $token)
    {
        $client = new Client([
            'base_uri' => '',
        ]);

        $response = $client->request('GET', '/api/mail', [
            'query' => [
                't' => 'reset',
                'name' => $name,
                'email' => $email,
                'token' => $token
            ]
        ]);

        $body = $response->getBody();
        $arr_body = json_decode($body);
        print_r($arr_body);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function passwordResetProcess(Request $request)
    {

        $this->validate($request, User::emailResetValidation());

        if ($this->updatePasswordRow($request)->count() > 0)
            return $this->resetPassword($request);
        else
            return response()->json(['status' => 'error', 'message' => 'Impossible de modifier le mot de passe !'], 409);
    }

    /**
     * @param $request
     * @return \Illuminate\Database\Query\Builder
     */
    private function updatePasswordRow($request)
    {
        return DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->resetToken
        ]);
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function resetPassword($request)
    {

        $user = User::whereEmail($request->email)->first();

        $user->password = app('hash')->make($request->password);
        $user->update();

        $this->updatePasswordRow($request)->delete();

        return response()->json(['status' => 'successful', 'message' => 'Mot de passe modifié avec succès']);

    }

}