<?php

$this->get('company/store', 'Tenant\CompanyController@store')->name('company.store');

$this->get('/', function () {
    return 'tenant';
});
