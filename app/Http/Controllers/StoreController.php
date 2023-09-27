<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Store;
use DataTables;

class StoreController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
    }

   public function index()
    {
        return view('store.index');
    }

   // Get Table Data
   public function getStore(){
         $stores = Store::query();
         return DataTables::of($stores)->addColumn('action', function ($item) {
           
          $showBtn =  '<button ' .
                          ' class="btn btn-outline-info" ' .
                          ' onclick="showStore(' . $item->id . ')">Show' .
                      '</button> ';
 
          $editBtn =  '<button ' .
                          ' class="btn btn-outline-success" ' .
                          ' onclick="editStore(' . $item->id . ')">Edit' .
                      '</button> ';
 
          $deleteBtn =  '<button ' .
                          ' class="btn btn-outline-danger" ' .
                          ' onclick="destroyStore(' . $item->id . ')">Delete' .
                      '</button> ';
 
          return $showBtn . $editBtn . $deleteBtn;
      }) ->rawColumns(['action',])->make(true);

   }

   // Get Data in Json
   public function jsonData($id){
    	  $item = Store::find($id);
          if(!empty($item)){
            return response()->json([
	          'data' => $item
	        ]);
          }
    }

   public function show($id){
        $item = Store::findOrFail($id);
        return view('store.show', ['item'=> $item]);
    }

    public function create(){
        return view('store.create');
    }

 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        request()->validate([
            'name' => 'required|max:255',
            'type' => 'required',
        ]);
  
        $project = new Store();
        $project->name = $request->name;
        $project->type = $request->type;
        $project->save();
        return response()->json(['status' => "success"]);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id){
        $item = Store::findOrFail($id);
        return view('store.edit', ['item'=> $item]);
    }

    public function update(Request $request, $id){
        request()->validate([
            'name' => 'required|max:255',
            'type' => 'required',
        ]);
  
        $item = Store::find($id);
        $item->name = $request->name;
        $item->type = $request->type;
        $item->save();
        return response()->json(['status' => "success"]);
    }

    // Destroy Entry
    public function destroy($id){
        $item = Store::findOrFail($id);
        $item->delete(); 
        return response()->json(['status' => "success"]);
    }
}
