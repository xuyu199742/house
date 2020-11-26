<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    use CrudTrait;
    protected $table = 'system_logs';

    protected $guarded = [''];

    /**
     * @param $request
     * @param $response
     */
    public static function record($request, $response)
    {
        if (backpack_auth()->check()) {
            $authed  = 1;
            $user_id = backpack_auth()->user()->id;
        } else {
            $authed  = 0;
            $user_id = 0;
        }

        $request_content = (string) $request;

        if ($request->has('password')) {
            $request->merge(['password'=>'******']);
            $request_content = preg_replace('/password=[^&]*/', 'password=******', $request_content);
        }

        if ($request->has('password_confirmation')) {
            $request->merge(['password_confirmation'=>'******']);
            $request_content = preg_replace('/password_confirmation=[^&]*/', 'password_confirmation=******', $request_content);
        }

        $status = $response->getStatusCode();

        static::create([
            'url'        => $request->url(),
            'method'     => $request->method(),
            'request'    => $request_content,
            'response'   => $response,
            'auth'       => $authed,
            'user_id'    => $user_id,
            'ip'         => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'status'     => $status,
            'data'       => json_encode($request->all(), JSON_UNESCAPED_UNICODE),
        ]);
    }
}
