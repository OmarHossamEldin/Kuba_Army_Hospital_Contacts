<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Person;
class GateController extends Controller
{
    public function Home()
    {
        $Persons = Person::select('*')->get(100);
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

        return Inertia::render('index', [
             'Persons' => $Contacts
        ]);
    }
    public function loginForm()
    {
        return Inertia::render('User/Login');
    }
    public function logOut()
    {
        Auth::logout();
        return redirect(route("HomePage"));
    }

}
