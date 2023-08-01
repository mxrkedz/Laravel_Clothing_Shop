<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
Use DataTables;
Use View;
Use Storage;
Use DB;
Use Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
Use Illuminate\Support\Facades\Hash;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pmethods = PaymentMethod::all();
        
        return View::make('paymentmethods.index',compact('pmethods'));

        // if ($request->ajax()) {
        //     $data = PaymentMethod::select('id','methods')->get();
        //     return DataTables::of($data)->addIndexColumn()
        //     ->addColumn('action', function($data){
        //         $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
        //         $button .= '   <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
        //         return $button;
        //     })
        //     ->make(true);
        // }
        // return view('paymentmethods.index');
    }

    public function datatable(Request $request)
    {
        // $pmethods = PaymentMethod::all();
        
        // return View::make('paymentmethods.index',compact('pmethods'));

        if ($request->ajax()) {
            $data = PaymentMethod::select('id','methods')->get();
            return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                $button .= '   <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                return $button;
            })
            ->make(true);
        }
        return view('paymentmethods.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('paymentmethods.create');
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
            'methods' => 'required|min:3',
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'methods.required' => 'The :attribute field is required.',
            'methods.min' => 'Minimum of 3 characters please',
        ])->validate();

        $pmethods = new PaymentMethod;

        $pmethods->methods = $request->methods;

        $pmethods->save();
        return redirect()->route('paymentmethods.index')->with('added','Added!');
    }
    
    public function store2(Request $request)
    {
        $rules = array(
            'methods'    =>  'required'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
 
        $form_data = array(
            'methods'        =>  $request->methods
        );
 
        PaymentMethod::create($form_data);
 
        return response()->json(['success' => 'Payment Method Added Successfully.']);
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
        $pmethods =  PaymentMethod::find($id);
        return view('paymentmethods.edit', compact('pmethods'));
    }
    public function edit2($id)
    {
        if(request()->ajax())
        {
            $data = PaymentMethod::findOrFail($id);
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
        $rules = [
            'methods' => 'required|max:255|min:3',
        ];
        $messages = [
            'methods.required' => 'Please enter payment method name.',
            
        ];
        try {
            $validatedData = $request->validate($rules, $messages);
            $pmethods = PaymentMethod::find($id);

        $pmethods->methods = $request->methods;
 
        $pmethods->save();
          
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->with('alert', 'Please fix the errors below.')->withInput();
        }
        
                return redirect()->route('paymentmethods.index')->with('updated','Updated!');
    }

    public function update2(Request $request)
    {
        $rules = array(
            'methods'        =>  'required'
        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'methods'    =>  $request->methods
        );
 
        PaymentMethod::whereId($request->hidden_id)->update($form_data);
 
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
        PaymentMethod::destroy($id);
       return back()->with('deleted','Deleted!');
    }

    public function destroy2($id)
    {
        $data = PaymentMethod::findOrFail($id);
        $data->delete();
    }

    public function ExportExcel($data){
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
            header('Content-Disposition: attachment;filename="PaymentMethods_ExportedData.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }
    /**
     *This function loads the customer data from the database then converts it
     * into an Array that will be exported to Excel
     */
    public function exportData(){
        $data = PaymentMethod::select('id','methods','created_at','updated_at')->get();
        $data_array [] = array("id","methods","created_at","updated_at");
        foreach($data as $data_item)
        {
            $data_array[] = array(
                'id' =>$data_item->id,
                'methods' => $data_item->methods,
                'created_at' => $data_item->created_at,
                'updated_at' => $data_item->updated_at
            );
        }
        $this->ExportExcel($data_array);
    }
}
