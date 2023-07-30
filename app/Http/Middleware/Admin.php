<?php

namespace App\Http\Middleware;

use App\Traits\Roles;
use Closure;
use Illuminate\Support\Facades\View;

class Admin
{
    use Roles;

    public function handle($request, Closure $next)
    {

        // Chek if User loged in
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['response' => ['error' => trans('auth.unauthenticated')]], 401);
            } else {
                return redirect()->route('admin.login')->withErrors([trans('auth.unauthenticated')]);
            }
        }

        // Check if User Active
        if (auth()->user()->is_active == 0 || auth()->user()->is_active_admin == 0 ) {
            if ($request->expectsJson()) {
                auth()->logout();
                return response()->json(['response' => ['error' => trans('auth.in_active')]], 401);
            } else {
                auth()->logout();
                return redirect()->route('admin.login')->withErrors([trans('auth.in_active')]);
            }
        }

        // Check if User Verified
        if (auth()->user()->isVerified(0)) {
            $verificationServ = new \App\Services\VerificationService();
            $verificationServ->createVerification(auth()->id());
            return redirect()->route('admin.verifications.show');
        }

        // get current rol or set default and share it
        $currentRole = $this->_getCurrentRole();

        // check privilege
        $userRole = \App\Models\Role::findOrFail($currentRole->id);
        $hasPrivilege = $userRole->hasPrivilege(request()->route()->getName());
        if ($hasPrivilege == false) {
            // if in any page of admin (like roles) and cahnged account to supervisore then the currnt page is roles which is not in supervisor roles
            session()->flash('flashAlerts', ['faild' => ['msg' => __('auth.unauthorized')]]);
          //  session()->flash('flashAlerts', ['faild' => ['msg' => request()->route()->getName()]]);
          //return '00000'; 
          return redirect()->route('admin.home');
            // auth()->logout();
            // return redirect()->route('front.login')->withErrors([trans('auth.unauthorized')]);
        }

        // share menu_1
        $menu_1 = \App\Models\Privileg::wherein('id', $userRole->menu_1)->Active(1)->select('id', 'title', 'parent_id', 'route', 'route_parameters', 'privileg')->orderBy('sort')->get();
        $menu_1 = \App\Helpers\UtilHelper::buildTree($menu_1);
        View::share('menu_1', $menu_1);

        // share user roles
        app()->singleton('userRoles', function () {
            return auth()->user()->roles()->get();
        });

        $request->request->add(['department_id' => 1]);

        return $next($request);

    }
}
