<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Department;
use App\Office;
use App\Person;
use App\Phone;

class DepartmentController extends Controller
{
    public function create()
    {
        $Departments = Department::select('id','name')->get(100);
        return Inertia::render('Department/create',[
            'Departments'=>$Departments]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required'
        ]);
        $depart = Department::updateOrCreate(['name' => $validatedData['name']], [
            'name'=>$validatedData['name'],
            'user_id'=>Auth::user()->id
        ]);
        $office = Office::updateOrCreate(['department_id' => $depart->id, 'name' => 'لا يوجد'], [
            'name'=>'لا يوجد',
            'department_id'=>$depart->id,
            'user_id'=>Auth::user()->id
        ]);

        $Departments = Department::select('id','name')->get(100);
        return response()->json(['status' => true, 'departments' => $Departments]);
    }

    public function delete(Department $department){
        if(count($department->office)>0){
            $message=['error','خطأ','لا يمكن حذف هذا القسم لوجود اماكن تواجد تابعة له'];
            return back()->withFlash($message);
        }
        else{
            $department->delete();
            $message=['success','تم','تم حذف القسم بنجاح'];
            return back()->withFlash($message);
        }
    }
    public function search(Request $request)
    {
        $validatedData= $request->validate([
            "Search" =>'required'
        ]);

        $Department=Department::select('id', 'name')->where('name','like','%'.$validatedData['Search'].'%')->get();

        return response()->json(['status'=>true,'Department'=>$Department]);
    }

    public function get_offices($dept_name)
    {
        $department = Department::findOrFail($dept_name);
        $offices = $department->office;
        return response()->json(['status'=>true,'offices'=>$offices]);
    }

    public function offices($dept_name)
    {
        $department = Department::findOrFail($dept_name);
        $offices = $department->office;
        return response()->json(['status'=>true,'offices'=>$offices]);
    }

    public function edit(Department $Department){
        $DepartmentInfo=[
            'id' => $Department->id,
            'name'=>$Department->name,
        ];

        return Inertia::render('Department/edit',[
            'DepartmentInfo'=>$DepartmentInfo,
        ]);
    }

    public function update(Request $request, Department $Department) {

        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $Department->name = $validatedData["name"];


        $Department->save();
        return response()->json(['status' => true, 'UpdatedDepartment' => $Department], 200);
    }
}
