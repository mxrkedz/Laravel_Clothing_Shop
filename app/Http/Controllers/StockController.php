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
        $stocks = Stock::with('item')
        ->select('stocks.*')
        ->get();

        $items = Item::all();

        return View::make('stocks.index', compact('stocks', 'items'));
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
        return view('stocks.datatable', compact('items'));
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
        $items = Item::all();

        return View::make('stocks.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'quantity' => 'required|numeric|min:0',
            ];
            $messages = [
                'quantity.required' => 'Please enter Quantity.',
                'quantity.numeric' => 'Quantity must be a number.',
                'quantity.min' => 'Quantity must be at least :min.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $stock = new Stock();
            $stock->item_id = $request->item_id;
            $stock->quantity = $request->quantity;
            $stock->save();

            return redirect()->route('stocks.index')->with('added', 'Added!');
        } catch (\Illuminate\Database\QueryException $exception) {
            // Handle the integrity constraint violation here
            return redirect()->route('stocks.index')->with('error', 'Item already added!');
        }
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
        $stock = DB::table('items AS is')
            ->select('is.id', 'ss.item_id', 'is.item_name', 'ss.quantity')
            ->join('stocks AS ss', 'ss.item_id', '=', 'is.id')
            ->where('ss.item_id', $id)
            ->first();
        // dd($stock);

        $items = Item::where('id', '<>', $stock->item_id)->get(['item_name', 'id']);

        return View::make('stocks.edit', compact('items', 'stock'));
    }

    public function edit2($id)
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
        $stock = DB::table('items AS is')
            ->select('is.id', 'ss.item_id', 'is.item_name', 'ss.quantity')
            ->join('stocks AS ss', 'ss.item_id', '=', 'is.id')
            ->where('ss.item_id', $id)
            ->first();

        if (!$stock) {
            // Handle the case where the stock doesn't exist for the given item
            // You might want to return an error response or redirect with a message
        }

        $stockQuantity = $stock->quantity + $request->quantity;

        // Update the stock quantity
        DB::table('stocks')
            ->where('item_id', $id)
            ->update(['quantity' => $stockQuantity]);

        return redirect()->route('stocks.index')->with('updated', 'Updated!');
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
        Stock::destroy($id);
        return back()->with('deleted', 'Deleted!');
    }

    public function ExportExcel($data)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');

        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);

            // Add the column names as the first row
            $column_names = array_shift($data);
            $spreadSheet->getActiveSheet()->fromArray([$column_names], null, 'A1');

            // Add the actual data starting from the second row
            $spreadSheet->getActiveSheet()->fromArray($data, null, 'A2');

            $Excel_writer = new Xls($spreadSheet);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Stock_ExportedData.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();

            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }
    public function exportData()
    {
        $data = Stock::select('item_id', 'quantity', 'created_at', 'updated_at')->get();
        $data_array [] = array("item_id","quantity","created_at","updated_at");
        foreach($data as $data_item) {
            $data_array[] = array(
                'item_id' => $data_item->item_id,
                'quantity' => $data_item->quantity,
                'created_at' => $data_item->created_at,
                'updated_at' => $data_item->updated_at
            );
        }
        $this->ExportExcel($data_array);
    }
}
