<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Slider;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class SliderController extends AdminController
{
    use FileUpload;

    public function __construct()
    {

        $this->share([
            'page' => Slider::PAGE,
            'recordsCount' => Slider::count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {
        $data = Slider::all();

        return view('admin.sliders.index', compact('data'));
    }

    public function edit(Request $request)
    {
        $data = Slider::findOrFail($request->id);
        //  dd($data);
        return view('admin.sliders.edit', compact('data'));
    }

    public function update(Request $request)
    {

        // dd($request->all());

        $slider = Slider::findOrFail($request->id);
        $images = $slider->images;
        $data = array();
        $validate = $request->validate([
            // 'title' => 'required|string|max:100|unique:sliders,id,' . $request->id,
            'link' => 'nullable|string',
            'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
        ]);

        // $data['title'] = $request->title;
        $data['link'] = $request->link ?? null;
        $data['image'] = null;

        // upload image
        if ($request->hasFile('image')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'image',
                'folder' => Slider::FILE_FOLDER,
                'recordId' => $slider->id,
            ]);
            $data['image'] = $path;
        }

        if (isset($request->imageIndex)) {
            // to add new slider
            if (!$data['image']) {
                $data['image'] = $images[$request->imageIndex]['image'];
            }
            $images[$request->imageIndex] = $data;

        } else {
            // to edit exist slider
            if (!$data['image']) {
                $data['image'] = '';
            }
            $images = array_merge($images, [$data]);

        }

        if (count($images) <= $slider->max_number) {

            $slider->update(['images' => $images]);

            $this->flashAlert([
                'success' => ['msg' => __('messages.updated')],
            ]);
        } else {
            $this->flashAlert([
                'faild' => ['msg' => __('messages.updated_faild')],
            ]);
        }

        return redirect(route('admin.sliders.edit', ['id' => $request->id]));

    }

    public function delete(Request $request)
    {

        $slider = Slider::findOrFail($request->id);
        $images = $slider->images;
        unset($images[$request->imageIndex]);

        $slider->update(['images' => $images]);

        return response()->json(['success' => __('messages.deleted')]);

    }

}
