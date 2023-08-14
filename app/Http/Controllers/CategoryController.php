<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
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

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        //dd(compact('categories'));
        return View::make('categorys.index', compact('categories'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select('id', 'category_name', 'img_path')->get();
            return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</button>';
                $button .= '   <button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                return $button;
            })
            ->make(true);
        }
        return view('categorys.datatable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('categorys.create');
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
            'category_name' => 'required|min:3',
            'img_path'    =>  'required|image',
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'category_name.required' => 'The :attribute field is required.',
            'category_name.min' => 'Minimum of 3 characters please',
        ])->validate();

        $categories = new Category();

        $categories->category_name = $request->category_name;
        if ($request->file()) {
            $fileName = time() . '_' . $request->file('img_path')->getClientOriginalName();

            // $filePath = $request->file('img_path')->storeAs('uploads', $fileName,'public');
            // dd($fileName,$filePath);

            $path = Storage::putFileAs(
                'public/images',
                $request->file('img_path'),
                $fileName
            );
            $categories->img_path = '/storage/images/' . $fileName;

        }

        $categories->save();
        return redirect()->route('category.index')->with('added', 'Added!');
    }
    public function store2(Request $request)
    {
        $rules = array(
            'category_name'    =>  'required|max:255|min:3',
            'img_path'    =>  'required|image',

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if ($request->hasFile('img_path')) {
            $imageName = time().$request->file('img_path')->getClientOriginalName();
            $path = $request->file('img_path')->storeAs('images/category', $imageName, 'public');
            $imgPath = 'storage/'.$path;
        } else {
            return response()->json(['errors' => ['Image not found']]);
        }

        $form_data = array(
            'category_name'        =>  $request->category_name,
            'img_path'    =>  $imgPath
        );

        Category::create($form_data);

        return response()->json(['success' => 'Category Added Successfully.']);
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
        $categories =  Category::find($id);
        return view('categorys.edit', compact('categories'));
    }

    public function edit2($id)
    {
        if(request()->ajax()) {
            $data = Category::findOrFail($id);
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
            'category_name' => 'required|max:255|min:3',
            'img_path'    =>  'required|image',
        ];
        $messages = [
            'category_name.required' => 'Please enter category name.',

        ];

        try {
            $validatedData = $request->validate($rules, $messages);
            $categories = Category::find($id);

            if ($request->file()) {
                $fileName = time() . '_' . $request->file('img_path')->getClientOriginalName();

                // $filePath = $request->file('img_path')->storeAs('uploads', $fileName,'public');
                // dd($fileName,$filePath);

                $path = Storage::putFileAs(
                    'public/images',
                    $request->file('img_path'),
                    $fileName
                );
                $categories->img_path = '/storage/images/' . $fileName;

            }
            $categories->category_name = $request->category_name;

            $categories->save();


        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->with('alert', 'Please fix the errors below.')->withInput();
        }

                return redirect()->route('category.index')->with('updated', 'Updated!');
    }

    public function update2(Request $request)
    {
        $rules = array(
            'category_name'        =>  'required|max:255|min:3',
            'img_path'    =>  'required|image',

        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if ($request->hasFile('img_path')) {
            $imageName = time().$request->file('img_path')->getClientOriginalName();
            $path = $request->file('img_path')->storeAs('images/category', $imageName, 'public');
            $imgPath = 'storage/'.$path;
        } else {
            return response()->json(['errors' => ['Image not found']]);
        }

        $form_data = array(
            'category_name'    =>  $request->category_name,
            'img_path'    => $imgPath
        );

        Category::whereId($request->hidden_id)->update($form_data);

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
        Category::destroy($id);
        return back()->with('deleted', 'Deleted!');
    }
    public function destroy2($id)
    {
        $data = Category::findOrFail($id);
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
            header('Content-Disposition: attachment;filename="Category_ExportedData.xls"');
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
    public function exportData()
    {
        $data = Category::select('id', 'category_name', 'img_path', 'created_at', 'updated_at')->get();
        $data_array [] = array("id","category_name","img_path","created_at","updated_at");
        foreach($data as $data_item) {
            $data_array[] = array(
                'id' =>$data_item->id,
                'category_name' => $data_item->category_name,
                'img_path' => $data_item->img_path,
                'created_at' => $data_item->created_at,
                'updated_at' => $data_item->updated_at
            );
        }
        $this->ExportExcel($data_array);
    }

    public function importData(Request $request)
    {
        $this->validate($request, [
            'uploaded_file' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('uploaded_file');
        try {
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range(2, $row_limit);
            $column_range = range('E', $column_limit);
            $startcount = 2;
            $data = array();
            foreach ($row_range as $row) {
                $data[] = [
                    'id' =>$sheet->getCell('A' . $row)->getValue(),
                    'category_name' => $sheet->getCell('B' . $row)->getValue(),
                    'img_path' => $sheet->getCell('C' . $row)->getValue(),
                    'created_at' => $sheet->getCell('D' . $row)->getValue(),
                    'updated_at' => $sheet->getCell('E' . $row)->getValue(),
                ];
                $startcount++;
            }
            DB::table('categories')->insert($data);
        } catch (Exception $e) {
            $error_code = $e->errorInfo[1];
            return back()->withErrors('There was a problem uploading the data!');
        }
        return back()->withSuccess('Great! Data has been successfully uploaded.');
    }
}
