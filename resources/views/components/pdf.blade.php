

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="{{asset('assets/admin/css/pdf.css')}}">

</head>
<body  style="font-family: XB Riyaz ;direction:rtl ">
    
<table class="">
    <tr>
        <td>
            <img style="width: 500px !important; height: auto !important;"
                src="{{ asset('storage/app/'.\App\Models\Setting::first()->logo) }}">
        </td>
    </tr>
    <tr>
        <td>
            {!!$data!!}
        </td>
    </tr>
</table>
</body>
</html>