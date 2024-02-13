<?php

namespace App\Http\Controllers;

//use App\Models\Persons;
use App\Http\Controllers\Controller;
use App\La8\Interfaces\IPersonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
//use App\Models\Person_type;
//use Illuminate\Console\Application;
use Illuminate\Support\Facades\App;

class PersonController extends Controller
{
private $personRespository;

    public function __construct(IPersonRepository $pR){

        $this->personRespository = $pR;        
    }
   
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

        return response($this->personRespository->getPersonsListAjax($request))
            ->setStatusCode(200)
            ->header('Content-Type', 'application/json');

    }
   
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


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
