<?php

namespace App\Http\Controllers;

use App\Models\User;
use EmailChecker\EmailChecker;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use voku\helper\AntiXSS;


/**
 *
 */
class AuthController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function register(Request $request)
    {
        $antiXss = new AntiXSS();
        $BaseController = new BaseController();
        $checker = new EmailChecker();


        try {
            $this->validate($request, User::validateRules(), [
                'required' => 'Le champ :attribute est obligatoire',
                'email' => 'L\'email est invalide',
                'same' => 'Les mots de passe ne correspondent pas'
            ]);

            $email = $antiXss->xss_clean($request->email);

            if (!$checker->isValid($email)) {
                return response()->json(['status' => 'error', 'message' => 'L\'email est invalide'], 409);
            }

            $user = new User();
            $user->first_name = $this->clean($antiXss->xss_clean($request->first_name));
            $user->last_name = $this->clean($antiXss->xss_clean($request->last_name));
            $user->username = $this->clean($antiXss->xss_clean($request->username));
            $user->email = $email;
            $user->password = app('hash')->make($request->password);
            $user->ip_adress = $request->ip();

            if ($user->save()) {
                $BaseController->register($user->id);
                $this->sendMailWelcome($user->first_name, $user->email, $user->id);
                return $this->login($request);
            }
        } catch (ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e], 422);
        }
    }

    /**
     * @param $string
     * @return array|mixed|string|string[]
     */
    public function clean($string)
    {

        $garbagearray = array('@', '#', '$', '%', '^', '&', '*');
        $garbagecount = count($garbagearray);
        for ($i = 0; $i < $garbagecount; $i++) {
            $string = str_replace($garbagearray[$i], '', $string);
        }

        return $string;
    }

    /**
     * @param $name
     * @param $email
     * @param $id
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendMailWelcome($name, $email, $id)
    {
        $client = new Client([
            'base_uri' => '',
        ]);

        $response = $client->request('GET', '/api/mail', [
            'query' => [
                't' => 'welcome',
                'name' => $name,
                'email' => $email,
                'id' => $id
            ]
        ]);

        $body = $response->getBody();
        $arr_body = json_decode($body);
        print_r($arr_body);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $antiXss = new AntiXSS();

        $credentials = $antiXss->xss_clean(request(['email', 'password']));

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'L’adresse e-mail ou le mot de passe que vous avez entré n’est pas valide'], 401);
        }

        return $this->respondWithToken($token, $request);
    }

    /**
     * @param $token
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithToken($token, $request)
    {
        return response()->json([
            'user' => $request->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expiration' => auth()->factory()->getTTL() * 60
        ]);
    }
}
