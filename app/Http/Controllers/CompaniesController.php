<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;

class CompaniesController extends Controller
{

    
    public function index()
    {
        $companies = Companies::all();
        return view('companies.index', compact('companies'));
    }


    public function create()
    {
        //
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:companies'],
            'logo' => ['required', 'max:1024', 'file', 'image', 'mimes:jpeg,png,jpg'],
            'website' => ['required', 'string']
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        //date
        date_default_timezone_set('Asia/Jakarta');

        //time
        $time = date('His');

        $imageName = $request['email'] . $time . '.' . $request['logo']->extension();
        $request['logo']->move(public_path('logo'), $imageName);
        Companies::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'logo' => $imageName,
            'website' => $request['website'],
        ]);

        return redirect('companies')->with('add_data', 'Success!');
    }


    public function show($id)
    {
        $company = Companies::find($id);
        return response()->json($company);
    }


    public function edit($id)
    {
        $company = Companies::find($id);
        return response()->json($company);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'website' => ['required', 'string']
        ]);

        //company data
        $company = Companies::find($id);
        if ($request['email'] != $company['email']) {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:companies']
            ]);
        }

        if ($request['logo'] != null) {
            $request->validate([
                'logo' => ['required', 'max:1024', 'file', 'image', 'mimes:jpeg,png,jpg']
            ]);

            File::delete('logo/' . $company['logo']);

            //date
            date_default_timezone_set('Asia/Jakarta');

            //time
            $time = date('His');

            $imageName = $request['email'] . $time . '.' . $request['logo']->extension();
            $request['logo']->move(public_path('logo'), $imageName);

            Companies::whereId($id)->update([
                'logo' => $imageName
            ]);
        }

        Companies::whereId($id)->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'website' => $request['website']
        ]);

        return redirect('companies')->with('edit_data', 'Success!');
    }


    public function destroy($id)
    {
        $take_company = Companies::find($id);
        $logo = $take_company['logo'];
        File::delete('logo/' . $logo);
        Companies::findOrFail($id)->delete();
        return redirect('companies')->with('delete_data', 'Success!');
    }
}
