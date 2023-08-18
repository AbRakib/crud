<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::paginate(8);
        return view('brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands|max:100',
            'details' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->details = $request->details;
            $brand->save();
            return response()->json([
                'message' => 'success',
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $data = Brand::findOrFail($request->id);
        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $brand = Brand::findOrFail($request->editBrandId);
        $brand->name = $request->editBrandName;
        $brand->details = $request->editBrandDetails;
        $brand->update();

        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $brand->delete();
        return response()->json([
            'status' => 'success',
        ]);
    }
}
