@foreach(array_chunk($userImages->all(),2) as $doubleImage)
<ul class="list-unstyled no-margin row">
  @foreach($doubleImage as $image)

  <li class="col-6 col-padding-5">
    <div class="card">
      <img src="{{ asset('storage/app/'.$image->file_name) }}" class="card-img" alt="img" onclick="enlarge(this)">
      <div class="card-img-overlay">
        @if($auth == true)
          <!-- <button class="btn btn-secondary"><i class="fas fa-edit"></i></button> -->
           <form  method="post" onsubmit="showConfirmation(event,this)" action="{{ route('front.items.destroy_file' , [ 'id' => $image->table_id , 'file_id' => $image->id ] ) }}" class="form-inline">
              {{ csrf_field() }}
              <input name="_method" type="hidden" value="DELETE">
              <input type="hidden" name="redir"  id="redir" value="redir">
              <button type="submit" class="btn btn-secondary"><i class="fas fa-trash-alt"></i></button>
          </form>

        @endif
      </div>
    </div>
  </li>
  @endforeach
</ul>
@endforeach
