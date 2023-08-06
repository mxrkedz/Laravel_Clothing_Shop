<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Item;
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

class StockController extends Controller
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
            $data = Stock::join('items', 'stocks.id', '=', 'items.id')
            ->select('stocks.*', 'items.item_name', 'items.img_path')
            ->get();
            return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                $button .= '   <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                return $button;
            })
            ->make(true);
        }

        $items = Item::all();
        return view('stocks.datatable' , compact('items'));
    }

    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $items = Item::all();
        // return View::make('items.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function store2(Request $request)
    {
        // dd($request);
        $rules = array(
            'quantity'    =>  'required|numeric'

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'quantity'    => $request->quantity,
        );
              
        $stock = Stock::create($form_data);
        
        return response()->json(['success' => 'Stocks added successfully.']);

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
        // FOR CRUD
    }

    public function edit2($id )
    {
        if (request()->ajax()) {
            $data = Stock::join('items', 'stocks.id', '=', 'items.id')
                ->select('stocks.*', 'items.id as item_id', 'items.item_name', 'items.img_path')
                ->findOrFail($id);
        
            return response()->json(['result' => $data]);
        }
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

    public function update2(Request $request)
    {
        // dd($request);
        $rules = array(
            'quantity'    =>  'required|numeric'

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'quantity'    => $request->quantity,
        );
              
        Stock::whereId($request->hidden_id)->update($form_data);
 
        return response()->json(['success' => 'Data is successfully updated']);
    
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
