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
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
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
                CRUD::field('title')->type('text')->wrapper(['class' => 'form-group col-md-6']);
                CRUD::field('slug')->type('text')->attributes(['readonly' => 'readonly'])->wrapper(['class' => 'form-group col-md-6']);
                CRUD::field('short_sms_switch')->label('Send SMS Text')->type('switch')->attributes(['id' => 'short_sms_switch'])->wrapper(['class' => 'form-group col-md-6 pt-4']);
                CRUD::field('short_desc')->label('Short SMS')->type('textarea')->attributes(['id' => 'short_desc', 'readonly' => 'readonly', 'rows' => '4'])->wrapper(['class' => 'form-group col-md-6']);
                CRUD::field('content')->label('Full Content')->type('textarea')->attributes(['rows' => '5']);

                // getting user registration number from api
                $programmesData = ApiHelper::getProgrammes();
                $unitsData = ApiHelper::getUnits();
                $yearData = ApiHelper::getYearOfStudy();

                $formatted_unitAbbreviations = [];
                $formatted_programme_abbreviations = [];
                $formatted_years = [];

                if ($unitsData !== null) {
                    foreach ($unitsData['data'] as $unit) {
                        $unit_id = $unit['id'] ?? null;
                        $attributes = $unit['attributes'] ?? null;
                        $abbreviation = $attributes['abbreviation'] ?? null;

                        if ($unit_id !== null && $abbreviation !== null) {
                            $formatted_unitAbbreviations[$abbreviation] = $abbreviation;
                        }
                    }
                }

                if ($programmesData !== null) {
                    foreach ($programmesData['data'] as $programme) {
                        $programme_id = $programme['id'] ?? null;
                        $attributes = $programme['attributes'] ?? null;
                        $programme_abb = $attributes['programme_abb'] ?? null;

                        if ($programme_id !== null && $programme_abb !== null) {
                            $formatted_programme_abbreviations[$programme_abb] = $programme_abb;
                        }
                    }
                }

                if($yearData !== null){
                    foreach ($yearData['data'] as $year) {
                        $year_id = $year['id'] ?? null;
                        $attributes = $year['attributes'] ?? null;
                        $which_year = $attributes['which_year'] ?? null;

                        if($year_id !== null && $which_year !== null){
                            $formatted_years[$which_year] = $which_year;
                        }
                    }
                }
                // units
                CRUD::addField([
                    'label'     => "Choose Unit",
                    'type'      => 'select_from_array',
                    'name'      => 'abbreviation',
                    'options'   => $formatted_unitAbbreviations,
                    'attributes'=> ['id' => 'abbreviation'],
                ]);

                // prgm
                CRUD::addField([
                    'label'      => "Choose Programme",
                    'type'       => 'select_from_array',
                    'name'       => 'programme_abb',
                    'options'    => $formatted_programme_abbreviations,
                    'attributes' => ['id' => 'programme_abb'],
                ]);

                // year of study
                CRUD::addField([
                    'label'      => "Choose Year",
                    'type'       => 'select_from_array',
                    'name'       => 'which_year',
                    'options'    => $formatted_years,
                    'attributes' => ['id' => 'which_year'],
                ]);


                // send sms tu user who belong to a ceartain unit
                // $selectedProgrammeId = request();
                $selectedProgrammeId = "FST";
                $userData = ApiHelper::getUsers();
                $user_programme_ids = [];

                foreach ($userData as $entry) {
                    $Programme_id = $entry['attributes']['Programme_id'] ?? null;

                    if ($Programme_id !== null) {
                        $user_programme_ids[] = $Programme_id;
                    }
                }

                if (in_array($selectedProgrammeId, $user_programme_ids, true)) {
                    // Send SMS to users who belong to the selected programme_id
                    foreach ($userData as $entry) {
                        $Programme_id = $entry['attributes']['Programme_id'] ?? null;

                        if ($Programme_id === $selectedProgrammeId) {

                            $smsToBeSent = request();
                            // send sms to students
                            $response = Http::get('http://localhost:1337/api/users');
                            if ($response->successful()) {
                                $data = $response->json();

                                $phone_numbers = [];

                                foreach ($data as $entry) {
                                    $phone_number = $entry['phone_number'] ?? null;

                                    if ($phone_number !== null) {
                                        $phone_numbers[] = $phone_number;
                                    }
                                }
                                if (!empty($phone_numbers)) {
                                    //…. sms url Api
                                    $Url ='https://apisms.beem.africa/v1/send';

                                    $api_key= '643449c5b429a174';
                                    $secret_key = 'NWUxODBhMjkzYjg3NDc0YWIwNzFhZWE4ZGI1NzFhNzA5ZjIwM2E4NzJjYTcxM2QzMzJjOGE5ZDQyODhjMzg3ZA==';


                                    $randomInt = random_int(10001, 100000);
                                    $id = Utils::randomId($randomInt);

                                    // Request payload
                                    $postData = array(
                                        'source_addr' => 'INFO',
                                        'encoding' => 0,
                                        'schedule_time' => '',
                                        'message' => $smsToBeSent->title,
                                        'recipients' => array()
                                    );

                                    foreach ($phone_numbers as $phone_number){
                                        // Destination phone number

                                        $dest_addr = '255' . $phone_number;
                                        $postData['recipients'][] = array('recipient_id' => $id, 'dest_addr' => $dest_addr);
                                    }

                                    // Setup cURL
                                    $ch = curl_init($Url);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                    curl_setopt($ch, CURLOPT_POST, TRUE);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                        'Authorization: Basic ' . base64_encode($api_key . ':' . $secret_key),
                                        'Content-Type: application/json'
                                    ));
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

                                    // Send the request
                                    $response = curl_exec($ch);

                                    // Check for errors
                                    if ($response === FALSE) {
                                        die(curl_error($ch));
                                    }

                                    // Close cURL
                                    curl_close($ch);
                                }
                            }
                            // sendSmsToUser($entry['attributes']['phone_number'], $smsToBeSent);
                        }
                    }
                    // dd($user_programme_ids);
                }


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
