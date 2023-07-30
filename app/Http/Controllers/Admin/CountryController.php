<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\UtilHelper;
use App\Http\Controllers\AdminController;
use App\Models\Country;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends AdminController
{

    private $countryServ;

    public function __construct(CountryService $countryService)
    {

        $this->countryServ = $countryService;

        $this->share([
            'page' => Country::PAGE,
            'recordsCount' => Country::where('parent_id','!=',0)->count(),
        ]);

        $this->defaultLanguage = $this->defaultLanguage();

    }

    public function index(Request $request)
    {

        $trans = $this->defaultLanguage->locale;
        if ($request->isMethod('post')) {
            $trans = $request->trans;
        }
          $countries = $this->countryServ->getAll($trans);
        $temp = [];
          $countries = UtilHelper::buildTreeRoot($countries, null, $temp, 1, 0);
        return view('admin.countries.index', compact(['countries', 'trans']));
    }

    public function create()
    {
        $trans = $this->defaultLanguage->locale;
        $countries = $this->countryServ->getAll();
        $temp = [];
        $countries = UtilHelper::buildTreeRoot($countries, null, $temp, 1, 0);
        return view('admin.countries.create', compact(['countries', 'trans']));
    }

    public function store(Request $request)
    {

        $validate = $request->validate([
            'language' => 'required|string|exists:languages,locale',
            'title' => 'required|max:100',
            'parent_id' => 'required|integer',
        ]);

        // check country_id in countries table
        if ($request->parent_id != 0) {
            $chkCountry = Country::where('id', $request->parent_id)->exists();
            if (!$chkCountry) {
                return back()->withinput()->withErrors(['title' => __('messages.error_data')]);
            }
        }

        $chkTitle = Country::where('title->' . $request->language, $request->title)->exists();
        if ($chkTitle) {
            return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language')]);
        }

        $active = 1;
        // check if parent is category not service and if parent is inactive
        if ($request->parent_id != 0) {
            $parent = Country::where('id', $request->parent_id)->select('is_active')->firstOrFail();
            if ($parent->is_active == 0) {
                $active = 0;
            }
        }

        $country = $this->countryServ->store($request->all());
        return redirect(route('admin.countries.index'));

    }

    public function edit(Request $request)
    {

        $trans = $this->defaultLanguage->locale;
        if ($request->isMethod('post')) {
            $trans = $request->trans;
        }

        $data = Country::select('countries.id', 'countries.parent_id', 'countries.is_active', "countries.title")
            ->where('id', $request->id)->firstorfail();

        $countries = $this->countryServ->getAll();
        $temp = [];
        $countries = UtilHelper::buildTreeRoot($countries, $request->id, $temp, 1, 0);
        return view('admin.countries.edit', compact(['countries', 'trans', 'data']));

    }

    public function update(Request $request)
    {

        $validate = $request->validate([
            'language' => 'required|string|exists:languages,locale',
            'title' => 'required|max:100',
            'parent_id' => 'required|integer',
        ]);

        // check country_id in countries table
        if ($request->parent_id != 0) {
            $chkCountry = Country::where('id', $request->parent_id)->exists();
            if (!$chkCountry) {
                return back()->withinput()->withErrors(['title' => __('messages.error_data')]);
            }
        }

        // check title,language doublicate in info table
        $chkTitle = Country::where('title->' . $request->language, $request->title)->where('id', '!=', $request->id)->exists();
        if ($chkTitle) {
            return back()->withinput()->withErrors(['title' => __('messages.duplicate_title_language')]);
        }

        $active = 1;
        // check if parent is category not service and if parent is inactive
        if ($request->parent_id != 0) {
            $parent = Country::where('id', $request->parent_id)->select('is_active')->firstOrFail();
            if ($parent->is_active == 0) {
                $active = 0;
            }
        }

        $country = $this->countryServ->update($request, Country::find($request->id));
        return redirect(route('admin.countries.index'));

    }

    public function setActive(Request $request)
    {

        $country = Country::findOrFail($request->id);
        $status = !$country->is_active;

        // if we try to active a category so check the parent of it if the parent is inactive then make it active
        if ($status == 1) {
            $parent = Country::where(['id' => $country->parent_id, 'is_active' => 0])->first();
            if ($parent) {
                $this->flashAlert(['faild' => ['msg' => __('category.activate_parent') . ' - ' . $parent->translation->first()->title]]);
                return back();
            }
        }

        $this->countryServ->setActive($country, $status);
        $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
        return back();

    }


    public function delete(Request $request){

        $id = $request->route('id');
        $country = Country::with('childrenRecursive')->find($id);
        if (!$country ) {
            return response()->json(['error' => __('messages.deleted_faild')]);
        }


        $array_of_ids = $this->getChildren($country);
        array_push($array_of_ids, $id);
        Country::destroy($array_of_ids);
        
        return  response()->json(['success' => __('messages.deleted')]);

    }


    private function getChildren($country){
        $ids = [];
        foreach ($country->childrenRecursive as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getChildren($child));
        }
        return $ids;
    }


}
