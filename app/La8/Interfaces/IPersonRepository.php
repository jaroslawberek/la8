<?php
namespace App\La8\Interfaces;

use App\Models\Person;
use Illuminate\Http\Request;

interface IPersonRepository{

    public function get();

    public function updatePerson(Request $request, Person $person);
    public function deletePerson(Person $person);

    public function storePerson(Request $request);
    public function listPersons(Person $personModel);

    public function getPersonsListAjax(Request $request);
    

}