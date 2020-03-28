<?php

namespace App\Http\Controllers\Banner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Banner\Banner;

class BannerController extends Controller
{
    //
    public function index()
    {
        $banners = Banner::orderBy('id')->get();

        return $this->getResponse($banners);
    }

    public function read($id)
    {
        $banner = Banner::find($id);

        if (empty($banner)) {
            return $this->throwError(404);
        }

        return $this->getResponse($banner);
    }

    public function create(Request $request)
    {
        $banner = new Banner;

        $imageName = time().'.'.request()->image->getClientOriginalExtension();

        $banner->image = 'images/banner/' . $imageName;
        request()->image->move(public_path('images/banner'), $imageName);

        $banner->save();

        return $this->getResponse($banner, $request->input());
    }

    public function update(Request $request)
    {
        $banner = Banner::find($request->input('bannerId'));

        if (empty($banner)) {
            return $this->throwError(404);
        }

        $imageName = time().'.'.request()->image->getClientOriginalExtension();

        $banner->image = 'images/banner/' . $imageName;
        request()->image->move(public_path('images/banner'), $imageName);

        $banner->save();

        return $this->getResponse($banner, $request->input());
    }

    public function delete(Request $request)
    {
        $banner = Banner::find($request->input('bannerId'));

        if (empty($banner)) {
            return $this->throwError(404, $request->input('bannerId'));
        }

        $banner->delete();

        return $this->getResponse($banner, $request->input());
    }
}
