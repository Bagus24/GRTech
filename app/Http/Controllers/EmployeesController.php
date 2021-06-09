<?php

namespace App\Http\Controllers;

use App\Mail\PostMail;
use App\Models\Companies;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class EmployeesController extends Controller
{

    public function index()
    {
        $employees = Employees::all();
        $companies = Companies::all();
        
        return view('employees.index', compact('employees', 'companies'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'company' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employees'],
            'phone' => ['required', 'string']
        ]);

        Employees::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'company' => $request['company'],
            'email' => $request['email'],
            'phone' => $request['phone']
        ]);
        
        //data company
        $company = Companies::find($request['company']);
        Mail::to($company['email'])->send(new PostMail($request['first_name'], $request['last_name'], $request['email'], $request['phone']));

        return redirect('employees')->with('add_data', 'Success!');
    }


    public function show($id)
    {
        $company = Companies::all();
        return response()->json($company);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'company' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string']
        ]);

        //data employee
        $employee = Employees::find($id);

        if ($employee['email'] != $request['email']) {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:companies']
            ]);
        }

        Employees::whereId($id)->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'company' => $request['company'],
            'email' => $request['email'],
            'phone' => $request['phone']
        ]);

        return redirect('employees')->with('edit_data', 'Success!');
    }


    public function destroy($id)
    {
        Employees::findOrFail($id)->delete();
        return redirect('employees')->with('delete_data', 'Success!');
    }

    public function filter_employee(Request $request)
    {   
        $date_form = $request['date_form'];
        $date_to = $request['date_to'];
        $employees = Employees::whereBetween('created_at', [$date_form, $date_to])
        ->orwhere('email', 'like', "%" . $request['email'] . "%")
        ->orwhere('first_name', 'like', "%" . $request['first_name'] . "%")
        ->orwhere('last_name', 'like', "%" . $request['last_name'] . "%")
        ->orwhere('company', $request['company'])
        ->get();
        
        $companies = Companies::all();
        return view('employees.index', compact('employees', 'companies'));
    }
}
