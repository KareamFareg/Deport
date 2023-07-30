<form method="POST" id="frm_share_edit" name="frm_share_edit"
    action="{{ route('items.update' , ['id' => $item->id] ) }}" enctype="multipart/form-data">
    @csrf

    <input name="_method" type="hidden" value="PUT">

    <input type="hidden" value="" id="img_0" name="img_0">
    <input type="hidden" value="" id="img_1" name="img_1">
    <input type="hidden" value="" id="img_2" name="img_2">

  <div class="most-commented">
    <div class="card shadow-sm">
      <div class="card-header">
        <h4> <i class="fas fa-file-alt text-danger"></i> تعديل مشاركة </h4>
      </div>
      <div class="card-body">
        <div class="simple-text bg-light p-3">
          <div class="form-group">
            <textarea name="description" id="description" class="form-control limited" data-mintext="0" data-maxtext="200">{{ old ( 'description' , optional($item->item_info->first())->description ) }}</textarea>
          </div>
        </div>
        <div class="letters">
              <p>الحد الاقصي للحروف <span>200</span></p>
            </div>
      </div>


      <div class="card-body">
        <div class="edit-post">
        <div class="add-link">
    <div class="form-group">
      <label for="">ادخل الرابط</label>
      <input type="text" id="links" name="links" value="{{ old( 'links' , $item->links ) }}" class="form-control">
    </div>
  </div>

        <div class="img-uploader">
    <div class="row">
      <div class="col-4 imgUp">
        <div class="imagePreview"></div>
        <label class="btn btn-primary"> اختر صورة <input type="file" class="uploadFile img" value="اختر صورة" style="width: 0px;height: 0px;overflow: hidden;">
                      </label>
      </div>
      <span class="imgAdd"><i class="fa fa-plus"></i> اضف صورة جديدة</span>
    </div>
      </div>
  </div>
        <div class="contact-us">
          <div class="contact-form">


            @if ($item->type_id == 1)
              <div class="form-group row time">
                <label for="" class="col-sm-4 col-form-label">مدة المشاركة</label>
                <div class="col-sm-7">
                  <select name="adv_period_id" id="adv_period_id" class="form-control">
                    @foreach ($advPeriods as $advPeriod)
                    <option value="{{ $advPeriod->id }}" {{ old('adv_period_id', $item->adv_period_id ) == $advPeriod->id ? 'selected' : '' }} >{{ $advPeriod->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            @endif

              <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">نوع المشاركة</label>
                <div class="col-sm-7">
                  <select name="type_id" id="type_id" class="form-control type">
                    @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ old('types', $item->type_id) == $type->id ? 'selected' : '' }} >{{ $type->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="edit-buttons">
                <div class="row">
                  <div class="col-6">
                    <button  onClick="submitForm();" class="btn btn-block btn-rounded btn-success">حفظ</button>
                  </div>
                  <div class="col-6">
                    <button class="btn btn-block btn-rounded btn-secondary">الغاء</button>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#type_id").change(function(){
        if($(".type").val == "عرض"){
            $(".time").show();
        }else{
            $(".time").hide();
        }
    });
});
function submitForm()
{

  img = $(".imagePreview");
  img_0 = '';
  img_1 = '';
  img_2 = '';
  if(img[0]) { $("#img_0").val( img[0].style.backgroundImage );	}
  if(img[1]) { $("#img_1").val( img[1].style.backgroundImage );	}
  if(img[2]) { $("#img_2").val( img[2].style.backgroundImage );	}

  $('#frm_share').submit();

}
</script>
