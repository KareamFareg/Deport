<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Helpers\UtilHelper;
use App\Models\Subscription;

class SubscriptionService
{

    public function getBySubscriptionCode($code)
    {
         return Subscription::with('subscriptionPackage')->where([ 'code' => $code ])->first();
    }
    
    public function validateSubscription($subscription)
    {

        // package in active
        if ($subscription->subscriptionPackage->isActive(0)) {
          return trans('subscription_package.package_in_active');
        }

        // subscription in active
        if ($subscription->isActive(0)) {
          return trans('subscription.in_active');
        }

        // subscription already activated before
        if ($subscription->isActivated(1)) {
          return trans('subscription.already_activated');
        }

        return true;

    }

    public function activateSubscription($subscription,$user_id)
    {
      $subscription->update([
        'user_id' => $user_id ,
        'is_activated' => 1 ,
        'activated_date' => UtilHelper::DateToDb(UtilHelper::currentDate()),
        'ip_activated' => UtilHelper::getUserIp() ]);

        return true;
    }

    public function activateSubscriptionAll($subscription,$userId)
    {

      // validate
      $validateSubscription = $this->validateSubscription($subscription);
      if ($validateSubscription !== true) {
        return $validateSubscription;
      }

      // passed --------
      $this->activateSubscription($subscription, $userId);

      return true;

    }





}
