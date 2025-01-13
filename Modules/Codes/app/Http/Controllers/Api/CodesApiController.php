<?php

namespace Modules\Codes\App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Codes\models\Code;
use Illuminate\Support\Facades\Validator;
use Modules\Codes\Policies\CodesApiPolicy;
use Modules\Users\App\Models\User;

class CodesApiController extends \Lynx\Base\Api
{
    protected $entity               = Code::class;
    protected $policy               = CodesApiPolicy::class;
    protected $guard                = 'api';
    protected $spatieQueryBuilder   = true;


    /**
     * can handel custom query when retrive data on index,indexGuest
     * @param $entity model
     * @return query by Model , Entity
     */
    public function query($entity): Object
    {
        return $entity;
    }


    public function charge(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'exists:codes,code']
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return lynx()
                ->data([
                    'errors' => $errors,
                    'status' => false,
                ])
                ->status(422)
                ->response();
        }
        $code = Code::where('code', $request->code)->first();
        if ($code->expire_at <= now()) {
            return lynx()
                ->message('The code has expired')
                ->status(400)
                ->response();
        }

        if ($code->status == 'suspended' || $code->status == 'ended') {
            return lynx()
                ->message('This code is suspended or expired, contact the administration')
                ->status(400)
                ->response();
        }
        $code->status = 'active';
        $code->save();
        $user = auth('api')->user();
        $user->code = $code->code;
        $user->status = 'subscribed';
        $user->save();
        return lynx()
            ->data('Subscription expiration date is ::> '  . Carbon::parse($code->expire_at)->format('Y-m-d'))
            ->message('The process was completed successfully and the service was activated')
            ->response();
    }

    public function checkSubscription(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'exists:users,email']
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return lynx()
                ->data([
                    'errors' => $errors,
                    'status' => false,
                ])
                ->status(422)
                ->response();
        }
        $user = User::where('email', $request->email)->first();
        $code = Code::where('code', $user->code)->first();
        $expire_at = $code->expire_at;

        if ($user->status == 'subscribed') {
            return lynx()->data([
                'email'         => $user->email,
                'status'        => $user->status,
                'code'          => $user->code,
                'expire_date'   => $expire_at
            ])
                ->message('this user is subscribed')->response();
        }
        if ($user->status == 'unsubscribed') {
            return lynx()->data([
                'email'         => $user->email,
                'status'        => $user->status,
            ])
                ->message('this user is not subscribed')->response();
        }
    }
}
