{{-- <image src="{{ $file }}" style="max-width:350px;"/> --}}
<span class="tooltips" data-toggle="modal" data-target="#image{{ $key }}" style="  cursor: pointer">

    <img src="{{ $file }}" style="max-height : 100px" class="  img-responsive img-thumbnail img-rounded">
</span>

<div class="modal  fade" id="image{{$key}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">

            <div class="modal-content">
                <div class="modal-body" style=" text-align: center;">
                    <img style="width : 100% " src="{{ $file }}" class="  img-responsive ">
                </div>
            </div>


        </div>
    </div>
</div>