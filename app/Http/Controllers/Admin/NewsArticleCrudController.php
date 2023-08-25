<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NewsArticleRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Http;
use App\Exceptions\InvalidOrderException;
use App\ApiHelper;
use Illuminate\Support\Str;
use App\Utils;

/**
 * Class NewsArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NewsArticleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\NewsArticle::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/news-article');
        CRUD::setEntityNameStrings('news article', 'news articles');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // set columns from db columns.
            // CRUD::column('image')->type('image');
            CRUD::column('title');
            CRUD::column('content');
            CRUD::column('recipient');

            if (backpack_user()->can((config('permission.demo')))) {
                $this->crud->addClause('where', 'publisher', 'demo');
            } elseif (backpack_user()->can((config('permission.profile')))) {
                $this->crud->addClause('where', 'publisher', backpack_user()->email);
            } elseif (backpack_user()->can((config('permission.admin')))) {
                $this->crud->addClause('where', 'publisher', backpack_user()->email);
            }
            // Add where clause to only show news_articles of the current user


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
    protected function setupCreateOperation()
    {
        // CRUD::setValidation(NewsArticleRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.
        
        CRUD::setValidation(NewsArticleRequest::class);
            if (!backpack_user()->can((config('permission.profile'))) && !backpack_user()->can((config('permission.demo')))) {
                return abort(403);
            }
            else {
                // getting Units from api
                $units = ApiHelper::getUnits();
                $programmes = ApiHelper::getProgrammes();

                CRUD::field('title')->type('text')->wrapper(['class' => 'form-group col-md-6']);
                CRUD::field('slug')->type('text')->attributes(['disabled' => 'disabled'])->wrapper(['class' => 'form-group col-md-6']);
                CRUD::field('short_sms_switch')->label('Send SMS Text')->type('switch')->attributes(['id' => 'short_sms_switch'])->wrapper(['class' => 'form-group col-md-6 pt-4']);
                CRUD::field('short_desc')->label('Short SMS')->type('textarea')->attributes(['id' => 'short_desc_field', 'disabled' => 'disabled', 'rows' => '4'])->wrapper(['class' => 'form-group col-md-6']);
                CRUD::field('content')->label('Full Content')->type('textarea')->attributes(['rows' => '5']);

                // dd($units[0]);

                // units
                CRUD::addField([
                    'label'     => "Choose Recipient Unit(s)",
                    'type'      => 'select_multiple_from_array',
                    'name'      => 'units',
                    'options'   => $units,
                    'attributes'=> ['id' => 'units_field'],
                    'allows_multiple' => true,
                    'allows_null' => false,
                ]);
                
                // programmes
                CRUD::addField([
                    'label'      => "Choose Recipient Programme(s)",
                    'type'       => 'select_multiple_from_array',
                    'name'       => 'programmes',
                    // 'options'    => $programmes,
                    'options'    => [],
                    'attributes' => ['id' => 'programme_field'],
                    'allows_multiple' => true,
                    'allows_null' => false,
                ]);

                if (backpack_user()->can((config('permission.demo')))) {
                    CRUD::field('publisher')->type('hidden')->value('demo');
                }
                else {

                    CRUD::field('publisher')->type('hidden')->value(backpack_user()->email);

                }

            }
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
    protected function setupUpdateOperation()
        {
            $this->setupCreateOperation();
            CRUD::removeFields(
                [
                    'name'  => 'short_sms_switch',
                    'type'  => 'switch',
                ]
            );
            CRUD::removeFields(
                [
                    'name'  => 'short_desc',
                    'type'  => 'textarea',
                ]
            );
        }
}
