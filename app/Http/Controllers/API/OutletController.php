<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Validator;

class OutletController extends Controller
{

    public function index()
    {
        $outlets = Outlet::all();
        return response()->json([
        "success" => true,
        "message" => "Outlet List",
        "data" => $outlets
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
        'name' => 'required',
        'phone' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'image' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['error' => 'Invalid data'], 405);
        }
        $outlet = Outlet::create($input);
        return response()->json([
        "success" => true,
        "message" => "Outlet created successfully.",
        "data" => $outlet
        ]);
    } 

    public function show($id)
    {
        $outlet = Outlet::find($id);
        if (is_null($outlet)) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json([
        "success" => true,
        "message" => "Outlet retrieved successfully.",
        "data" => $outlet
        ]);
    }

    public function update(Request $request, Outlet $outlet)
    {
        $input = $request->all();  
        $outlet->name = $input['name'];
        $outlet->phone = $input['phone'];   
        $outlet->latitude = $input['latitude'];
        $outlet->longitude = $input['longitude'];        
        $outlet->image = $input['image'];        

        $outlet->save();
        return response()->json([
        "success" => true,
        "message" => "Outlet updated successfully.",
        "data" => $outlet
        ]);
    }

    public function destroy(Outlet $outlet)
    {
        $outlet->delete();
        return response()->json([
        "success" => true,
        "message" => "Outlet deleted successfully.",
        "data" => $outlet
        ]);
    }
}