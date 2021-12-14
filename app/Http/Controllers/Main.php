<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\AssetType;
use App\Models\Asset;
use App\Models\AssetImage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class Main extends Controller
{
    public function master()    //master page
    {
        return view('admin.master');
    }

    public function home()  //home page
    {
        return view('admin.pages.home');
    }

    public function changepass()    //change password page
    {
        $id = Auth::user()->id;
        return view('admin.pages.changepass', ['id' => $id]);
    }

    public function passvalid(Request $req) //change password validation
    {
        $validatePass = $req->validate([
            'uid' => 'required',
            'opass' => 'required',
            'pass' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
            'cpass' => 'required_with:pass|same:pass',
        ], [
            'opass.required' => "Enter current password",

            'pass.required' => "Enter password",
            'pass.regex' => "Minimum eight characters, at least one uppercase letter, one lowercase letter and one number",

            'cpass.required_with' => "Re-enter new password",
            'cpass.same' => "Password doesn't match",
        ]);
        if ($validatePass) {

            $password = Auth::user()->password;
            if (Hash::check($req->opass, $password)) {
                $npass = Hash::make($req->pass);
                DB::table('users')->where('id', $req->uid)->update([
                    'password' => $npass,

                ]);
                return back()->with('Success', 'Password changed successfully!');
            } else {
                return back()->with('Error', 'Incorrect current password');
            }
        }
    }

    public function editprofile()
    {
        return view('admin.pages.editprofile');
    }

    public function editprofilevalid(Request $req) //edit profile validation
    {
        $validateUser = $req->validate([
            'uid' => 'required',
            'name' => 'required',
            'mail' => 'required|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',
        ], [
            'name.required' => "Enter name",

            'mail.required' => "Enter password",
            'mail.regex' => "Enter valid format (example: abc@lmn.xyz)",

        ]);
        if ($validateUser) {

            if(DB::table('users')->where('id', $req->uid)->update([
                'name' => $req->name,
                'email' => $req->mail,

            ])){
                return back()->with('Success', 'Profile updated successfully!');
            }else {
                return back()->with('Error', 'Profile update failed');
            }
        }
    }

    public function dashboard() //dashboard page
    {
        $typeData = AssetType::all();
        $data = DB::select(DB::raw("select count(*) as asset_count,
        type_id from assets group by type_id"));
        $pieChart = "";
        $total = 0;
        foreach ($data as $a) {
            foreach ($typeData as $type) {
                if ($type->id == $a->type_id) {
                    $name = $type->name;
                    $pieChart .= "['" . $name . "',     " . $a->asset_count . "],";
                    $total += $a->asset_count;
                }
            }
        }
        $status = DB::select(DB::raw("select count(*) as status_count,
        status from assets group by status"));
        $barChart = "";
        foreach ($status as $s) {
            if ($s->status == '1') {
                $name = 'Active';
            } else {
                $name = 'Inactive';
            }
            $barChart .= "['" . $name . "',     " . $s->status_count . "],";
        }
        $pieChart = rtrim($pieChart, ',');
        $barChart = rtrim($barChart, ',');
        return view('admin.pages.dashboard', ['pieChart' => $pieChart, 'barChart' => $barChart, 'total' => $total]);
    }

    public function assetType() //asset type page
    {
        $typeData = AssetType::paginate(3);
        return view('admin.pages.asset-type', ['typeData' => $typeData]);
    }

    public function addAssetType()  //add asset type page
    {
        return view('admin.pages.add-asset-type');
    }

    public function assetTypeValid(Request $req)    //asset type validation
    {
        $validateType = $req->validate([
            'name' => 'required|unique:asset_types',
            'desc' => 'max:500',
        ], [
            'name.required' => "Enter name",
            'name.unique' => "Asset already exists",

            'desc.max' => "Maximum 500 characters",
        ]);
        if ($validateType) {

            $type = new AssetType();
            $type->name = $req->name;
            if ($req->desc) {
                $type->description = $req->desc;
            } else {
                $type->description = '';
            }
            if ($type->save()) {
                return Redirect::to('/asset-type')->with('Success', 'Asset type added successfully');
            } else {
                return back()->with('Error', 'Adding asset type failed');
            }
        }
    }

    public function deltype(Request $req)   //delete asset type
    {
        $id = $req->tid;
        $type = AssetType::where('id', '=', $id)->first();
        if ($type) {
            $asset = Asset::where('type_id', '=', $id)->get();
            if ($asset) {
                foreach ($asset as $a) {
                    $image = AssetImage::where('asset_id', '=', $a->id)->get();
                    foreach ($image as $i) {
                        $imgName = public_path('uploads/') . $i->image;
                        unlink($imgName);
                        $i->delete();
                    }
                    $a->delete();
                }
            }
            if ($type->delete()) {
                return "Asset type and assets deleted successfully";
            } else {
                return "Error deleting asset type";
            }
        }
    }

    public function edittype($id)   //edit asset type page
    {

        $type = AssetType::where('id', '=', $id)->first();
        return view('admin.pages.edit-type', ['typeData' => $type]);
    }

    public function editTypeValid(Request $req) //edit asset type validation
    {
        $validateType = $req->validate([
            'name' => 'required',
            'desc' => 'max:500',
            'tid' => 'required',
        ], [
            'name.required' => "Enter name",

            'desc.max' => "Maximum 500 characters",
        ]);
        if ($validateType) {

            $type = AssetType::where('id', '=', $req->tid)->first();
            $type->name = $req->name;
            $type->description = $req->desc;
            if ($type->save()) {
                return Redirect::to('/asset-type')->with('Success', 'Asset type updated successfully');
            } else {
                return back()->with('Error', 'Updating asset type failed');
            }
        }
    }

    public function asset($id = null)   //asset page
    {
        if ($id != null) {
            $assetData = Asset::where('type_id', '=', $id)->orderBy('created_at', 'DESC')->paginate(5);
            $typeData = AssetType::all();
            $imgData = AssetImage::all();
            return view('admin.pages.asset', ['assetData' => $assetData, 'typeData' => $typeData, 'imgData' => $imgData]);
        } else {
            $assetData = Asset::orderBy('created_at', 'DESC')->paginate(5);
            $typeData = AssetType::all();
            $imgData = AssetImage::all();
            return view('admin.pages.asset', ['assetData' => $assetData, 'typeData' => $typeData, 'imgData' => $imgData]);
        }
    }

    public function addAsset()  //add asset page
    {
        $typeData = AssetType::all();
        return view('admin.pages.add-asset', ['typeData' => $typeData]);
    }

    public function assetValid(Request $req)    //asset validation
    {
        $validateAsset = $req->validate([
            'name' => 'required',
            'type' => 'required',
            'filenames.*' => 'mimes:jpeg,jpg,png',
        ], [
            'name.required' => "Enter name",
            'type.required' => "Select asset type",
            'filenames.mimes' => "Only jpeg, jpg and png files allowed",
        ]);
        if ($validateAsset) {
            $uuid = hexdec(uniqid());
            $asset = new Asset();
            $asset->name = $req->name;
            $asset->type_id = $req->type;
            $asset->code = $uuid;
            $asset->status = $req->status;

            if ($asset->save()) {
                $id = $asset->id;
                if ($req->filenames) {
                    foreach ($req->filenames as $img) {
                        $name = $id . "--" . rand() . '.' . $img->extension();
                        $image = new AssetImage();
                        $image->image = $name;
                        $image->asset_id = $id;
                        $image->save();
                        $img->move(public_path('uploads'), $name);
                    }
                }
                return Redirect::to('/asset')->with('Success', 'Asset added successfully');
            } else {
                return back()->with('Error', 'Adding asset failed');
            }
        }
    }

    public function delasset(Request $req)  //delete asset
    {
        $id = $req->aid;
        $asset = Asset::where('id', '=', $id)->first();
        $images = AssetImage::where('asset_id', '=', $id)->get();
        if ($images) {
            foreach ($images as $img) {
                $imgName = public_path('uploads/') . $img->image;
                unlink($imgName);
                $img->delete();
            }
        }
        if ($asset->delete()) {
            return "Asset deleted successfully";
        } else {
            return "Error deleting asset";
        }
    }

    public function editasset($id)  //edit asset page
    {

        $asset = Asset::where('id', '=', $id)->first();
        $typeData = AssetType::all();
        return view('admin.pages.edit-asset', ['assetData' => $asset, 'typeData' => $typeData]);
    }

    public function editAssetValid(Request $req)    //edit asset validation
    {
        $validateAsset = $req->validate([
            'name' => 'required',
            'type' => 'required',
            'aid' => 'required',
            'filenames.*' => 'mimes:jpeg,jpg,png',
        ], [
            'name.required' => "Enter name",
            'type.required' => "Select asset type",
            'filenames.mimes' => "Only jpeg, jpg and png files allowed",
        ]);
        if ($validateAsset) {
            $asset = Asset::where('id', '=', $req->aid)->first();
            $asset->name = $req->name;
            $asset->type_id = $req->type;
            $asset->status = $req->status;

            if ($asset->save()) {
                $id = $asset->id;
                if ($req->filenames) {
                    foreach ($req->filenames as $img) {
                        $name = $id . "--" . rand() . '.' . $img->extension();
                        $image = new AssetImage();
                        $image->image = $name;
                        $image->asset_id = $id;
                        $image->save();
                        $img->move(public_path('uploads'), $name);
                    }
                }
                return Redirect::to('/asset')->with('Success', 'Asset updated successfully');
            } else {
                return back()->with('Error', 'Updating asset failed');
            }
        }
    }

    public function downloadCSV()   //download asset csv
    {
        $assetData = Asset::leftJoin('asset_images', 'assets.id', '=', 'asset_images.asset_id')
            ->get(['assets.*', 'asset_images.image', 'asset_images.id']);
        $csv = fopen(public_path('asset.csv'), 'w');
        foreach ($assetData as $row) {
            fputcsv($csv, $row->toArray(), ';');
        }
        if (fclose($csv)) {
            return back()->with('Success', 'File downloaded successfully');
        } else {
            return back()->with('Error', 'Error downloading file');
        }
    }

    public function view($id)   //view asset page
    {
        $type = AssetType::all();
        $asset = Asset::find($id);
        $images = AssetImage::where('asset_id', '=', $id)->get();
        if (!$images) {
            return view('admin.pages.view-asset', ['asset' => $asset, 'images' => '0 Images Available']);
        } else {
            return view('admin.pages.view-asset', ['asset' => $asset, 'images' => $images, 'type' => $type]);
        }
    }

    public function logout()    //logout
    {
        Session::flush();
        Auth::logout();
        return Redirect::to('/login');
    }
}

// DB::table('posts')->where('id', $req->id)->update([
//     'title' => $req->title,
//     'description' => $req->desc,

// ]);

// if (Hash::check($pass, $userdets->password)) 

// 'pass' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
//             'conpass' => 'required_with:pass|same:pass'

// 'pass.required' => "Enter password",
//             'pass.regex' => "Minimum eight characters, at least one uppercase letter, one lowercase letter and one number",

//             'conpass.required_with' => "Re-enter password",
//             'conpass.same' => "Password doesn't match",