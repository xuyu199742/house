<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class WechatController extends Controller
{
    protected $app;

    public function __construct()
    {
        $this->app = app('wechat.mini_program');
    }

    public function login()
    {
        $code     = request()->get('code');
        $response = $this->app->auth->session($code);
        if (empty($response[ 'openid' ])) {
            return abort(500);
        }
        $openid   = $response[ 'openid' ];
        $user     = User::where('openid', $openid)->first();
        if (!$user) {
            return response()->json([
                'message' => 'user not exist',
                'openid' => $openid,
                'session_key' => $response[ 'session_key' ]
            ]);
        }
        $user->session_key = $response[ 'session_key' ];
        $user->save();

        $token = auth('api')->login($user);

        return response()->json([
            'openid'        => $openid,
            'user'          => $user,
            'session_key'   => $response[ 'session_key' ],
            'access_token'  => $token
        ]);
    }

    public function updateUserInfo()
    {
        $user          = auth('api')->user();
        $iv            = request()->get('iv');
        $session       = $user->session_key;
        $encryptData   = request()->get('encryptedData');
        $decryptedData = $this->app->encryptor->decryptData($session, $iv, $encryptData);

        $user->update([
            'name'              => $decryptedData[ 'nickName' ],
            'avatar'            => $decryptedData[ 'avatarUrl' ],
            'gender'            => $decryptedData[ 'gender' ],
            'language'          => $decryptedData[ 'language' ],
            'country'           => $decryptedData[ 'country' ],
            'province'          => $decryptedData[ 'province' ],
            'city'              => $decryptedData[ 'city' ],
            'wechat_updated_at' => Carbon::now()
        ]);

        return response()->json([
            'user' => $user,
        ]);
    }

    public function updateMobileNumber()
    {
        $user          = auth('api')->user();
        $iv            = request()->get('iv');
        $session       = $user->session_key;
        $encryptData   = request()->get('encryptedData');
        $decryptedData = $this->app->encryptor->decryptData($session, $iv, $encryptData);
        $user->update([
            'mobile'            => $decryptedData[ 'phoneNumber' ],
            'country_code'      => $decryptedData[ 'countryCode' ],
            'pure_phone_number' => $decryptedData[ 'purePhoneNumber' ],
            'mobile_updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'user' => $user,
        ]);
    }

    public function loginWithMobile()
    {
        $iv            = request()->get('iv');
        $openid        = request()->get('openid');
        $session       = request()->get('session_key');
        $encryptData   = request()->get('encryptedData');
        $decryptedData = $this->app->encryptor->decryptData($session, $iv, $encryptData);

        $user = User::where('mobile', $decryptedData[ 'phoneNumber' ])->first();
        if (!$user) {
            $user = User::create();
        }
        $user->update([
            'mobile'            => $decryptedData[ 'phoneNumber' ],
            'country_code'      => $decryptedData[ 'countryCode' ],
            'pure_phone_number' => $decryptedData[ 'purePhoneNumber' ],
            'mobile_updated_at' => Carbon::now(),
            'openid' => $openid,
            'session_key' => $session,
        ]);
        $token = auth('api')->login($user);
        return response()->json([
            'user'          => $user,
            'access_token'  => $token
        ]);
    }

    public function loginWithUsername(Request $request)
    {
        $openid        = request()->get('openid');
        $session       = request()->get('session_key');
        $credentials = request(['username', 'password']);
        $temp_user = User::where('username', $credentials['username'])->first();

        if ($temp_user) {
            if (\Hash::check($credentials['password'], $temp_user->password)) {
                $temp_user->update([
                    'openid' => $openid,
                    'session_key' => $session,
                ]);
                return response()->json([
                    'user'          => $temp_user,
                    'access_token'  => JWTAuth::fromUser($temp_user)
                ]);
            } else {
                return response()->json([
                    'message' => '用户名或密码错误',
                ], 401);
            }
        }

        $request->validate([
            'username' => 'required|min:2|max:50|unique:users|alpha_dash',
            'password' => 'required|min:2|max:50',
        ]);

        $user = User::create([
            'username'      => request('username'),
            'password'      => bcrypt(request('password')),
            'openid'        => $openid,
            'session_key'   => $session,
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'user'          => $user,
            'access_token'  => $token
        ]);
    }

    public function pay()
    {
        $payment = app('wechat.payment');
        $payment->pay([
            'body' => '测试消费',
            'out_trade_no' => '1217752501201407033233368018',
            'total_fee' => 888,
            'auth_code' => '120061098828009406',
        ]);
        $jssdk = $payment->jssdk;
        dd($config = $jssdk->appConfig(1));
    }
}
