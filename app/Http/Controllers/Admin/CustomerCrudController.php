<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CustomerRequest as StoreRequest;
use App\Http\Requests\CustomerRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class CustomerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CustomerCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Customer');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/customer');
        $this->crud->setEntityNameStrings('customer', 'customers');
        $this->crud->enableExportButtons();

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => 'Tên',
                'type' => 'text'
            ],
            [
                'name' => 'age',
                'label' => 'Tuổi',
                'type' => 'text'
            ],
            [
                'name' => 'address',
                'label' => 'Địa chỉ',
                'type' => 'text'
            ],
            [
                // n-n relationship (with pivot table)
                'label' => "Tên sách", // Table column heading
                'type' => "select_multiple",
                'name' => 'books', // the method that defines the relationship in your Model
                'entity' => 'books', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => "Tên khách hàng",
                'type' => 'text',
            ],
            [
                'name' => 'age',
                'label' => "Tuổi",
                'type' => 'number',
            ],
            [
                'name' => 'address',
                'label' => "Địa chỉ",
                'type' => 'text',
            ],
        ]);

        $this->crud->addFilter([ // daterange filter
            'type' => 'date_range',
            'name' => 'from_to',
            'label'=> 'Date range'
        ],
            false,
            function($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'created_at', '>=', $dates->from);
                $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
            });

        // add asterisk for fields that are required in CustomerRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
