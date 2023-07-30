{{-- <div id="token"></div>
<div id="msg"></div>
<div id="notis"></div>
<div id="err"></div>
<script src="https://www.gstatic.com/firebasejs/7.16.0/firebase.js"></script>

<script>
    MsgElem = document.getElementById("msg")
     TokenElem = document.getElementById("token")
     NotisElem = document.getElementById("notis")
     ErrElem = document.getElementById("err")

      //Initialize Firebase
    //  TODO: Replace with your project's customized code snippet
      var config = {
      //     apiKey: "AIzaSyBiY_gJOFkCu2S9gbRyzdzf3KohWRVhweA",
      //     authDomain: "captainsaudi-3e143.firebaseapp.com", 
      //     databaseURL: "https://captainsaudi-3e143.firebaseio.com",
      //     projectId: "captainsaudi-3e143",
      //     storageBucket: "captainsaudi-3e143.appspot.com", 
      //     messagingSenderId: "278553689172",
      //     appId:"1:278553689172:android:a1abf95ecade8d0ff5c1c1",
      apiKey: "AIzaSyC2aIxAKyOSR9dB-mXOCcFH7xm9KeqMM9k",
    authDomain: "souq-pay.firebaseapp.com",
    projectId: "souq-pay",
    storageBucket: "souq-pay.appspot.com",
    messagingSenderId: "211654535220",
    appId: "1:211654535220:web:ea9dad811fd0f64e52c261",
    measurementId: "G-E2BQFJ43NE"
      };
     firebase.initializeApp(config);

      const messaging = firebase.messaging();
      

      messaging
          .requestPermission()
          .then(function () {
              // MsgElem.innerHTML = "Notification permission granted."
              console.log("Notification permission granted.");

              // get the token in the form of promise
              return messaging.getToken()
          })
          .then(function(token) {
              // TokenElem.innerHTML = "token is : " + token
              saveFcmToken(token);
              console.log( "token is : " + token  );
          })
          .catch(function (err) {
              // ErrElem.innerHTML =  ErrElem.innerHTML + "; " + err
              console.log("Unable to get permission to notify.", err);
          });



          console.log("Before Message. ");
          messaging.onMessage(function(payload) {
            counter = document.getElementById('notifications_counter');
          menu = document.getElementById('mnu_notifications');
          data = payload;
          fillMenu( counter , menu , data );

         console.log("Message received. ");
   
      });

</script> --}}



<div id="token"></div>
<div id="msg"></div>
<div id="notis"></div>
<div id="err"></div>
{{-- <script src="https://www.gstatic.com/firebasejs/8.0.1/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.1/firebase-messaging.js"></script> --}}

<script>
   
  

  counter = document.getElementById('notifications_counter');
  menu = document.getElementById('mnu_notifications');
  bell = document.getElementById('notifications_bell');
  last_notification_id={{optional(\App\Models\Notification::where(['user_reciever_id'=>0,'read_at'=>null])->orderBy('id','desc')->first())->id ?? 0 }};

  MsgElem = document.getElementById("msg")
  TokenElem = document.getElementById("token")
  NotisElem = document.getElementById("notis")
  ErrElem = document.getElementById("err")

      // Initialize Firebase
      // TODO: Replace with your project's customized code snippet
  //     var config = {
  //        apiKey: "AIzaSyBiY_gJOFkCu2S9gbRyzdzf3KohWRVhweA",
  //         authDomain: "captainsaudi-3e143.firebaseapp.com", 
  //         databaseURL: "https://captainsaudi-3e143.firebaseio.com",
  //         projectId: "captainsaudi-3e143",
  //         storageBucket: "captainsaudi-3e143.appspot.com", 
  //         messagingSenderId: "278553689172",
  //         appId:"1:278553689172:android:a1abf95ecade8d0ff5c1c1",
  //     };

     
  //    firebase.initializeApp(config);

  

  //   const messaging = firebase.messaging();
     
  //   messaging
  //     .requestPermission()
  //     .then(function () {
  //         // MsgElem.innerHTML = "Notification permission granted."
  //         // console.log("Notification permission granted.");

  //         // get the token in the form of promise
  //         return messaging.getToken();
  //     })
  //     .then(function(token) {
  //         // TokenElem.innerHTML = "token is : " + token
  //         saveFcmToken(token);
  //         console.log( "token is : " + token  );
  //     })
  //     .catch(function (err) {
  //         // ErrElem.innerHTML =  ErrElem.innerHTML + "; " + err
  //         // console.log("Unable to get permission to notify.", err);
  //     });

  //     messaging.onMessage(function(payload) {
  //       //console.log("Message received. ", JSON.stringify(payload));
      
  //     data = payload;
  //     fillMenu( counter , menu , data );

  // });

  //     messaging.onTokenRefresh(function () {
  //       messaging.getToken()
  //         .then( function (newtoken) {
  //           saveFcmToken(newtoken);
  //           // console.log("New token : " + newtoken );
  //         })
  //         .catch(function (reason) {
  //           // console.log(reason);
  //         })
  //     });

</script>

<script>
//     function saveFcmToken(token)
// {

//    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
//    // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
//    $.ajax({
//       type: 'post',
//       url: "{{ route('admin.users.fcm_web')}}",
//       data: { 'token' : token },
//       success: function (data) {
//           // console.log(data);
//       },
//       error: function (xhr, status, error)
//       {
//           // if (xhr.status == 419) // httpexeption login expired or user loged out from another tab
//           // {window.location.replace( '{{ route("admin.home") }}' );}
//           console.log(xhr.responseText);
//       },
//     });
// }

function fillMenu(counter,menu,data,last_id)
{


     data.data.forEach( function(element){
      counter.innerHTML = parseInt( (counter.innerHTML) || 0 ) + 1 ;
     // console.log(element);

    message = `<a class="kt-notification__item" href="` +  element.link + `">` +
      `<div class="kt-notification__item-details">` +
        `<div class="kt-notification__item-title">` +
          element.data+
        `</div>`+
        // `<div class="kt-notification__item-time">` +
        //   `2 hrs ago` +
        // `</div>` +
      `</div>` +
      `</a>`;

   //    console.log(message);
    menu.innerHTML = message+ menu.innerHTML;
    last_notification_id = element.id;

    //console.log('in minu : ' + last_notification_id);
         
    bell.style.color='red';
    counter.style.color='red';
        });

   


    
}




    // $( window ).load(function() {
    //   notifyMe();
    // });

$(document).ready(function() {

 // notifyMe();
$("#clear_notification" ).click(function() {
  
  counter.innerHTML = 0;
    bell.style.color='gray';
    counter.style.color='gray';
   // notifyMe();

   $.ajax({
      type: 'get',
      url: "{{ route('admin.users.notification_readed')}}",
      success: function (data) {

      },
     
    });

});


setInterval( () =>{
 // console.log(last_notification_id);
  $.ajax({
      type: 'get',
      url: "{{ url('api/v1/getAdminNewNotifications')}}"+'/'+last_notification_id,
      success: function (data) {
        fillMenu( counter , menu , data ,last_notification_id);

      },
     
    });
}, 3000);




});


// function notifyMe() {

//     if (Notification.permission !== "granted"){
//       alert('PLease Allow Use Notification ');
//     Notification.requestPermission().then(function(permission) { 
//       console.log('After Request : '+permission);
//     if(permission === 'granted'){
//       messaging
//           .requestPermission()
//           .then(function () {
//               // MsgElem.innerHTML = "Notification permission granted."
//               // console.log("Notification permission granted.");

//               // get the token in the form of promise
//               return messaging.getToken();
//           })
//           .then(function(token) {
//               // TokenElem.innerHTML = "token is : " + token
//               saveFcmToken(token);
//               console.log( "token is : " + token  );
//           })
//           .catch(function (err) {
//               // ErrElem.innerHTML =  ErrElem.innerHTML + "; " + err
//               // console.log("Unable to get permission to notify.", err);
//           });
//         }

//         });

//     }

// }

// request permission on page load
document.addEventListener('DOMContentLoaded', function () {

});

</script>
