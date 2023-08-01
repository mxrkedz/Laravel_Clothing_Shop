<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use View;
use Storage;
use DB;
use Validator;
use DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // FOR CRUD
    }
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::select('id', 'sup_name', 'sup_contact', 'sup_address', 'sup_email', 'img_path', )->get();
            return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                $button .= '   <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                return $button;
            })
            ->make(true);
        }
        return view('suppliers.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // FOR CRUD
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // FOR CRUD
    }

    public function store2(Request $request)
    {
        $rules = array(
            'sup_name'    =>  'required',
            'sup_contact'    =>  'required',
            'sup_address'    =>  'required',
            'sup_email'    =>  'required',
            'img_path'    =>  'required|image|mimes:jpeg,png,jpg,gif'

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'sup_name'        =>  $request->sup_name,
            'sup_contact'        =>  $request->sup_contact,
            'sup_address'        =>  $request->sup_address,
            'sup_email'        =>  $request->sup_email,

        );
        if ($request->hasFile('img_path')) {
            $fileName = time() . '_' . $request->file('img_path')->getClientOriginalName();
            $path = $request->file('img_path')->storeAs('public/images', $fileName);
            $form_data['img_path'] = '/storage/images/' . $fileName;
        }

        Supplier::create($form_data);

        return response()->json(['success' => 'Supplier Added Successfully.']);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // FOR CRUD
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // FOR CRUD
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
        // FOR CRUD
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // FOR CRUD
    }
}
