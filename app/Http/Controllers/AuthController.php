<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Controllers\ResponseHandler;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use App\Model\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RestResource;
use App\Services\DatabaseGW;
use App\Model\LoginHistory;

class AuthController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['logIn', 'logOut', 'changePassword']]);
    }

    public function logIn(Request $request) {
        $credentials = [];
        $credentials['username'] = $request['username'];
        $password = $request['password'];
        $credentials['password'] =  md5($password);
        $dataLogin = [];
        $dataLogin['id'] = DatabaseGW::generateId('log');
        $dataLogin['source_ip'] = $request->ip();
        $dataLogin['login_url'] = $request->header('host');
        $dataLogin['login_time'] = '';//it will auto set when create
        $dataLogin['location'] = 'UNKNOWN';
        $dataLogin['platform'] = $request->header('User-Agent');
        $dataLogin['username'] = $credentials['username'];
        $dataLogin['users_id'] = $dataLogin['id'];
        $dataLogin['is_success'] = 0;

        //we not just check correct username and password, we also check if user is active
        $listUser = User::where($credentials);//get user that match username
        //get user not compare password because laravel always change encrypt value

        //everytime it called method
        if ($listUser->count() == 1) {
            $user_account = $listUser->first();
            if($user_account != null){
//             if (Hash::check(md5($password), $user_account['password']) ) {
                //if($user_account['password'])   {
                // Password success!
                
                // if ($user_account['is_active'] == 0) {
                //     $dataLogin['reason'] = "User is deactivated!";
                //     LoginHistory::create($dataLogin);
                //     throw new CustomException("User is deactivated! Contact admin to activate him/her back.", 404);
                // }

                if ($user_account['is_locked'] == 1) {
                    $lockReason = "User is locked! " . $user_account["lock_reason"];
                    $dataLogin['reason'] = $lockReason;
                    LoginHistory::create($dataLogin);
                    throw new CustomException($lockReason, 404);
                }

                $dataToken["api_token"] = '$rds'. Hash::make($password);
                $result = $listUser->update($dataToken);

                $user_account["api_token"] = $dataToken["api_token"];

                $dataLogin['is_success'] = 1;
                LoginHistory::create($dataLogin);

                return new RestResource($user_account);
            } else {
                // Password failed :(
                $dataLogin['reason'] = "Invalid Password!";
                LoginHistory::create($dataLogin);
                throw new CustomException("Invalid Password!", 404);
            }


        }else {
            throw new CustomException("Invalid Username!", 404);
        }
    }

    public function logOut(Request $request)
    {
        if(!isset(Auth::user()->api_token)){
            throw new CustomException("Unauthenticated.", 404);
        }
        $credentials = [];
        $credentials['api_token'] = Auth::user()->api_token;

        $checkUserUser = User::where($credentials);

        $user = $checkUserUser->first();

        if (isset($user)) {
            $dataToken["api_token"] = '';
            $result = $user->update($dataToken);
            return response()->json(["success" => true], 200);
        }
    }

    public function sendPasswordResetLink(Request $request)
    {
        return $this->sendResetLinkEmail($request);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json([
            'message' => 'Password reset email sent.',
            'data' => $response
        ]);
    }
    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => 'Email could not be sent to this email address.']);
    }
}
