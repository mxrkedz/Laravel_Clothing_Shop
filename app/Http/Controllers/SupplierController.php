<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
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
        // dd($request);
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
            'sup_name'    =>  'required|min:3',
            'sup_contact' =>  'required|numeric|min:5',
            'sup_address' =>  'required|min:5',
            'sup_email'   =>  'required|email',
            'img_path'    =>  'required|image'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if ($request->hasFile('img_path')) {
            $imageName = time().$request->file('img_path')->getClientOriginalName();
            $path = $request->file('img_path')->storeAs('images/suppliers', $imageName, 'public');
            $imgPath = 'storage/'.$path;
        } else {
            return response()->json(['errors' => ['Image not found']]);
        }
        
        $form_data = array(
            'sup_name'    => $request->sup_name,
            'sup_contact' => $request->sup_contact,
            'sup_address' => $request->sup_address,
            'sup_email'   => $request->sup_email,
            'img_path'    => $imgPath
        );
        
        $supplier = Supplier::create($form_data);
        
        return response()->json(['success' => 'Supplier added successfully.']);
        
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

    public function edit2($id)
    {
        if(request()->ajax())
        {
            $data = Supplier::findOrFail($id);
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
        // FOR CRUD
    }

    public function update2(Request $request)
    {
        $rules = array(
            'sup_name'    =>  'required',
            'sup_contact'    =>  'required',
            'sup_address'    =>  'required',
            'sup_email'    =>  'required',
            'img_path'    =>  'required'

        );
 
        $error = Validator::make($request->all(), $rules);
 
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if ($request->hasFile('img_path')) {
            $imageName = time().$request->file('img_path')->getClientOriginalName();
            $path = $request->file('img_path')->storeAs('images/suppliers', $imageName, 'public');
            $imgPath = 'storage/'.$path;
        } else {
            return response()->json(['errors' => ['Image not found']]);
        }
        
        $form_data = array(
            'sup_name'    => $request->sup_name,
            'sup_contact' => $request->sup_contact,
            'sup_address' => $request->sup_address,
            'sup_email'   => $request->sup_email,
            'img_path'    => $imgPath
        );
        
        Supplier::whereId($request->hidden_id)->update($form_data);
 
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
        // FOR CRUD
    }
    public function destroy2($id)
    {
        $data = Supplier::findOrFail($id);
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
            header('Content-Disposition: attachment;filename="Supplier_ExportedData.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }
    public function exportData(){
        $data = Supplier::select('id','sup_name', 'sup_contact','sup_address','sup_email','img_path','created_at','updated_at')->get();
        $data_array [] = array("id","sup_name","sup_contact","sup_address","sup_email","img_path","created_at","updated_at");
        foreach($data as $data_item)
        {
            $data_array[] = array(
                'id' =>$data_item->id,
                'sup_name' => $data_item->sup_name,
                'sup_contact' => $data_item->sup_contact,
                'sup_address' => $data_item->sup_address,
                'sup_email' => $data_item->sup_email,
                'img_path' => $data_item->img_path,
                'created_at' => $data_item->created_at,
                'updated_at' => $data_item->updated_at
            );
        }
        $this->ExportExcel($data_array);
    }
}
