<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Office;
use App\Department;

class OfficeController extends Controller
{
    public function create()
    {
        $Departments = Department::select(['id','name'])->get();
        $Offices = Office::select('*')->with('department')->get(100);
        return Inertia::render('Office/create',[
            'Departments'=>$Departments,
            'Offices'=>$Offices
            ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'department' => 'required',
            'office' => 'required',
        ]);

        $office = Office::Create([
            'department_id' =>$validatedData['department'],
            'name' => $validatedData['office'],
            'user_id'=>Auth::user()->id
        ]);

        $Offices = Office::select('*')->with('department')->get(100);
        return response()->json(['status' => true, 'offices' => $Offices]);
    }

    public function delete(Office $Office){
        if(count($Office->person)>0){
            $message=['error','خطأ','لا يمكن حذف هذا القسم لوجود جهات اتصال تابعة له'];
            return back()->withFlash($message);
        }
        else{
            $Office->delete();
            $message=['success','تم','تم حذف مكان التواجد بنجاح'];
            return back()->withFlash($message);
        }
    }
    public function search(Request $request)
    {
        $validatedData= $request->validate([
            "Search" =>'required'
        ]);

        $Office=Office::select('*')->with('department')->where('name','like','%'.$validatedData['Search'].'%')->get();
        return response()->json(['status'=>true,'Office'=>$Office]);
    }

    public function edit(Office $Office){
        $OfficeInfo=[
            'id' => $Office->id,
            'name'=>$Office->name,
            'department_id'=>$Office->department->id
        ];
        $Departments = Department::select('id','name')->get();
        return Inertia::render('Office/edit',[
            'OfficeInfo'=>$OfficeInfo,
            'departments'=>$Departments,
        ]);
    }

    public function update(Request $request, Office $Office) {

        $validatedData = $request->validate([
            'department' => 'required',
            'office' => 'required',
        ]);


        $Office->name = $validatedData["office"];
        $Office->department_id = $validatedData["department"];

        $Office->save();
        return response()->json(['status' => true, 'UpdatedOffice' => $Office], 200);
    }
}
