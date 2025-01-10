<?php

namespace Modules\Users\App\Dash\Resources;

use App\Dash\Metrics\Values\AllAdminGroups;
use Dash\Resource;
use Modules\Users\App\Models\AdminGroup;
use Modules\Users\App\Policies\Dash\AdminGroupPolicy;

class AdminGroups extends Resource
{

    /**
     * define Model of resource
     * @var string
     */
    public static $model = AdminGroup::class;

    /**
     * Policy Permission can handel
     * (viewAny,view,create,update,delete,forceDelete,restore) methods
     *
     * @var string
     */
    public static $policy = AdminGroupPolicy::class;

    /**
     * define this resource in group to show in navigation menu
     * if you need to translate a dynamic name
     * define dash.php in /resources/views/lang/en/dash.php
     * and add this key directly users
     *  @var string
     */
    public static $group = 'users';

    /**
     * show or hide resouce In Navigation Menu true|false
     *  @var bool
     */
    public static $displayInMenu = true;

    /**
     * change icon in navigation menu
     * you can use font awesome icons LIKE (<i class="fa fa-users"></i>)
     *  @var string
     */
    public static $icon = '<i class="fa fa-users"></i>'; // put <i> tag or icon name

    /**
     * title static property to labels in Rows,Show,Forms
     *  @var string
     */
    public static $title = 'name';

    /**
     * defining column name to enable or disable search in main resource page
     *  @var array< mixed >
     */
    public static $search = [
        'id',
        'name',
    ];

    /**
     * defining column name to enable or disable search in main resource page
     *  @var array< mixed >
     */
    public static $lengthMenu        = [50, 10, 15, 20, 25, 50, 100];


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
     *  if you want define relationship searches
     *  one or Multiple Relations
     * 	Example: method=> 'invoices'  => columns=>['title'],
     * @var array <mixed>
     */
    public static $searchWithRelation = [];

    /**
     * if you need to custom resource name in menu navigation
     * @return string
     */
    public static function customName()
    {
        return trans('dash.admin_groups');
    }

    /**
     * you can define vertext in header of page like (Card,HTML,view blade)
     * @return string[]
     */
    public static function vertex()
    {
        return [
            (new AllAdminGroups)->render(),
        ];
    }

    /**
     * define fields by Helpers
     * @return array <mixed>
     */
    public function fields()
    {

        $fields = [
            text()->make(__('users::main.group_name'), 'name')
                ->column(12)
                ->rule('required'),
            hasMany()->make(__('users::main.roles'), 'roles', AdminGroupRoles::class),
        ];

        return $fields;
    }

    /**
     * define the actions To Using in Resource (index,show)
     * php artisan dash:make-action ActionName
     * @return string []
     */
    public function actions()
    {
        return [];
    }

    /**
     * define the filters To Using in Resource (index)
     * php artisan dash:make-filter FilterName
     * @return string []
     */
    public function filters()
    {
        return [];
    }
}
