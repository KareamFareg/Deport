<div class="notifications">

  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span id="notify" class="badge">{{ count($userNotifications) }}</span> <i class="far fa-bell"></i>
    </button>
    <div id="notify_messages" class="dropdown-menu notifications-menu animate slideIn" aria-labelledby="dropdownMenuButton2">

      @foreach ($userNotifications as $userNotification)

        <a class="dropdown-item"  href="{{ route( 'items.show' , [ 'id' => $userNotification->table_id ] ) }}" onclick="notificationReaded( event , {{ $userNotification->id }} );">
          <div class="media">
            <!-- <img src="assets/images/user_photo.png" alt="" class="ml-2"> -->
            <div class="media-body">
              <p class="text-dark">{{ $userNotification->data }} . {{ $userNotification->created_at }} </p>
            </div>
          </div>
        </a>
      @endforeach


    </div>
  </div>


</div>
<div class="likes">
  <a href="{{ route('user.likes' , [ 'id' => request()->user()->id ] ) }}" class="btn btn-secondary">
     <span id="notify_likes" class="badge">{{ $userLikesCount }}</span> <i class="far fa-heart"></i>
  </a>
</div>
