<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()->take(100)->get();
        return view ('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->can('create-customers')) {
            Alert::error('Customer Not Created', 'Oluşturma yetkiniz yok');
            return redirect()->route('customers.index');
        }
        return view ('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $customer = new Customer();
        $customer->user_id = auth()->user()->id;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->province = $request->province;
        $customer->postal_code = $request->postal_code;
        $customer->country = $request->country;
        $customer->company = $request->company;
        $customer->save();
        if ($customer->saveOrFail()) {
            Alert::success('Customer Created', 'Customer created');
            return redirect()->route('customers.edit',compact('customer'));
        } else {
            Alert::info('Customer Not Created', 'Not created');
            return redirect()->route('customers.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $customer = Customer::findOrFail($id);
        $this->authorize('update', $customer);

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $customer = Customer::findOrFail($id);
        $this->authorize('update', $customer);

        $customer->user_id = auth()->user()->id;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->province = $request->province;
        $customer->postal_code = $request->postal_code;
        $customer->country = $request->country;
        $customer->company = $request->company;
        $customer->save();
        if ($customer->getChanges()) {
            Alert::success('Customer Updated', 'Customer  updated');
        } else {
            Alert::info('Customer Updated', 'No changes');
        }

        return view('customers.edit', compact('customer'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $this->authorize('delete', $customer);

        if (Auth::user()->can('delete-customers', $customer)) {
            Alert::error('Customer Not Deleted', 'Silme yetkiniz yok');
            return redirect()->route('customers.index');
        }

        $customer->delete();
        Alert::success('Customer Deleted', 'Customer  deleted');
        return redirect()->route('customers.index');
    }

    public function export()
    {
        Alert::success('Customer Exported', 'Customer  exported');
        $excel = app()->make(Excel::class);

        return $excel->download(new CustomersExport(), 'customers.xlsx');
    }
}
