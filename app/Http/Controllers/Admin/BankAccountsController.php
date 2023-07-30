<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountsController extends AdminController
{

    public function index()
    {

        $data = BankAccount::get();

        return view('admin.bank_account.index', compact('data'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'national_account_number' => 'required',
        ]);

        BankAccount::create($request->all());

        $this->flashAlert([
            'success' => ['msg' => __('messages.added')],
        ]);

        $request->flash();

        return back();
    }

    public function delete(Request $request)
    {

        if (BankAccount::find($request->route('id'))->delete()) {
            return response()->json(['success' => __('messages.deleted')]);
        } else {
            return response()->json(['error' => __('messages.deleted_faild')]);
        }
    }

    public function update(Request $request)
    {
        if (BankAccount::find($request->route('id'))->update($request->all())) {
            $this->flashAlert(['success' => ['msg' => __('messages.updated')]]);
        } else {
            $this->flashAlert(['faild' => ['msg' => __('messages.updated_faild')]]);
        }

        $request->flash();
        return back();
    }

}
