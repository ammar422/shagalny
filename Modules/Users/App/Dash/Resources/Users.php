<?php

namespace Modules\Users\App\Dash\Resources;

use App\Dash\Metrics\Values\AllUsers;
use Dash\Resource;
use Illuminate\Validation\Rule;
use Modules\Countries\App\Dash\Resources\Countries;
use Modules\Users\App\Models\User;
use Modules\Users\App\Policies\Dash\UserPolicy;

/**
 * @property int|string|null $id
 * @property string|null $password
 */
class Users extends Resource
{

    /**
     * @var string
     */
    public static $model = User::class;
    /**
     * @var string
     */
    public static $policy = UserPolicy::class;
    /**
     * @var string
     */
    public static $group = 'users';
    /**
     * @var bool
     */
    public static $displayInMenu = true;
    /**
     * @var string
     */
    public static $icon = '<i class="fa fa-users"></i>';
    /**
     * @var string
     */
    public static $title = 'name';
    /**
     * @var array <string>
     */
    public static $search = [
        'id',
        'name',
        'email',
    ];

    /**
     * @var array <mixed>
     */
    public static $searchWithRelation = [];

    /**
     * @var array <int>
     */
    public static $lengthMenu = [50, 10, 15, 20, 25, 50, 100];


    /**
     * @return array <string>
     */
    public static function dtButtons()
    {
        return [
            'csv',
            'print',
            'pdf',
            'excel',

        ];
    }

    /**
     * @return string
     */
    public static function customName()
    {
        return __('dash.users');
    }

    /**
     * @param User $model
     * 
     * @return object
     */
    public function query($model)
    {
        return $model->where('account_type', 'user');
    }

    /**
     * @return string []
     */
    public static function vertex()
    {
        return [
            (new AllUsers)->render(),
        ];
    }

    /**
     * @return array <mixed>
     */
    public function fields()
    {
        return [
            //id()->make('ID', 'id')->showInShow(),
            text()->make(__('users::main.user_name'), 'name')
                ->ruleWhenCreate('required', 'string', 'min:4')
                ->ruleWhenUpdate('sometimes', 'nullable', 'string', 'min:4')
                ->columnWhenCreate(6)
                ->showInShow(),

            text()->make(__('users::main.first_name'), 'first_name')
                ->ruleWhenCreate('required', 'string')
                ->ruleWhenUpdate('sometimes', 'nullable', 'string')
                ->columnWhenCreate(6)
                ->showInShow(),

            text()->make(__('users::main.last_name'), 'last_name')
                ->ruleWhenCreate('required', 'string')
                ->ruleWhenUpdate('sometimes', 'nullable', 'string')
                ->columnWhenCreate(6)
                ->showInShow(),


            email()->make(__('users::main.email_address'), 'email')
                ->ruleWhenUpdate([
                    'required',
                    'email' => [Rule::unique('users')->ignore($this->id)],
                ])->ruleWhenCreate('unique:users', 'email')
                ->columnWhenCreate(6),

            select(__('users::main.account_status'), 'account_status')
                ->options([
                    'pending' => __('users::main.pending'),
                    'active' => __('users::main.active'),
                    'ban' => __('users::main.ban')
                ])
                ->column(6)
                ->f()
                ->rule('required', 'in:pending,active,ban'),

            select(__('users::main.status'), 'status')
                ->options([
                    'subscribed'    => __('users::main.subscribed'),
                    'unsubscribed'  => __('users::main.unsubscribed'),
                ])
                ->onlyshow()
                ->column(6)
                ->f(),

            password()->make(__('users::main.password'), 'password')
                ->whenStore(function () {
                    $password = request('password');
                    return is_string($password) ? bcrypt($password) : null;
                })->whenUpdate(function () {
                    $password = request('password');
                    return !empty($password) && is_string($password) ? bcrypt($password) : $this->password;
                })
                ->hideInShow()
                ->hideInIndex()
                ->columnWhenCreate(6),


            image()->make(__('users::main.photo'), 'photo')
                ->rule('nullable')
                ->path('users/{id}')
                ->column(6)
                ->accept('image/png', 'image/jpeg'),

        ];
    }

    /**
     * @return string []
     */
    public function actions()
    {
        return [];
    }

    /**
     * @return string []
     */
    public function filters()
    {
        return [];
    }
}
