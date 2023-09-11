<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChannelRequest;
use App\Http\Controllers\Admin\UserCrudController;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\ApiHelper;
use Illuminate\Support\Str;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ChannelCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ChannelCrudController extends UserCrudController
{
	use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

	/**
	 * Configure the CrudPanel object. Apply settings to all operations.
	 * 
	 * @return void
	 */
	public function setup()
	{
		CRUD::setModel(\App\Models\Channel::class);
		CRUD::setRoute(config('backpack.base.route_prefix') . '/channel');
		CRUD::setEntityNameStrings('channel', 'channels');
	}

	/**
	 * Define what happens when the List operation is loaded.
	 * 
	 * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
	 * @return void
	 */
	public function setupListOperation()
	{
		// CRUD::setFromDb(); // set columns from db columns.

		$this->crud->addColumns([
			[
				'name' => 'profile_image',
				'type' => 'image'
			],
			[
				'name' => 'name',
			],
			[
				'name' => 'email',
			],
			[
				'name' => 'desc',
			],
			[
				'name' => 'recipient_units',
				'type' => 'select_from_array'
			],
			[
				'name' => 'recipient_programmes',
				'type' => 'select_from_array'
			],
		]);


		/**
		 * Columns can be defined using the fluent syntax:
		 * - CRUD::column('price')->type('number');
		 */
	}

	/**
	 * Define what happens when the Create operation is loaded.
	 * 
	 * @see https://backpackforlaravel.com/docs/crud-operation-create
	 * @return void
	 */
	public function setupCreateOperation()
	{
		CRUD::setValidation(ChannelRequest::class);
		// CRUD::setFromDb(); // set fields from db columns.

		// getting Units from api
		$units = ApiHelper::getUnits();

		CRUD::addField([
			'name' => 'name'
		]);
		
		CRUD::addField([
			'name' => 'email'
		]);

		// units
		CRUD::addField([
			'label'     => "Choose Recipient Unit(s)",
			'type'      => 'select_multiple_from_array',
			'name'      => 'recipient_units',
			'options'   => $units,
			'attributes'=> ['id' => 'units_field'],
			'allows_multiple' => true,
			'allows_null' => false,
		]);
		
		// programmes
		CRUD::addField([
			'label'      => "Choose Recipient Programme(s)",
			'type'       => 'select_multiple_from_array',
			'name'       => 'recipient_programmes',
			// 'options'    => $programmes,
			'options'    => [],
			'attributes' => ['id' => 'programme_field'],
			'allows_multiple' => true,
			'allows_null' => false,
		]);
		CRUD::addField([
			'name'  => 'password',
			'label' => trans('backpack::permissionmanager.password'),
			'type'  => 'hidden',
			'value' => Str::random(16),
		]);

		// $this->addUserFields();
		// CRUD::removeField('desc');
		// CRUD::removeField('profile_image');
		// CRUD::removeField('cover_image');

		

		/**
		 * Fields can be defined using the fluent syntax:
		 * - CRUD::field('price')->type('number');
		 */
	}

	/**
	 * Define what happens when the Update operation is loaded.
	 * 
	 * @see https://backpackforlaravel.com/docs/crud-operation-update
	 * @return void
	 */
	public function setupUpdateOperation()
	{
		$this->setupCreateOperation();
		$this->addUserFields();
	}

}
