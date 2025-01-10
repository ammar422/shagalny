<?php

namespace Modules\Codes\App\Dash\Resources;

use Dash\Resource;
use Modules\Codes\models\Code;

class Codes extends Resource
{

	/**
	 * define Model of resource
	 * @var string $model
	 */
	public static $model = Code::class;

	/**
	 * Policy Permission can handel
	 * (viewAny,view,create,update,delete,forceDelete,restore) methods
	 * @var string $policy
	 */
	//public static $policy = UserPolicy::class;

	/**
	 * define this resource in group to show in navigation menu
	 * if you need to translate a dynamic name
	 * define dash.php in /resources/views/lang/en/dash.php
	 * and add this key directly users
	 * @var string $group
	 */
	public static $group = 'codes';

	/**
	 * show or hide resouce In Navigation Menu true|false
	 * @var bool $displayInMenu
	 */
	public static $displayInMenu = true;

	/**
	 * change icon in navigation menu
	 * you can use font awesome icons LIKE (<i class="fa fa-users"></i>)
	 * @var string $icon
	 */
	public static $icon = '<i class="fab fa-cc-amazon-pay"></i>'; // put <i> tag or icon name

	/**
	 * title static property to labels in Rows,Show,Forms
	 * @var string $title
	 */
	public static $title = 'code';

	/**
	 * defining column name to enable or disable search in main resource page
	 * @var array<string> $search
	 */
	public static $search = [
		'code',
		'duration',
		'expire_at',
	];

	/**
	 *  if you want define relationship searches
	 *  one or Multiple Relations
	 * 	Example: method=> 'invoices'  => columns=>['title'],
	 * @var array<string> $searchWithRelation
	 */
	public static $searchWithRelation = [];

	/**
	 * if you need to custom resource name in menu navigation
	 * @return string
	 */
	public static function customName()
	{
		return __('dash.codes');
	}

	/**
	 * you can define vertext in header of page like (Card,HTML,view blade)
	 * @return array<string>
	 */
	public static function vertex()
	{
		return [];
	}

	/**
	 * define fields by Helpers
	 * @return array<string>
	 */
	public function fields()
	{
		return [
			text(__('dash.code'), 'code')
				->onlyShow()
				->column(4),


			select(__('dash.duration'), 'duration')
				->options([
					'daily' 	=> __('dash.daily'),
					'weekly' 	=> __('dash.weekly'),
					'monthly' 	=> __('dash.monthly'),
					'yearly' 	=> __('dash.yearly'),
					'life_time' => __('dash.life_time'),
				])
				->rule('required', 'in:daily , weekly , monthly , yearly , life_time')
				->column(4)
				->f(true, ['column' => 3]),

			fullDateTime(__('dash.expire_at'), 'expire_at')
				->onlyShow()
				->column(6)
				->rule('after:now')
				->inline(false)
				->altInput(false)
				->format('Y-m-d h:i:s')
				->enableTime(true)
				->time_24hr(false)
				->maxDate(30)
				->f(),

			select(__('dash.status'), 'status')
				->options([
					'pending'           => __('dash.pending'),
					'ended'             => __('dash.ended'),
					'active'          	=> __('dash.active'),
				])
				->column(4)
				->f()
				->rule('required', 'in:pending,ended,active'),


		];
	}

	/**
	 * define the actions To Using in Resource (index,show)
	 * php artisan dash:make-action ActionName
	 * @return array<string>
	 */
	public function actions()
	{
		return [];
	}

	/**
	 * define the filters To Using in Resource (index)
	 * php artisan dash:make-filter FilterName
	 * @return array<string>
	 */
	public function filters()
	{
		return [];
	}
}
