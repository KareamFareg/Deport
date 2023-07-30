<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Auth;
class FirebaseController extends AdminController
{

    public function getChat($id, Request $request)
    {

        $request->merge(['id' => $request->route('id')]);
        $validate = $request->validate([
            'id' => 'required|integer|exists:orders,id',
        ], [], ['id' => 'رقم الطلب']);

        $order = Order::with([
            'user_data:id,name,phone',
            'shipper_data:id,name,phone',

            'category.translation:id,category_id,title',
        ])
            ->where('id', $request->route('id'))
            ->first();

        // check chat belongs to current client
        // if (Auth::user()->isClient()) {
        //   if ($order->user_id_shop != app('mainClient')->id) {
        //     $this->flashAlert([
        //       'faild' => ['msg'=> __('auth.unauthorized')]
        //     ]);
        //     return redirect(route('admin.home'));
        //   }
        // }

        $serviceAccount = ServiceAccount::fromJsonFile(base_path() . '/kafoo-2a7a1-firebase-adminsdk-ht8n2-120c062d88.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://kafoo-2a7a1-default-rtdb.firebaseio.com/')
            ->create();

        $database = $firebase->getDatabase();

        $items = $database->getReference('Chat/' . $request->id);

        $items = $items->getvalue();

        //dd($items);

        // message , receiverId , senderId , type
        $chaters_ids = ['receiver_id' => '', 'sender_id' => ''];
        $chaters = ['receiver_name' => '', 'sender_name' => ''];
        if (!empty($items)) {
            $first = 0;
            foreach ($items as $item) {
                if ($first < 1) {
                    $chaters['receiver_name'] = optional(User::where('id', $item['receiverId'])->select('id', 'name')->first())->name ?? __('words.deleted');
                    $chaters['sender_name'] = optional(User::where('id', $item['senderId'])->select('id', 'name')->first())->name ?? __('words.deleted');
                    $chaters_ids['receiver_id'] = $item['receiverId'];
                    $chaters_ids['sender_id'] = $item['senderId'];
                } else {
                    break;
                }
                $first = $first + 1;
            }
        }

        return view('util.chat-main', compact(['order', 'items', 'chaters', 'chaters_ids']));

    }

    public function getAdminChat($id, Request $request)
    {

        $request->merge(['id' => $request->route('id')]);
        // $validate = $request->validate([
        //     'id' => 'required|integer|exists:users,id',
        // ], [], ['id' => 'المستخدم']);

        $user = User::where('id', $request->id)->first();


        $serviceAccount = ServiceAccount::fromJsonFile(base_path() . '/kafoo-2a7a1-firebase-adminsdk-ht8n2-120c062d88.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://kafoo-2a7a1-default-rtdb.firebaseio.com/')
            ->create();

        $database = $firebase->getDatabase();

        $items = $database->getReference('AdminChat/' . $request->id);

        $items = $items->getvalue();

        return view('util.chat-users-admin', compact(['user', 'items']));

    }

    public function messages(Request $request)
    {
        $request->merge(['id' => Auth::id()]);
        $user = User::where('id', $request->id)->first();

        $serviceAccount = ServiceAccount::fromJsonFile(base_path() . '/kafoo-2a7a1-firebase-adminsdk-ht8n2-120c062d88.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://kafoo-2a7a1-default-rtdb.firebaseio.com/')
            ->create();

        $database = $firebase->getDatabase();

        $items = $database->getReference('AdminChat/'. $request->id);


        $items = $items->getvalue();

        $usersIds = [];
        if ($items) {
        foreach ($items as $user => $item) {
              $usersIds[] = $user;
          }
        }
       $users=User::whereIn('id',$usersIds)->get();

        $data['users']=$users;
        return view('admin.messages.index', $data);

    }

    public function user($id, Request $request)
    {

        $request->merge(['id' => $request->route('id')]);
        // $validate = $request->validate([
        //     'id' => 'required|integer|exists:users,id',
        // ], [], ['id' => 'المستخدم']);

        $user = User::where('id', $request->id)->first();


        $serviceAccount = ServiceAccount::fromJsonFile(base_path() . '/kafoo-2a7a1-firebase-adminsdk-ht8n2-120c062d88.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://kafoo-2a7a1-default-rtdb.firebaseio.com/')
            ->create();

        $database = $firebase->getDatabase();

        $items = $database->getReference('AdminChat/' . $request->id);

        $items = $items->getvalue();

        return view('util.chat-users-admin', compact(['user', 'items']));

    }

}
