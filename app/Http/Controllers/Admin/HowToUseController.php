<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\HowToUse;
use Illuminate\Http\Request;
use App\Traits\FileUpload;


class HowToUseController extends AdminController
{

    use FileUpload;

    public function __construct()
    {
        $this->share([
            'page' => HowToUse::PAGE,
            'recordsCount' => HowToUse::count(),
        ]);
        $this->defaultLanguage = $this->defaultLanguage();
    }

    public function index(Request $request)
    {

        $trans = $this->defaultLanguage->locale;
        if ($request->isMethod('post')) {
            $trans = $request->trans;
        }

        $data = HowToUse::get();
        return view('admin.how_to_use.index', compact(['data', 'trans']));

    }

    public function create(Request $request)
    {

        $request->validate([
            'title' => 'required|max:100',
            'description' => 'required',
            'type' => 'required',
            'image' => 'required|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',

        ]);

        $HowToUse = HowToUse::create($request->all());

        if ($request->hasFile('image')) {
            $path = $this->storeFile($request, [
                'fileUpload' => 'image',
                'folder' => HowToUse::FILE_FOLDER,
                'recordId' => $HowToUse->id,
            ]);
            $HowToUse->Update(['image' => $path]);
        }

        $this->flashAlert(['success' => ['msg' => __('messages.added')]]);
        $request->flash();
        return back();
    }

    public function delete(Request $request)
    {

        if (HowToUse::find($request->route('id'))->delete()) {
            return response()->json(['success' => __('messages.deleted')]);
        } else {
            return response()->json(['error' => __('messages.deleted_faild')]);
        }
    }


    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100',
            'description' => 'required',
            'type' => 'required',
            'image' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',

        ]);

        $HowToUse=HowToUse::find($request->route('id'));
        if ($HowToUse) {

            $request->merge(['title' => array_merge($HowToUse->title, $request->title)]);
            $HowToUse->title = $request['title'];
            $request->merge(['description' => array_merge($HowToUse->description, $request->description)]);
            $HowToUse->description = $request['description'];

            $HowToUse->type=$request->type;
            $HowToUse->save();

            if ($request->hasFile('image')) {
                $path = $this->storeFile($request, [
                    'fileUpload' => 'image',
                    'folder' => HowToUse::FILE_FOLDER,
                    'recordId' => $HowToUse->id,
                ]);
                $HowToUse->Update(['image' => $path]);
            }

            $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
        } else {
            $this->flashAlert(['faild' => ['msg' => __('messages.updated_faild')]]);
        }

        $request->flash();
        return back();
    }

}
