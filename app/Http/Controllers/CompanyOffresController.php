<?php

namespace App\Http\Controllers;

use App\CompanyOffres;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyOffresController extends Controller
{
   
    public function index(Request $request)
    {
       $data = CompanyOffres::simplePaginate(15);
        return view('company_offers.list_company_offers',compact('data'));
    }


    /**
     * driver registration form.
     *
     * @param mixed $request
     * @author Nived
     * @return bool
     */
    public function create(Request $request)
    {
    
        return view('company_offers.create_company_offers');
    }

    public function edit($id)
    {
      
        $company_offers_Details = CompanyOffres::find($id);
        return view('company_offers.edit_company_offers', ["company_offers_Details" => $company_offers_Details]);
    }


    /**
     * Prepares a driver registration for storing.
     *
     * @param mixed $request
     * @author Nived
     * @return bool
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required",
            "offres" => "required",
           
        ], [

            // 'profileImage.required' => 'Please choose profile image',
            'name.required' => 'Please upload name Company',
            'offres.required' => 'Please upload offres Company'
        ]);

       

        CompanyOffres::create([
            'name' => $request->name,
            "offres" => $request->offres,
        ]);
        return redirect()->route('companyOffres.index')->with('success', 'Company Offres added successfully.');
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => "required",
            "offres" => "required",
           
        ], [
            'name.required' => 'Please upload name Company',
            'offres.required' => 'Please upload offres Company'
        ]);


        CompanyOffres::findorfail($request->id)->update([
            'name' => $request->name,
            "offres" => $request->offres,
        ]);
               return redirect()->route('companyOffres.index')->with('success', 'Company Offres Update successfully.');
    }

  
    public function destroy($id)
    {
        CompanyOffres::where('id', $id)->delete();
        return back()->with('success', 'Company Offres Deleted');
    }



 

   
}
