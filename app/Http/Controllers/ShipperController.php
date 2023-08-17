<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Shipper;
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

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippers = Shipper::all();
        return View::make('shippers.index', compact('shippers'));
    }

    public function datatable(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $data = Shipper::select('id', 'ship_name', 'img_path')->get();
            return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                $button .= '   <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                return $button;
            })
            ->make(true);
        }
        return view('shippers.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('shippers.create');
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
            'ship_name' => 'required|min:3',
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'ship_name.required' => 'The :attribute field is required.',
            'ship_name.min' => 'Minimum of 3 characters please',
        ])->validate();


        $shippers = new Shipper();

        $shippers->ship_name = $request->ship_name;

        if ($request->file()) {
            $imageName = time() . '_' . $request->file('img_path')->getClientOriginalName();

            // Store the file in the 'public/images/shippers' directory using the storage facade.
            $path = $request->file('img_path')->storeAs(
                'public/images/shippers',
                $imageName
            );

            // Get the full image path for the database record.
            $imgPath = 'storage/' . str_replace('public/', '', $path);

            // $shippers->img_path = '/storage/images/' . $fileName;
            $shippers->img_path = $imgPath;

        }

        $shippers->save();
        return redirect()->route('shippers.index')->with('added', 'Added!');
    }

    public function store2(Request $request)
    {
        // dd($request);
        $rules = array(
            'ship_name'    =>  'required|min:3',
            'img_path'    =>  'required|image',

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if ($request->hasFile('img_path')) {
            $imageName = time().$request->file('img_path')->getClientOriginalName();
            $path = $request->file('img_path')->storeAs('images/shippers', $imageName, 'public');
            $imgPath = 'storage/'.$path;
        } else {
            return response()->json(['errors' => ['Image not found']]);
        }

        $form_data = array(
            'ship_name'    => $request->ship_name,
            'img_path'    => $imgPath
        );

        $shippers = Shipper::create($form_data);

        return response()->json(['success' => 'Shipping added successfully.']);

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
        $shippers =  Shipper::find($id);
        return view('shippers.edit', compact('shippers'));
    }

    public function edit2($id)
    {
        if(request()->ajax()) {
            $data = Shipper::findOrFail($id);
            // dd($data);
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
            'ship_name' => 'required|min:3',
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'ship_name.required' => 'The :attribute field is required.',
            'ship_name.min' => 'Minimum of 3 characters please',
        ])->validate();


        try {
            $validatedData = $request->validate($rules, $messages);
            $shippers = Shipper::find($id);

            $shippers->ship_name = $request->ship_name;

            if ($request->file()) {
                $fileName = time() . '_' . $request->file('img_path')->getClientOriginalName();

                // $filePath = $request->file('img_path')->storeAs('uploads', $fileName,'public');
                // dd($fileName,$filePath);

                $path = Storage::putFileAs(
                    'public/images',
                    $request->file('img_path'),
                    $fileName
                );
                $shippers->img_path = '/storage/images/' . $fileName;

            }

            $shippers->save();
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->with('alert', 'Please fix the errors below.')->withInput();
        }

                return redirect()->route('shippers.index')->with('updated', 'Updated!');
    }

    public function update2(Request $request)
    {
        // dd($request);
        $rules = array(
            'ship_name'    =>  'required|min:3',
            'img_path'    =>  'required|image',

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if ($request->hasFile('img_path')) {
            $imageName = time().$request->file('img_path')->getClientOriginalName();
            $path = $request->file('img_path')->storeAs('images/shippers', $imageName, 'public');
            $imgPath = 'storage/'.$path;
        } else {
            return response()->json(['errors' => ['Image not found']]);
        }

        $form_data = array(
            'ship_name'    => $request->ship_name,
            'img_path'    => $imgPath
        );

        Shipper::whereId($request->hidden_id)->update($form_data);

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
        Shipper::destroy($id);
        return back()->with('deleted', 'Deleted!');
    }
    public function destroy2($id)
    {
        $data = Shipper::findOrFail($id);
        $data->delete();
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
            header('Content-Disposition: attachment;filename="Shipper_ExportedData.xls"');
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
        $data = Shipper::select('id', 'ship_name', 'img_path', 'created_at', 'updated_at')->get();
        $data_array [] = array("id","ship_name","img_path","created_at","updated_at");
        foreach($data as $data_item) {
            $data_array[] = array(
                'id' => $data_item->id,
                'ship_name' => $data_item->ship_name,
                'img_path' => $data_item->img_path,
                'created_at' => $data_item->created_at,
                'updated_at' => $data_item->updated_at
            );
        }
        $this->ExportExcel($data_array);
    }
    public function importData(Request $request)
    {
        try {
            $request->validate([
                'uploaded_file' => 'required|file|mimes:xls,xlsx'
            ]);

            $the_file = $request->file('uploaded_file');
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();

            $data = [];
            foreach ($sheet->getRowIterator(2) as $row) {
                $cellIterator = $row->getCellIterator('A', 'E');
                $cellData = [];
                foreach ($cellIterator as $cell) {
                    $cellData[] = $cell->getValue();
                }

                $data[] = [
                    'id' => $cellData[0],
                    'ship_name' => $cellData[1],
                    'img_path' => $cellData[2],
                    'created_at' => $cellData[3],
                    'updated_at' => $cellData[4],
                ];
            }

            DB::table('shipping')->insert($data);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()->withErrors('There was a problem uploading the data!');
        }

        return back()->withSuccess('Great! Data has been successfully uploaded.');
    }
}
