<?php

namespace App\Http\Controllers\Banner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Banner\Banner;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;

class BannerController extends Controller
{
    //
    public function index()
    {
        $banners = Banner::orderBy('id')->get();

        $bannerArray = $banners->toArray();

        $result = array_map(function ($row) {
            $mapResult = $row;
            $mapResult['imageurl'] = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $row['image'];

            return $mapResult;
        }, $bannerArray);


        return $this->getResponse($result);
    }

    public function read($id)
    {
        $banner = Banner::find($id);

        if (empty($banner)) {
            return $this->throwError(404);
        }

        $result = $banner->toArray();
        $result['imageUrl'] = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $banner['image'];

        return $this->getResponse($result);
    }

    public function create(Request $request)
    {

        // $imageName = time().'.'.request()->image->getClientOriginalExtension();

        // $banner->image = 'images/banner/' . $imageName;
        // request()->image->move(public_path('images/banner'), $imageName);

        try{
            $filePath = '';
            if (!empty(request()->image)) {
                // $file = $request->file('image');
                $file = request()->image;
                $name = time() . $file->getClientOriginalName();
                $filePath = 'sayur/images/banner/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
            }

            $banner = new Banner;
            $banner->image = $filePath;
            $banner->save();

        } catch (Exception $e) {
            return $e;
        }


        return $this->getResponse($banner, $request->input());
    }

    public function update(Request $request)
    {
        $banner = Banner::find($request->input('bannerId'));

        if (empty($banner)) {
            return $this->throwError(404);
        }

        // $imageName = time().'.'.request()->image->getClientOriginalExtension();

        // $banner->image = 'images/banner/' . $imageName;
        // request()->image->move(public_path('images/banner'), $imageName);

        try{
            $filePath = '';
            if (!empty(request()->image)) {
                // $file = $request->file('image');
                $file = request()->image;
                $name = time() . $file->getClientOriginalName();
                $filePath = 'sayur/images/banner/' . $name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
            }

            $banner = new Banner;
            $banner->image = $filePath;
            $banner->save();
            
        } catch (Exception $e) {
            return $e;
        }


        $banner->save();

        return $this->getResponse($banner, $request->input());
    }

    public function delete(Request $request)
    {
        $banner = Banner::find($request->input('bannerId'));

        if (empty($banner)) {
            return $this->throwError(404, $request->input('bannerId'));
        }

        Storage::disk('s3')->delete($banner->image);

        $banner->delete();

        return $this->getResponse($banner, $request->input());
    }
}
