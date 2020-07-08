<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Department;
use App\Office;
use App\Person;
use App\Phone;

class PersonController extends Controller
{
    public function create()
    {

        $Departments = Department::select(['id','name'])->get();
        return Inertia::render('Person/create',[
            'Departments'=>$Departments
            ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'office' => 'required',
            'persons' => 'required',
        ]);
        $office = Office::findOrFail($validatedData['office']);
        foreach ($validatedData['persons'] as $result) {
            foreach($result['numbers'] as  $number){
                if( $result['name'] == '' || $number == '' ){
                    continue;
                }
                $person = Person::updateOrCreate([
                        'name' => $result['name'],
                        'office_id' => $office->id,
                    ],
                    [
                        'name' => $result['name'],
                        'office_id' => $office->id,
                        'user_id'=>Auth::user()->id
                    ]
                );
                Phone::updateOrCreate(
                    ['person_id'=>$person->id,
                    'number'=>$number,
                    'user_id'=>Auth::user()->id
                    ]
                );
            }
        }
        return response()->json(['status' => true]);
    }
    public function index(){
        $Persons = Person::select('*')->with('phones')->with('office')->get(100);
        $Contacts=[];
        foreach($Persons as $Person){
            $numbers='';
            foreach($Person->phones as $phone){
                $numbers.=$phone->number.' ';
            }
            $numbers=substr(str_replace(' ', ' - ', $numbers), 0, -2);
            array_push($Contacts,
            ['id'=>$Person->id,
            'name'=>$Person->name,
            'department'=>$Person->office->department->name,
            'office'=>$Person->office->name,
            'numbers'=>$numbers
            ]);
        }
        return Inertia::render('Person/index',[
            'Persons'=>$Contacts
            ]);
    }
    public function delete(Person $Person){
        foreach($Person->phones as $phone){
            $phone->delete();
        }
        $Person->delete();
        return back();
    }
    public function searchDelete(Request $request)
    {
        $validatedData= $request->validate([
            "Search" =>'required'
        ]);
        $Persons = Person::where('name', 'like', '%' . $validatedData['Search'] . '%')->get();
        $Contacts=[];
        foreach($Persons as $Person){
            $numbers='';
            foreach($Person->phones as $phone){
                $numbers.=$phone->number.' ';
            }
            $numbers=substr(str_replace(' ', ' - ', $numbers), 0, -2);
            array_push($Contacts,
            ['id' => $Person->id,
            'name' => $Person->name,
            'department' => $Person->office->department->name,
            'office' => $Person->office->name,
            'numbers' => $numbers
            ]);
        }
        return response()->json(['status'=>true,'data'=>$Contacts]);

    }
    public function checkPhone($number){
        $phones = Phone::where('number', $number)->first();
        if($phones){
            $unique = 0;
        }
        else{
            $unique = 1;
        }
        return response()->json(['status' => true, 'unique' => $unique]);
    }

    public function edit(Person $Person){
        $PersonInfo=[
            'id' => $Person->id,
            'name'=>$Person->name,
            'office'=>$Person->office->id,
            'department'=>$Person->office->department->id,
            'phones'=>$Person->phones->pluck('number')
        ];
        $Departments = Department::select('id','name')->get();
        return Inertia::render('Person/edit',[
            'PersonInfo'=>$PersonInfo,
            'departments'=>$Departments,
        ]);
    }

    /*
    search in all tables in the database with the same keyword
    */
    public function search($keyword)
    {
        // search in departments table
        $departments = Department::where('name', 'like', '%' . $keyword . '%')->get();
        $resultDep = [];
        if ($departments) {
            foreach ($departments as $dep) {
                foreach ($dep->office as $office) {
                    foreach ($office->person as $person) {

                        $numbers='';
                        foreach($person->phones as $phone){
                            $numbers.=$phone->number.' ';
                        }
                        $numbers=substr(str_replace(' ', ' - ', $numbers), 0, -2);
                        $data = array(
                            'id' => $person->id,
                            'name' => $person->name,
                            'department' => $dep->name,
                            'office' => $office->name,
                            'numbers' => $numbers
                        );
                        array_push($resultDep, $data);
                    }
                }
            }
        }
        // search in office table
        $office = Office::where('name', 'like', '%' . $keyword . '%')->get();
        $resultOffice = [];
        if ($office) {
            foreach ($office as $off) {
                foreach ($off->person as $person) {
                    $numbers='';
                    foreach($person->phones as $phone){
                        $numbers.=$phone->number.' ';
                    }
                    $numbers=substr(str_replace(' ', ' - ', $numbers), 0, -2);
                    $data = array(
                        'id' => $person->id,
                        'name' => $person->name,
                        'department' => $off->department->name,
                        'office' => $off->name,
                        'numbers' => $numbers
                    );
                    array_push($resultOffice, $data);
                }
            }
        }
        // search in persons table
        $persons = Person::where('name', 'like', '%' . $keyword . '%')->get();
        $resultPerson = [];
        if ($persons) {
            foreach ($persons as $person) {
                $numbers='';
                foreach($person->phones as $phone){
                    $numbers.=$phone->number.' ';
                }
                $numbers=substr(str_replace(' ', ' - ', $numbers), 0, -2);
                $data = array(
                    'id' => $person->id,
                    'name' => $person->name,
                    'department' => $person->office->department->name,
                    'office' => $person->office->name,
                    'numbers' => $numbers
                );
                array_push($resultPerson, $data);
            }
        }

        $finalResult = array_merge($resultDep, $resultOffice, $resultPerson);

        // remove duplicates
        $data = remove_duplicates($finalResult);

        return response()->json(['status' => true, 'result' => array_values($data)], 200);
    }

    public function update(Request $request, Person $Person) {
        
        $validatedData = $request->validate([
            'office' => 'required',
            'PersonInfo' => 'required',
        ]);
        
        $Person->name = $validatedData["PersonInfo"][0]["name"];
        
        $Person->office_id = $validatedData["office"];

        foreach ($Person->phones as $key => $number) {
           $number->delete();
        }

        foreach ($validatedData["PersonInfo"][0]["numbers"] as $key => $number) {
            Phone::create(
                ['person_id'=>$Person->id,
                'number'=>$number,
                'user_id'=>Auth::user()->id
                ]
            );
        }
        $Person->save();
        return response()->json(['status' => true, 'UpdatedPerson' => $Person], 200);
    }

}
