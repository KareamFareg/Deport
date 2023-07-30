<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
<script>
  // Enable pusher logging - don't include this in production
  // Pusher.logToConsole = true;

  var pusher = new Pusher('64fdbf3ee47ca9a96f5e', {
    cluster: 'eu'
  });

  var channel = pusher.subscribe('my-channel');
  channel.bind('my-event', function(data) {

    // recive data just for current user
    if ( data.user_id != {{ auth()->id() }} ) {
      return;
    }

    // if notification of type like then increment likes
    // if (data.type == 1){ // like
    //   document.getElementById('notify_likes').innerHTML =parseInt( (document.getElementById('notify_likes').innerHTML) || 0 ) + 1 ;
    // }

    document.getElementById('notify').innerHTML =parseInt( (document.getElementById('notify').innerHTML) || 0 ) + 1 ;
    document.getElementById('notify_m').innerHTML =parseInt( (document.getElementById('notify_m').innerHTML) || 0 ) + 1 ;


    message = `<a class="dropdown-item" href="` + data.link + `">` + `<div class="media">` +
        // <img src="assets/images/user_photo.png" alt="" class="ml-2">
        `<div class="media-body">` +
          `<p class="text-dark">` + data.message + `</p>`+
        `</div>` +
      `</div>` +
    `</a>` ;
    document.getElementById('notify_messages').innerHTML += message;
    // console.log(JSON.stringify(data));



  });
</script>
