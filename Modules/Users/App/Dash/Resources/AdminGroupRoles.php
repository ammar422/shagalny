<?php

namespace Modules\Users\App\Dash\Resources;

use Dash\Resource;
use Illuminate\Validation\Rule;
use Modules\Users\App\Models\AdminGroupRole;
use Modules\Users\App\Policies\Dash\AdminGroupRolesPolicy;

class AdminGroupRoles extends Resource
{

    /**
     * define Model of resource
     *
     * @var string
     */
    public static $model = AdminGroupRole::class;

    /**  
     * Policy Permission can handle  
     * (viewAny, view, create, update, delete, forceDelete, restore) methods.  
     *  
     * @var string Policy class name that can handle permissions.  
     */
    public static $policy = AdminGroupRolesPolicy::class;

    /**
     * define this resource in group to show in navigation menu
     * if you need to translate a dynamic name
     * define dash.php in /resources/views/lang/en/dash.php
     * and add this key directly users
     * @var string 
     */
    public static $group = 'users';

    /**
     * show or hide resouce In Navigation Menu true|false
     * @var bool property string
     */
    public static $displayInMenu = true;

    /**
     * change icon in navigation menu
     * you can use font awesome icons LIKE (<i class="fa fa-users"></i>)
     * @var string property string
     */
    public static $icon = '<i class="fa fa-users"></i>'; // put <i> tag or icon name

    /**
     * title static property to labels in Rows,Show,Forms
     * @var string property string
     */
    public static $title = 'resource';

    /**
     * defining column name to enable or disable search in main resource page
     * @var array< string > property array
     */
    public static $search = [
        'id',
        'resource',
    ];

    /**
     * @var array< int >
     */
    public static $lengthMenu        = [50, 10, 15, 20, 25, 50, 100];
    /**
     * @return array< string >
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
     *  if you want define relationship searches
     *  one or Multiple Relations
     * 	Example: method=> 'invoices'  => columns=>['title'],
     * @var array<mixed>
     */
    public static $searchWithRelation = [];

    /**
     * if you need to custom resource name in menu navigation
     * @return string
     */
    public static function customName()
    {
        return __('dash.admin_group_roles');
    }

    /**
     * you can define vertext in header of page like (Card,HTML,view blade)
     * @return string[]
     */
    public static function vertex()
    {
        return [];
    }

    /**
     * define fields by Helpers
     * @return mixed[]
     */
    public function fields()
    {
        return [
            // id()->make('ID', 'id'),
            belongsTo()->make(__('users::main.group_name'), 'admingroup')
                ->resource(AdminGroups::class)
                // ->rule('required', 'integer'),
                ->rule('required'),
            select()->make(__('users::main.resource'), 'resource')
                ->rule(
                    'required',
                    'string'

                )->ruleWhenCreate(
                    Rule::unique('admin_group_roles')->where(function ($q) {
                        $q->where('resource', request('resource'));
                        $q->where('admin_group_id', request('admingroup'));
                    })
                )->options(include base_path('Modules/Users/config/permissions.php')),
            checkbox()
                ->make(__('users::main.add'), 'create')
                ->column(2)
                ->trueVal('yes')
                ->falseVal('no'),
            checkbox()
                ->make(__('users::main.show'), 'show')
                ->column(2)
                ->trueVal('yes')
                ->falseVal('no'),
            checkbox()
                ->make(__('users::main.edit'), 'update')
                ->column(2)
                ->trueVal('yes')
                ->falseVal('no'),
            checkbox()
                ->make(__('users::main.delete'), 'delete')
                ->column(2)
                ->trueVal('yes')
                ->falseVal('no'),
            checkbox()
                ->make(__('users::main.force_delete'), 'force_delete')
                ->column(2)
                ->trueVal('yes')
                ->falseVal('no'),
            checkbox()
                ->make(__('users::main.restore'), 'restore')
                ->column(2)
                ->trueVal('yes')
                ->falseVal('no'),
        ];
    }

    /**
     * define the actions To Using in Resource (index,show)
     * php artisan dash:make-action ActionName
     * @return string[]
     */
    public function actions()
    {
        return [];
    }

    /**
     * define the filters To Using in Resource (index)
     * php artisan dash:make-filter FilterName
     * @return string[]
     */
    public function filters()
    {
        return [];
    }
}
