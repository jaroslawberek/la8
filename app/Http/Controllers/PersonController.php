<?php

namespace App\Http\Controllers;

use App\Models\Persons;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\Person_type;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\App;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$person_types = Person_type::with("Person")->get();
       // dump($person_types);
        // $persons = Person::where("id", 1)->get();
        // dump($persons);
        // $persons = DB::table('persons')
        //     ->select(DB::raw('count(*)as ile'), 'cities.id', 'city_name as misto')
        //     ->join('cities', 'persons.cities_id', '=', 'cities.id')
        //     ->join('person_types', 'persons.person_types_id', '=', 'person_types.id')
        //     ->groupBy('cities.id', 'cities.city_name')
        //     ->having('ile', '>', '1')
        //     //->where('cities_id',12)
        //     ->orderBy('ile', 'asc');
        // echo "<br>sql: " . $persons->toSql() . '<br>';
        // $persons =  $persons->get(); //pamietac o tym samo $persons->get(); wywali pozniej w dd outof memory
        // // echo "Count: " . $persons->count();
        // echo "min: " . $persons->min('id');
        // echo "max: " . $persons->max('id');
        // echo "avg: " . $persons->avg('id');


        // echo "<pre>";
        //  dd(print_r($persons));
        // dd($persons->toArray());


         return view('Persons.persons_list');
    }

    public function relation()
    {
        $belowTo = DB::select("SELECT 
                            COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
                            FROM
                            INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                              WHERE
                            CONSTRAINT_NAME <> 'PRIMARY'
                                AND TABLE_SCHEMA = 'db_test'
                                AND TABLE_NAME = 'people'");
        // dump($belowTo);

        foreach ($belowTo as $row) {
            dump("public function {$row->REFERENCED_TABLE_NAME}()
            {
                //table: {$row->REFERENCED_TABLE_NAME}
                //fk: {$row->COLUMN_NAME} w naszej tabeli Persons
                //pk: id
                return \$this->belongsTo({$row->REFERENCED_TABLE_NAME}::class, '{$row->COLUMN_NAME}', '{$row->REFERENCED_COLUMN_NAME}');
            }");
        }
    }

    public function ajax_get_persons_list(Request $request)
    {
        $url = $request->url();
        $persons = Person::with('city');
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
        //dd($persons->get());
        //dd($persons->toSql());
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
        //sleep(1);
        //  dd($result);
        return response($result)
            ->setStatusCode(200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Persons  $persons
     * @return \Illuminate\Http\Response
     */
    public function show(Person $persons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $persons
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $persons)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $persons
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $persons)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $persons
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $persons)
    {
        //
    }
}
