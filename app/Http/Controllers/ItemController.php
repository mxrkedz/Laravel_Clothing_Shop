<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
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

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
    
        $items = Item::with(['category', 'supplier'])
            ->select('items.id as it_id', 'items.img_path as img', 'items.*')
            ->orderBy('items.id', 'ASC')
            ->get();
    
        return View::make('items.index', compact('categories', 'items', 'suppliers'));

        // $items = DB::table('items')
        // ->join('categories', 'items.cat_id', '=', 'categories.id')
        // ->join('suppliers', 'items.sup_id', '=', 'suppliers.id')
        // ->select('items.id as it_id', 'items.img_path as img', 'items.*', 'categories.*', 'suppliers.*')
        // ->orderBy('items.id', 'ASC')->get();
        // return View::make('items.index', compact('categories', 'items', 'suppliers'));

        // $items = Item::all();
        // return View::make('items.index',compact('items'));

    }
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Item::select('id', 'category_name')->get();
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
        $suppliers = Supplier::all();

        $categories = Category::all();
        return View::make('items.create', compact('suppliers', 'categories'));
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
            'item_name' => 'required|min:3',
            'sellprice' => 'required',
            'sup_id' => 'required',
            'cat_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'item_name.required' => 'The :attribute field is required.',
            'item_name.min' => 'Minimum of 3 characters please',
            'sellprice.required' => 'The :attribute field is required.',
        ])->validate();


        $items = new Item();

        $items->item_name = $request->item_name;
        $items->sellprice = $request->sellprice;
        $items->sup_id = $request->sup_id;
        $items->cat_id = $request->cat_id;
        // dd($item);

        if ($request->file()) {
            $fileName = time() . '_' . $request->file('img_path')->getClientOriginalName();

            // $filePath = $request->file('img_path')->storeAs('uploads', $fileName,'public');
            // dd($fileName,$filePath);

            $path = Storage::putFileAs(
                'public/images',
                $request->file('img_path'),
                $fileName
            );
            $items->img_path = '/storage/images/' . $fileName;

        }

        $items->save();
        return redirect()->route('items.index')->with('added', 'Added!');

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
        $item = DB::table('items')
        ->join('categories', 'items.cat_id', '=', 'categories.id')
        ->join('suppliers', 'items.sup_id', '=', 'suppliers.id')
        ->select('items.id as it_id', 'items.img_path as img', 'items.*', 'categories.*', 'suppliers.*')
        ->where('items.id', $id)
       ->first();
        $suppliers = Supplier::where('id', '<>', $item->sup_id)->get(['sup_name','id']);
        $categories = Category::where('id', '<>', $item->cat_id)->get(['category_name','id']);
        return view('items.edit', compact('item', 'suppliers', 'categories'));
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
            'item_name' => 'required|min:3',
            'sellprice' => 'required',
            'sup_id' => 'required',
            'cat_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'item_name.required' => 'The :attribute field is required.',
            'item_name.min' => 'Minimum of 3 characters please',
            'sellprice.required' => 'The :attribute field is required.',
        ])->validate();


        try {
            $validatedData = $request->validate($rules, $messages);
            $items = Item::find($id);

            $items->item_name = $request->item_name;
            $items->sellprice = $request->sellprice;

            if ($request->file()) {
                $fileName = time() . '_' . $request->file('img_path')->getClientOriginalName();

                // $filePath = $request->file('img_path')->storeAs('uploads', $fileName,'public');
                // dd($fileName,$filePath);

                $path = Storage::putFileAs(
                    'public/images',
                    $request->file('img_path'),
                    $fileName
                );
                $items->img_path = '/storage/images/' . $fileName;

            }

            $items->save();
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->with('alert', 'Please fix the errors below.')->withInput();
        }

                return redirect()->route('items.index')->with('updated', 'Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::destroy($id);
        return back()->with('deleted', 'Deleted!');
    }
    public function search(Request $request)
    {
        $query = $request->get('q');
        $items = DB::table('items')
    ->join('categories', 'items.cat_id', '=', 'categories.id')
    ->join('suppliers', 'items.sup_id', '=', 'suppliers.id')
    ->where('items.item_name', 'LIKE', '%' . $query . '%')
    ->select('items.id as item_id', 'items.img_path as img', 'items.*', 'categories.*', 'suppliers.*')
    ->orderBy('items.id', 'ASC')
    ->get();
        $categories = Category::all();

        return view('items.show', compact('items', 'categories'));
    }

    public function getItems()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $items = DB::table('items')
        ->join('categories', 'items.cat_id', '=', 'categories.id')
        ->join('suppliers', 'items.sup_id', '=', 'suppliers.id')
        ->whereRaw('LOWER(categories.category_name) = ?', ['Women'])//WHERE categories = men
        ->select('items.id as item_id', 'items.img_path as img', 'items.*', 'categories.*', 'suppliers.*')->orderBy('items.id', 'ASC')
        ->get();

        return View::make(('customer.women'), compact('items'));
    }

}
