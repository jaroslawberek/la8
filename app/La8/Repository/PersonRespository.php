<?php

declare(strict_types=1);

namespace App\La8\Repository;

use Illuminate\Support\Facades\DB;
use App\La8\Interfaces\IPersonRepository;
use App\Models\Person;
use App\Models\Person_type;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PersonRespository implements IPersonRepository
{

    private $personModel;


    public function get()
    {
    }

    public function __construct(Person $personModel)
    {

        $this->personModel = $personModel;
    }
    public function listPersons(Request $request)
    {

        $persons = DB::table('people')->select('people.id as person_id', 'firstname', 'lastname', 'born', 'sex', 'city_name', 'type_name')
            //->select(DB::raw('count(*)as ile'), 'cities.id', 'city_name as misto')
            ->join('cities', 'people.city_id', '=', 'cities.id')
            ->join('person_types', 'people.person_type_id', '=', 'person_types.id');
        //->groupBy('cities.id', 'cities.city_name')
        //->having('ile', '>', '1')
        // ->where('city_id',120);
        //->orderBy('ile', 'asc');
        // echo "<br>sql: " . $persons->toSql() . '<br>';
        $persons =  $persons->paginate($request->limit ?? 3); //pamietac o tym samo $persons->get(); wywali pozniej w dd outof memory
        return $persons;
    }

    public function getPersonsListAjax(Request $request)
    {

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
                    'id' => $r->id,
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

    public function updatePerson(Request $request, Person $person)
    {
        $person->firstname = $request->firstname ?? $person->firstname;
        $person->lastname = $request->lastname ?? $person->lastname;
        $person->phonenumber = $request->phonenumber ?? $person->phonenumber;
        $person->born = Carbon::parse($request->born) ?? $person->born;
        $person->sex = $request->sex ?? $person->sex;
        $person->pesel = $request->pesel ?? $person->pesel;
        $person->email = $request->email ?? $person->email;
        $person->city_id = $request->city_id ?? $person->city_id;
        $person->person_type_id = $request->person_type_id ?? $person->person_type_id;
        $person->save();
    }
    public function deletePerson(Person $person)
    {
    }

    public function storePerson(Request $request)
    {
        $this->personModel->firstname = $request->firstname;
        $this->personModel->lastname = $request->lastname;
        $this->personModel->phonenumber = $request->phonenumber;
        $this->personModel->born = Carbon::parse($request->born);
        $this->personModel->sex = $request->sex;
        $this->personModel->pesel = $request->pesel;
        $this->personModel->email = $request->email;
        $this->personModel->city_id = $request->city_id;
        $this->personModel->person_type_id = $request->person_type_id;
        $this->personModel->save();
    }
}
