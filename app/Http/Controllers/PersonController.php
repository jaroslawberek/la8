<?php

namespace App\Http\Controllers;

//use App\Models\Persons;
use App\Models\City;
use App\Models\Person;
use App\Models\Person_type;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
//use App\Models\Person_type;
//use Illuminate\Console\Application;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePersonReq;
use App\La8\Interfaces\IPersonRepository;

class PersonController extends Controller
{
    private $personRespository;

    public function __construct(IPersonRepository $pR)
    {

        $this->personRespository = $pR;
    }

    public function index(Request $request)
    {
        $filter = $request->all();
        $people = $this->personRespository->listPersons($request);
        $people->appends($filter);
        return view('Persons.persons_list2')->with("people", $people)
            ->with('filter', $filter);


        // return view('Persons.persons_list')->with("people", $people);
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

    public function create(Request $request)
    {
        return view('Persons.person_add_form')
            ->with("cities", City::all())
            ->with("person_types", Person_type::all());
    }

    public function store(UpdatePersonReq $request)
    {
        $this->personRespository->storePerson($request);
        return redirect()
            ->route('get.persons')
            ->with('message', 'Dodano prawidłowo');
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
    public function edit($person_id)
    {
        $person = Person::find($person_id);
        return view('persons.person_update_form')->with('form_fields', $person)
            ->with('edycja', 'true')
            ->with("cities", City::all())
            ->with("person_types", Person_type::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $persons
     * @return \Illuminate\Http\Response
     */
    public function update($person_id, UpdatePersonReq $request)
    {
        $person = Person::find($person_id);
        $this->personRespository->updatePerson($request, $person);
        return redirect()
            ->route('get.persons')
            ->with('message', 'Edytowano uzytkownika prawidłowo');
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
