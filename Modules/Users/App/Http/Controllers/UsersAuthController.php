<?php

namespace Modules\Users\App\Http\Controllers;

use Modules\Users\App\Models\User;
use App\Http\Controllers\Controller;
use Modules\Users\App\Http\Requests\LoginRequest;
use Modules\Users\App\Http\Requests\RegisterRequest;
use Modules\Users\App\Http\Requests\VerifyEmailRequest;
use Modules\Users\App\Resources\UserResource;

class UsersAuthController extends Controller
{

    /**
     * @param RegisterRequest $request
     * 
     * @return object
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = is_string($request->password) ? bcrypt($request->password) : null;
        $data['account_type'] = 'user';
        $user = User::create($data);
        if ($user instanceof User) {
            $token = auth('api')->login($user);
            if (!$token = auth('api')->attempt([
                'email' => $data['email'],
                'password' => $request->password,
                'account_type' => 'user'
            ], true)) {
                return $this->respondInvaliedCredentials();
            }
            return $this->respondWithToken($token, $user, __('users::auth.register'));
        }
    }

    /**
     * @param VerifyEmailRequest $request
     * 
     * @return object
     */
    public function verifyEmail(VerifyEmailRequest $request)
    {
        $user = auth('api')->user();


        if (!$user || $user->verification_code != $request->verification_code) {
            return lynx()
                ->status(400)
                ->message(__('users::auth.Invalid_code'))
                ->response();
        }
        $user->email_verified_at = now();
        $user->verification_code  = null;
        $user->save();

        return lynx()
            ->message(__('users::auth.verified_done'))
            ->response();
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param LoginRequest $request
     * 
     * @return object
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $credentials['account_type'] = 'user';

        if (!$token = auth('api')->attempt($credentials)) {
            return $this->respondInvaliedCredentials();
        }
        $user = auth('api')->user();
        return $this->respondWithToken($token, $user);
    }

    /**
     * Get the authenticated User.
     *
     * @return object
     */
    public function me()
    {
        $user = auth('api')->user();
        return lynx()
            ->data(new UserResource($user))
            ->response();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return object
     */
    public function logout()
    {
        auth('api')->logout();
        return lynx()
            ->message(__('users::auth.loged_out'))
            ->response();
    }

    /**
     * Refresh a token.
     *@return object
     */
    public function refresh()
    {
        $user = auth('api')->user();
        return $this->respondWithToken(auth('api')->refresh(), $user);
    }

    /**
     * Get the token array structure.
     *
     * @param  mixed $token
     * @param  User|null $user
     * @param  string $message
     * @return object
     */
    protected function respondWithToken($token, $user, $message = null)
    {
        $message = $message ?? __('users::auth.login_success');
        return lynx()
            ->data([
                'token' => $token,
                'user' => new UserResource($user),
            ])
            ->message($message)
            ->response();
    }

    /**
     * @return object
     */
    protected function respondInvaliedCredentials()
    {
        return lynx()
            ->status(404)
            ->message(__('users::auth.login_failed'))
            ->response();
    }

    /**
     * @param mixed $errors
     * 
     * @return object
     */
    protected function respondValidationError($errors)
    {
        return lynx()
            ->status(422)
            ->message($errors)
            ->response();
    }
}
