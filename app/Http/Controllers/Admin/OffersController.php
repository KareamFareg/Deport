<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Offer;
use App\Models\OfferDetails;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;

class OffersController extends AdminController
{
    use FileUpload;
    private $categoryServ;
    private $defaultLanguage;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryServ = $categoryService;

        $this->share([
            'page' => Offer::PAGE,
            'recordsCount' => Offer::count(),
        ]);
        $this->defaultLanguage = $this->defaultLanguage();
    }

    public function index(Request $request)
    {

        $trans = $this->defaultLanguage->locale;
        if ($request->isMethod('post')) {
            $trans = $request->trans;
        }

        $data = Offer::orderBy('id', 'desc')->get();
        return view('admin.offers.index', compact(['data', 'trans']));

    }

    public function edit(Request $request)
    {

        $id = $request->route('id');
        $trans = $this->defaultLanguage->locale;
        if ($request->isMethod('post')) {
            $trans = $request->trans;
        }

        $offer = Offer::find($id);
        // $offerDetails = OfferDetails::where('offer_id', $id)->get();
        // $data = Offer::orderBy('id', 'desc')->get();

        $categoriesIds = Category::whereIn('parent_id', [1])->get()->pluck('id');
        $categories = $this->categoryServ->queryParents($categoriesIds);
        
        $data = Product::where('offer_id',$id)->get();
       // return view('admin.products.index', compact(['data', 'categories','parents']));


        return view('admin.offers.edit', compact(['offer', 'trans', 'data','categories']));

    } 
    public function edit_details(Request $request)
    {

        $id = $request->route('id');
        $trans = $this->defaultLanguage->locale;
        if ($request->isMethod('post')) {
            $trans = $request->trans;
        }

        $offerDetails = OfferDetails::find($id);

        return view('admin.offers.edit_details', compact(['offerDetails', 'trans']));

    }

    public function create(Request $request)
    {

        $request->validate([
            'title' => 'required|array|max:100',
            'images' => 'required',
            'images.*' => 'required|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',

        ]);

        $offer = Offer::create($request->all());

        if ($request->hasFile('logo')) {
            $path = $this->storeFile($request, [
                'fileUpload' =>'logo',
                'folder' => Offer::FILE_FOLDER,
                'recordId' => $offer->id,
            ]);
            $offer->Update(['logo' => $path]);
        }

        if ($request->hasfile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $this->storeFile([], [
                    'fileUpload' => $image,
                    'folder' => Offer::FILE_FOLDER,
                    'recordId' => $offer->id,
                ]);
                $images[] = $path;
            }
            $offer->Update(['images' => $images]);
        }

        $this->flashAlert(['success' => ['msg' => __('messages.added')]]);
        $request->flash();
        return back();
    } 
    public function create_details(Request $request)
    {
        $offer_id = $request->route('offer_id');
        $request->validate([
            'title' => 'required|array|max:100',
            'description' => 'required|array|',
            'logo' => 'required|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',
            'images' => 'required',
            'images.*' => 'required|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',

        ]);

        $OfferDetails = OfferDetails::create(array_merge(['offer_id'=>$offer_id], $request->all()) );

        if ($request->hasFile('logo')) {
            $path = $this->storeFile($request, [
                'fileUpload' =>'logo',
                'folder' => Offer::FILE_FOLDER,
                'recordId' => $OfferDetails->id,
            ]);
            $OfferDetails->Update(['logo' => $path]);
        }

        if ($request->hasfile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $this->storeFile([], [
                    'fileUpload' => $image,
                    'folder' => Offer::FILE_FOLDER,
                    'recordId' => $OfferDetails->id,
                ]);
                $images[] = $path;
            }
            $OfferDetails->Update(['images' => $images]);
        }

        $this->flashAlert(['success' => ['msg' => __('messages.added')]]);
        $request->flash();
        return back();
    }


    public function update(Request $request)
    {
        $id = $request->route('id');
        $request->validate([
            'title' => 'required|array|max:100',
            'images' => 'nullable',
            'images.*' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',

        ]);

        $offer = Offer::find($id);
        if ($offer) {

            $request->merge(['title' => array_merge($offer->title, $request->title)]);
            $offer->title = $request['title'];

            $offer->save();

            if ($request->hasFile('logo')) {
                $path = $this->storeFile($request, [
                    'fileUpload' =>'logo',
                    'folder' => Offer::FILE_FOLDER,
                    'recordId' => $offer->id,
                ]);
                $offer->Update(['logo' => $path]);
            }

            

            if ($request->hasfile('images')) {
                $images = [];
                foreach ($request->file('images') as $image) {
                    $path = $this->storeFile([], [
                        'fileUpload' => $image,
                        'folder' => Offer::FILE_FOLDER,
                        'recordId' => $offer->id,
                    ]);
                    $images[] = $path;
                }
                $offer->Update(['images' => array_merge($offer->images, $images)]);
            }

            $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
        } else {
            $this->flashAlert(['faild' => ['msg' => __('messages.updated_faild')]]);
        }

        $request->flash();
        return back();
    }

    public function update_details(Request $request)
    {
        $id = $request->route('id');
        $request->validate([
            'title' => 'required|array|max:100',
            'description' => 'required|array|',
            'logo' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',
            'images' => 'nullable',
            'images.*' => 'nullable|file|image|mimes:jpeg,png,gif,jpg,svg|max:300',

        ]);

        $OfferDetails = OfferDetails::find($id);
        if ($OfferDetails) {

            $request->merge(['title' => array_merge($OfferDetails->title, $request->title)]);
            $OfferDetails->title = $request['title'];
            $request->merge(['description' => array_merge($OfferDetails->description, $request->description)]);
            $OfferDetails->description = $request['description'];
          
            $OfferDetails->lat = $request['lat'];
            $OfferDetails->lng = $request['lng'];

            $OfferDetails->save();

            if ($request->hasFile('logo')) {
                $path = $this->storeFile($request, [
                    'fileUpload' =>'logo',
                    'folder' => Offer::FILE_FOLDER,
                    'recordId' => $OfferDetails->id,
                ]);
                $OfferDetails->Update(['logo' => $path]);
            }
    
            if ($request->hasfile('images')) {
                $images = [];
                foreach ($request->file('images') as $image) {
                    $path = $this->storeFile([], [
                        'fileUpload' => $image,
                        'folder' => Offer::FILE_FOLDER,
                        'recordId' => $OfferDetails->id,
                    ]);
                    $images[] = $path;
                }
                $OfferDetails->Update(['images' => array_merge($OfferDetails->images, $images)]);
            }

            $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
        } else {
            $this->flashAlert(['faild' => ['msg' => __('messages.updated_faild')]]);
        }

        $request->flash();
        return back();
    }

    public function delete(Request $request)
    {

        if (Offer::find($request->route('id'))->delete()) {
            return response()->json(['success' => __('messages.deleted')]);
        } else {
            return response()->json(['error' => __('messages.deleted_faild')]);
        }
    }
     public function delete_details(Request $request)
    {

        if (OfferDetails::find($request->route('id'))->delete()) {
            return response()->json(['success' => __('messages.deleted')]);
        } else {
            return response()->json(['error' => __('messages.deleted_faild')]);
        }
    }

    public function delete_image(Request $request)
    {

        $id = $request->route('id');
        $index = $request->route('index');
        $offer = Offer::find($id);
        $images = $offer->images;
        unset($images[$index]);
        $images = array_merge([], $images);

        if ($offer->update(['images' => $images])) {
            $this->flashAlert(['success' => ['msg' => __('messages.deleted')]]);
            $request->flash();
            return back();
        } else {
            $this->flashAlert(['faild' => ['msg' => __('messages.deleted_faild')]]);
            $request->flash();
            return back();
        }
    } 
    
    public function delete_image_details(Request $request)
    {

        $id = $request->route('id');
        $index = $request->route('index');
        $OfferDetails = OfferDetails::find($id);
        $images = $OfferDetails->images;
        unset($images[$index]);
        $images = array_merge([], $images);

        if ($OfferDetails->update(['images' => $images])) {
            $this->flashAlert(['success' => ['msg' => __('messages.deleted')]]);
            $request->flash();
            return back();
        } else {
            $this->flashAlert(['faild' => ['msg' => __('messages.deleted_faild')]]);
            $request->flash();
            return back();
        }
    }

}
