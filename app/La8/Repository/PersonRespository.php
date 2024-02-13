<?php
declare(strict_types= 1);
namespace App\La8\Repository;

use App\Models\Person;
use Illuminate\Http\Request;


class PersonRespository{

    private $personModel;

    public function __construct(Person $personModel){

        $this->personModel = $personModel;

    }
    public function listPersons(Person $personModel){

    }

    public function getPersonsListAjax(Request $request){

        $persons = $this->personModel::with('city');
        if (isset($request->search)) {
            $persons = $persons->where('firstname', 'like', "%{$request->search}%");
            $persons = $persons->orWhere('lastname', 'like', "%{$request->search}%");
            $persons = $persons->orWhere('phonenumber', 'like', "%{$request->search}%");
            $persons = $persons->orWhere('born', 'like', "%{$request->search}%");
            $persons = $persons->orWhere('sex', 'like', "%{$request->search}%");
            $persons = $persons->orWhereHas('city', function ($query) use ($request) {
                $query->where('city_name', 'like', "%{$request->search}%");
            });
        }
        $personCount = $persons->count();
        if (isset($request->order) && ($request->dir)) {
            $persons = $persons->orderBy($request->order, $request->dir);
        }
        if (isset($request->limit) && isset($request->offset)) {

            $persons = $persons->take($request->limit)->skip($request->offset);
        }
        $result = ['total' => $personCount, 'result' => $persons->get()->transform(
            function ($r) {
                return [
                    'firstname' => $r->firstname,
                    'lastname' => $r->lastname,
                    'phonenumber' => $r->phonenumber,
                    'born' => $r->born,
                    'sex' => $r->sex,
                    'city' => $r->city->city_name,
                ];
            }
        )];

        return $result;

    }
}