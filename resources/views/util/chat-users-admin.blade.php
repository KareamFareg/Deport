@extends('admin.layouts.master')

@section('content')


<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

  <!-- begin:: Content -->
  <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

    <!--Begin::App-->
    <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

      <!--Begin:: App Aside Mobile Toggle-->
      <button class="kt-app__aside-close" id="kt_chat_aside_close">
        <i class="la la-close"></i>
      </button>

      <!--End:: App Aside Mobile Toggle-->


      <!--Begin:: App Content-->
      <div class="kt-grid__item kt-grid__item--fluid kt-app__content" id="kt_chat_content">
        <div class="kt-chat">
          <div class="kt-portlet kt-portlet--head-lg kt-portlet--last">
            <div class="kt-portlet__head">
              <div class="kt-chat__head ">

                <div class="kt-chat__left">

                </div>


                <div class="kt-chat__center">
                  <div class="kt-chat__label">
                    <a class="kt-chat__title">{{ __('words.chat') }} </a>
                    <span class="kt-chat__status">
                      <span class="kt-badge kt-badge--dot kt-badge--success"></span>
                      {{ optional($user)->name }}
                    </span>
                  </div>

                </div>


                <div class="kt-chat__right">

                </div>

              </div>
            </div>
            <div class="kt-portlet__body">
              <div class="kt-scroll kt-scroll--pull" data-mobile-height="300">
                <div  style="overflow-y: scroll; height:400px;" id="chatDiv" class="kt-chat__messages">
                  @if(!empty($items))
                  @foreach($items as $key => $item)

                  @if ( $item['senderId'] == optional($user)->id )
                  <div class="kt-chat__message">
                    <div class="kt-chat__user">

                      <a class="kt-chat__username"><span>{{ optional($user)->name }}</span></a>
                      <span class="kt-chat__datetime">{{ isset($item['time']) ? $item['time'] : '' }}</span>
                    </div>
                    <div class="kt-chat__text kt-bg-light-success">
                      @if ($item['type'] == 'text')
                      <x-chat.string :text="$item['message']" /> @endif
                      @if ($item['type'] == 'audio')
                      <x-chat.audio :file="$item['message']" /> @endif
                      @if ($item['type'] == 'image')
                      <x-chat.image :key="$key" :file="$item['message']" /> @endif
                      @if ($item['type'] == 'location')
                      @php $lat = explode(',', $item['message'] )[0]; @endphp
                      @php $lng = explode(',', $item['message'] )[1]; @endphp
                      <div id="map_recev_{{ $key }}" class="map" latlng="{{$item['message']}}" lat="{{ $lat }}"
                        lng="{{ $lng }}" style="width:500px; height:500px"></div>
                      @endif
                    </div>
                  </div>
                  @else
                  <div class="kt-chat__message kt-chat__message--right">
                    <div class="kt-chat__user">

                      <a class="kt-chat__username"><span></span></a>
                      <span class="kt-chat__datetime">{{ isset($item['time']) ? $item['time'] : '' }}</span>
                    </div>
                    <div class="kt-chat__text kt-bg-light-success">
                      @if ($item['type'] == 'text')
                      <x-chat.string :text="$item['message']" /> @endif
                      @if ($item['type'] == 'audio')
                      <x-chat.audio :file="$item['message']" /> @endif
                      @if ($item['type'] == 'image')
                      <x-chat.image :key="$key" :file="$item['message']" /> @endif
                      @if ($item['type'] == 'location')
                      @php $lat = explode(',', $item['message'] )[0]; @endphp
                      @php $lng = explode(',', $item['message'] )[1]; @endphp
                      <div id="map_recev_{{ $key }}" class="map" latlng="{{$item['message']}}" lat="{{ $lat }}"
                        lng="{{ $lng }}" style="width:500px; height:500px"></div>
                      @endif
                    </div>
                  </div>
                  @endif

                  @php $curuser = $item['receiverId']; @endphp

                  @endforeach
                  @endif


                </div>
              </div>
            </div>
            <div class="kt-portlet__foot">
              <div class="kt-chat__input">
                <div class="kt-chat__editor">
                  <textarea id="text" style="height: 50px" placeholder="Type here..."></textarea>
                </div>
                <div class="kt-chat__toolbar">
                  <div class="kt_chat__tools">
                    <a>
                      <label for="fileButton" > <input type="file" style="display: none" id="fileButton" accept="image/*" value="upload" /> <i class="flaticon2-photograph"></i></label>
                    </a> 
                    
                    <a data-toggle="modal"
                    data-target="#location">
                      <i class="flaticon2-map"></i>
                    </a>

           
                  <!--begin:: Edit Modal-->
                  <div class="modal fade" id="location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <!-- form -->
                        <div class="modal-content">
      
                          <div class="modal-body">
                            <div class=" form-group">
                             
                              <div id="map" style="width: 100%;height: 500px;"></div>



                            @php $lat = $settings['lat'] @endphp
                            <input type="hidden" name="lat" id="lat" value={{ $lat }}>
                            @php $lng = $settings['lng'] @endphp
                            <input type="hidden" name="lng" id="lng" value={{ $lng }}>
                            </div>
      
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{__('words.cancel')}}</button>
                              <button data-dismiss="modal" class=" btn btn-success " onclick="sendMessage('{{optional($user)->id}}',$('#lat').val()+','+$('#lng').val(),'location')">
                                <i class="fa fa-plus"></i>{{__('words.send')}}
                              </button>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  <!--end::Modal-->  


                    <progress id="uploader" value="0" max="100">0%</progress>
                    {{-- <input type="file" class="form-control" id="fileButton" accept="image/*" value="upload" /> --}}
                  </div>

                  <div class="kt_chat__actions">
                    <button type="button" onclick="sendMessage('{{optional($user)->id}}',$('#text').val(),'text')"
                      class="btn btn-brand btn-md btn-upper btn-bold kt-chat__reply">Send</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!--End:: App Content-->
    </div>

    <!--End::App-->
  </div>

  <!-- end:: Content -->
</div>


{{--    <x-firebase.notify/> --}}


@section('js_pagelevel')
{{-- <x-admin.google-map-multi-js /> --}}
<x-admin.google-map-chat-js />
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVFiE8-BpyH5SbzDRvamysRcf2TkWzQfU&callback=initMap2">
</script>
<script>

var dlat = {{ !empty($lat) ? $lat : 24.720012952625147 }};
    var dlng = {{ !empty($lng) ? $lng : 46.67266803125 }};



    function initMap2() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(dlat, dlng),
          zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow;

        var marker = new google.maps.Marker({
          map: map,
          position: { lat: dlat , lng : dlng},
          draggable : true,
          // label: icon.label
        });
        marker.addListener('click', function() {
          infoWindow.setContent(infowincontent);
          infoWindow.open(map, marker);
        });

        google.maps.event.addListener(marker,'position_changed', function() {
          var lat = marker.getPosition().lat();
          var lng = marker.getPosition().lng();
          document.getElementById("lat").value=lat;
          document.getElementById("lng").value=lng;
        });

    }


</script>
<script src="https://www.gstatic.com/firebasejs/4.6.2/firebase.js"></script>

<script>
  var config = {
        apiKey: "879e57e0187adced867bed96db02c026a5c19922",
        authDomain: "captainsaudi-3e143.firebaseapp.com", 
        databaseURL: "https://captainsaudi-3e143.firebaseio.com",
        storageBucket: "captainsaudi-3e143.appspot.com", 
        messagingSenderId: "9",
    };
     firebase.initializeApp(config);
    

    function sendMessage(userId,message,type){
      var Data = {
          message: message,
          time: "{{date('Y-m-d h:i:s')}}",
          senderId : '0',
          receiverId : userId,
          type : type,
          };
      
      if(message.length > 0){
        var newKey =  firebase.database().ref('AdminChat/').child(userId).push().key;
          var updates = {};
          updates[ newKey] = Data;
          firebase.database().ref('/AdminChat/' +userId).update(updates);
            
            $.ajax({
                type: 'post',
                url: "{{ url('api/v1/notifyChatFromAdmin')}}"+'/'+userId,
                success: function (data) {
                   //  console.log(data);
                },
                error: function (xhr, status, error)
                {
      
                   // console.log(xhr.responseText);
                },
              });
       
      }
      $('#text').val('') ;
      $('#fileButton').val(null);
      $('#uploader').val(0);
    }

    var uploader = document.getElementById('uploader');
    var fileButton =document.getElementById('fileButton');
    fileButton.addEventListener('change', function(e){
    var file = e.target.files[0];
    var storageRef = firebase.storage().ref('Media/'+'{{optional($user)->id}}'+'/'+file.name);
    var task = storageRef.put(file);
    task.on('state_changed', function progress(snapshot) {
      var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
      uploader.value = progress;
    }, function error(err) {
     
      console.log('error');

    },function complete() {
      console.log('complete');
      task.snapshot.ref.getDownloadURL().then(function(downloadURL) {
      console.log('File available at', downloadURL);
      sendMessage('{{optional($user)->id}}',downloadURL,'image')
      });
          

    });
   
  });  




    var starCountRef =  firebase.database().ref('AdminChat/'+'{{ optional($user)->id }}'); 


    starCountRef.on('value', function(data) {
   

      var LastMessageKey=Object.keys(data.val())[Object.keys(data.val()).length-1];
    
      if(LastMessageKey != "{{$key ?? ''}}"){
      var  Message= (data.val()[LastMessageKey]);

      if(Message.senderId == "{{ optional($user)->id }}" ){
        var name = "{{optional(\App\User::where('id', optional($user)->id)->select('id', 'name')->first())->name}} ";
        var position = ' ';

      }else{
      var name = "{{optional(\App\User::where('id', 0)->select('id', 'name')->first())->name}}" ;
        var position = ' kt-chat__message--right';

      }

      var htmlMessage='<div class="kt-chat__message'+ position +' ">';
      htmlMessage+='<div class="kt-chat__user">';
      htmlMessage+='<a class="kt-chat__username"><span>'+name+'</span></a>';
      htmlMessage+='<span class="kt-chat__datetime">'+Message.time+'</span>';
      htmlMessage+=' </div>';
      htmlMessage+='<div class="kt-chat__text kt-bg-light-success">';
      if(Message.type =='text' ){
        htmlMessage+=Message.message;
        
      }else if(Message.type =='audio' ){
        htmlMessage+='<audio controls>';
        htmlMessage+='<source src="'+Message.message+'.ogg" type="audio/ogg">';
        htmlMessage+='<source src="'+Message.message+'.mp3" type="audio/ogg">';
        htmlMessage+='Your browser does not support the audio element.';
        htmlMessage+='</audio>';
        


      }else if(Message.type =='image' ){
        //htmlMessage+='<image src="'+Message.message+'" style="max-width:350px;"/>';

        htmlMessage+='<span class="tooltips" data-toggle="modal" data-target="#image'+LastMessageKey+'" style="  cursor: pointer">';
        htmlMessage+='<img src="'+Message.message+'" style="max-height : 100px" class="  img-responsive img-thumbnail img-rounded">';
        htmlMessage+=' </span>';
        htmlMessage+='<div class="modal  fade" id="image'+LastMessageKey+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"';
        htmlMessage+='aria-hidden="true" style="display: none;">';
        htmlMessage+=' <div class="modal-dialog modal-dialog-centered ">';
        htmlMessage+='<div class="modal-content">';
        htmlMessage+='     <div class="modal-content">';
        htmlMessage+='       <div class="modal-body" style=" text-align: center;">';
        htmlMessage+='       <img style="width : 100% " src="'+Message.message+'" class="  img-responsive ">';
        htmlMessage+='   </div>';
        htmlMessage+='   </div>';
        htmlMessage+=' </div>';
        htmlMessage+=' </div>';
        htmlMessage+=' </div>';


      }else if(Message.type =='location' ){
        htmlMessage+=' <div id="map_recev_'+LastMessageKey+'" class="map" latlng="" lat=""';
        htmlMessage+=' lng="" style="width:500px; height:500px"></div>';
       


      }

      htmlMessage+='</div>';
      htmlMessage+=' </div>';


      var chatDiv = document.getElementById('chatDiv');

       chatDiv.innerHTML += htmlMessage;

       if(Message.type =='location' ){
            var latLng= Message.message.split(',');
            var map = new google.maps.Map(document.getElementById('map_recev_'+LastMessageKey), {
              center: new google.maps.LatLng(latLng[0],latLng[1]),
              zoom: 12
            });
              new google.maps.Marker({
              map: map,
              position: new google.maps.LatLng(latLng[0],latLng[1]),
              title: "source",
              });
          }
           chatDiv.scrollBy(0, 50000000);


       $.ajax({
      type: 'get',
      url: "{{ route('admin.users.notification_readed_by_user_id',['id'=>optional($user)->id ?? 0])}}",
      success: function (data) {
   //   console.log("{{ route('admin.users.notification_readed_by_user_id',['id'=>optional($user)->id ?? 0])}}");
      
      counter.innerHTML = 0;
      bell.style.color='gray';
      counter.style.color='gray';

      },
     
    });
    
    }
      //  updateStarCount(postElement, snapshot.val());

   

    });


</script>
@endsection

@endsection