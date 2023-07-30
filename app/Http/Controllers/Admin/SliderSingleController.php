<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Helpers\UtilHelper;
use App\Models\Slider;
use App\Traits\FileUpload;
use Auth;

class SliderSingleController extends AdminController
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
      return view('admin.sliders.index',compact('data'));
    }

    public function create()
    {
      return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
      $validate = $request->validate([
          'title' => 'required|string|max:100|unique:sliders',
          'link' => 'required|max:400',
          'image' => 'required|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
      ]);

      $slider = SLider::create( array_merge(
        $request->all() , [ 'ip' => UtilHelper::getUserIp() , 'access_user_id' => Auth::id() ] )
      );

      // upload image
      if( $request->hasFile('image') ) {
          $path = $this->storeFile($request , [
              'fileUpload' => 'image',
              'folder' => Slider::FILE_FOLDER,
              'recordId' => $slider->id,
          ]);
          $slider->Update(['image' => $path]);
      }


      $this->flashAlert([
        'success' => ['msg'=> __('messages.added') ]
      ]);

      return redirect(route('admin.sliders.index'));

    }


    public function edit(Request $request)
    {
      $data = Slider::findOrFail($request->id);
      return view('admin.sliders.edit',compact('data'));
    }

    public function update(Request $request)
    {

      $slider = Slider::findOrFail($request->id);

      $validate = $request->validate([
          'title' => 'required|string|max:100|unique:sliders,id,'.$request->id,
          'link' => 'required|max:400',
          'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:500',
      ]);

      $slider->update( array_merge(
        $request->all() , [ 'ip' => UtilHelper::getUserIp() , 'access_user_id' => Auth::id() ] )
      );

      // upload image
      if( $request->hasFile('image') ) {
          $path = $this->storeFile($request , [
              'fileUpload' => 'image',
              'folder' => Slider::FILE_FOLDER,
              'recordId' => $slider->id,
          ]);
          $slider->Update(['image' => $path]);
      }


      $this->flashAlert([
        'success' => ['msg'=> __('messages.updated') ]
      ]);

      return redirect(route('admin.sliders.index'));



    }

}
