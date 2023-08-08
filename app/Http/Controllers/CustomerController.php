<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Yajra\DataTables\DataTables;
use DB;
Use View;
Use Storage;
use Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
      

        $customers = DB::table('customers')
        ->join('users', 'customers.user_id', '=', 'users.id')
        ->select('customers.*','customers.id AS cus_id','users.*')
        
        ->orderBy('customers.id','ASC')->get();
        return View::make('customers.index',compact('users','customers'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'customer_name' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'img_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    
        $messages = [
            'customer_name.required' => 'Account Name is required',
            'contact.required' => 'Account Contact is required',
            'address.required' => 'Account Home Address is required',
            'img_pathC.required' => 'Account Image is required',
            'img_pathC.image' => 'Account Image must be an image',
            'img_pathC.mimes' => 'Account Image must be a file of type: jpeg, png, jpg, gif',
            'img_pathC.max' => 'Account Image must not be larger than 2048 kilobytes',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $customers = new Customer;
    
        if ($request->file()) {
            $fileName = time() . '_' . $request->file('img_pathC')->getClientOriginalName();
    
            $path = Storage::putFileAs(
                'public/images', $request->file('img_pathC'), $fileName
            );
            $customer->img_pathC = '/storage/images/' . $fileName;
        }
    
        $customers->customer_name = $request->customer_name;
        $customers->contact = $request->contact;
        $customers->address = $request->address;
        $customers->user_id = Auth::user()->id;
    
        $usertype = Auth::user()->usertype;
        $customers->save();
    
        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
