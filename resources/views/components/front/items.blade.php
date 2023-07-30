@foreach ($data->all() as $item)
  <x-front.item :item="$item"/>
@endforeach
