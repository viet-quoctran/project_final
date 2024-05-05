<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Package;
use App\Models\Project;
class TableController extends Controller
{
    public function index(){
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('id', 1);
        })->get();
        $packages = Package::all();
        return view('admin.table.table',compact(['users','packages']));
    }
    public function addPackage(Request $request){
        $request->validate([
            'packageName' => 'required|string',
            'packageAmount' => 'required|numeric',
            'packageQualityDashboard' => 'required|numeric',
            'packageDescription' => 'nullable|string',
            'packageImage' => 'nullable|image|max:2048',  // Giới hạn file ảnh lên đến 2MB
        ]);
    
        $package = new Package();
        $package->name = $request->packageName;
        $package->amount = $request->packageAmount;
        $package->quality_dashboard = $request->packageQualityDashboard;
        $package->description = $request->packageDescription;
    
        if ($request->hasFile('packageImage')) {
            $path = $request->file('packageImage')->store('public/packageImages');
            $package->image = $path;
        }
    
        $package->save();
    
        return response()->json(['message' => 'Package added successfully', 'package' => $package]);
    }
    public function addProject(Request $request){
        $request->validate([
            'projectName' => 'required|string',
            'linkPowerBi' => 'nullable|string',
        ]);
    
        $project = new Project();
        $project->name = $request->projectName;
        $project->link_power_bi = $request->linkPowerBi;
        $project->user_id = $request->user_id;
        $project->save();
    
        return response()->json(['message' => 'Project added successfully', 'project' => $project]);
    }
}
