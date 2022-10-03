<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\Exception;
use voku\helper\AntiXSS;


/**
 *
 */
class ResponsableController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws Exception
     */
    public function createResponsable(Request $request)
    {

        $antiXss = new AntiXSS();

        $this->validate($request, [
                'first_name' => 'required|string|max:20',
                'last_name' => 'required|string|max:20',
                'email' => 'required|email|unique:users',
                'is_admin' => 'required|boolean',
            ]
        );


        $randomPassword = $this->randomPassword(8);

        $user = new User();
        $user->first_name = ($antiXss->xss_clean($request->first_name));
        $user->last_name = ($antiXss->xss_clean($request->last_name));
        $user->username = $antiXss->xss_clean($request->first_name . "." . $request->last_name);
        $user->email = $antiXss->xss_clean($request->email);
        $user->is_admin = $antiXss->xss_clean($request->is_admin);
        $user->password = app('hash')->make($randomPassword);
        $user->ip_adress = $request->ip();

        if ($user->save())
            $this->sendMailResponsable($user->first_name, $user->email, $randomPassword);
        return response()->json(['status' => 'successful', 'message' => 'Responsable créé avec succès']);
    }

    /**
     * @param $length
     * @return false|string
     */
    public static function randomPassword($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }


    public function sendMailResponsable($name, $email, $mdp)
    {
        $client = new Client([
            'base_uri' => '',
        ]);

        $response = $client->request('GET', '/api/mail', [
            'query' => [
                't' => 'responsable',
                'name' => $name,
                'email' => $email,
                'mdp' => $mdp
            ]
        ]);

        $body = $response->getBody();
        $arr_body = json_decode($body);
        print_r($arr_body);
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addResponsable($id, Request $request)
    {
        $user = User::findOrFail($id);
        $badges = explode(';', $request->badges_id);

        $badgesResponsable = DB::table('responsable')->where('user_id', '=', $id)->get();
        foreach ($badgesResponsable as $badge) {
            DB::table('responsable')->where('id', $badge->id)->delete();
        }

        if ($request->badges_id != '') {
            foreach ($badges as $badge) {
                $user->responsable()->attach($badge);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Aucun badge séléctionné !'], 409);
        }

        return response()->json(['status' => 'successful', 'message' => 'Badges ajoutés avec succès']);
    }


}
