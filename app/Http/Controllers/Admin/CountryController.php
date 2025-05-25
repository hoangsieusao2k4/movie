<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;
class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::latest()->paginate(10);
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        $path = storage_path('app/countries.json');
        $jsonString = file_get_contents($path);
        $countries = json_decode($jsonString, true);
        return view('admin.countries.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:countries,name']);
        Country::create($request->only('name'));

        return redirect()->route('admin.countries.index')->with('success', 'Thêm quốc gia thành công');
    }
    public function show(Country $country)
    {



        return view('admin.countries.show', compact('country'));
    }

    public function edit(Country $country)
    {


        $path = storage_path('app/countries.json');
        $jsonString = file_get_contents($path);
        $countries = json_decode($jsonString, true);

        return view('admin.countries.edit', compact('country', 'countries'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|unique:countries,name,' . $country->id,
        ]);
        $country->update($request->only('name'));

        return redirect()->route('admin.countries.index')->with('success', 'Cập nhật quốc gia thành công');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->back()->with('success', 'Xoá quốc gia thành công');
    }
}
