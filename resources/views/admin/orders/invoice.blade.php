<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>{{$data->code}}</title>

  <style>
    .invoice-box {
      /*      max-width: 800px;
     margin: auto;
       padding: 30px;
      border: 1px solid #eee;
    box-shadow:  5px rgba(0, 0, 0, .15); */
      font-size: 16px;
      line-height: 24px;
      font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
      color: #555;
    }

    .invoice-box table {
      width: 100%;
      line-height: inherit;
      text-align: right;
    }

    .invoice-box table td {
      padding: 5px;
      vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
      text-align: right;
    }

    .invoice-box table tr.top table td {
      padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
      font-size: 45px;
      line-height: 45px;
      color: #333;
    }

    .invoice-box table tr.information table td {
      padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
      background: #eee;
      border-bottom: 1px solid #ddd;
      font-weight: bold;
    }

    .invoice-box table tr.details td {
      padding-bottom: 20px;
    }

    .invoice-box table tr.item td {
      border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
      border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
      border-top: 2px solid #eee;
      font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
      .invoice-box table tr.top table td {
        width: 100%;
        display: block;
        text-align: center;
      }

      .invoice-box table tr.information table td {
        width: 100%;
        display: block;
        text-align: center;
      }
    }

    /** RTL **/
    .rtl {
      direction: rtl;
      font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
      text-align: right;
      direction: rtl;
    }

    .rtl table tr td:nth-child(2) {
      text-align: right;
      direction: rtl;
    }
  </style>
</head>

<body class="rtl" style="font-family: XB Riyaz ; ">
  <div class="invoice-box">
    <table class="rtl" cellpadding="0" cellspacing="0">
      <tr class="top">
        <td colspan="2">
          <table>
            <tr>
              <td class="title">
                <img src="{{ $settings['logo'] }}" style="width:100%; max-width:300px;">
              </td>

              <td>
                <ul>
                  <li>{{ __('order.order_id') }}&nbsp;:&nbsp;{{ $data->code }} </li>
                  <li>{{ __('words.date') }}&nbsp;:&nbsp;{{ $data->created_at }} </li>
                  @if($data->status != 1) <li>
                    {{ __('order.accept_date') }}&nbsp;:&nbsp;{{ $data->accept_date }} </li> @endif
                  <li>{{ __('words.order_status') }}&nbsp;:&nbsp;{{ $data->orderStatus() }}
                    @if($data->status == 4) {{$data->delivery_date}} @endif
                    @if($data->status == 5) {{$data->cancel_date}} @endif
                  </li>
                  <li>{{ __('words.type') }}&nbsp;:&nbsp;{{ $data->type_title() }}</li>
                  <li>{{ __('order.paytype') }}&nbsp;:&nbsp;{{ $data->orderPayment() }}</li>

                </ul>
              </td>
            </tr>
          </table>
        </td>
      </tr>

      <tr class="information">
        <td colspan="2">
          <table class="rtl">

            <tr>
              <td>
                <strong>{{ __('order.user') }}</strong><br>
                {{ optional($data->user_data)->name ?? __('words.deleted') }}<br>
                {{ optional($data->user_data)->phone }}<br>
                {{ optional($data->user_data)->email }}<br>
              </td>
              <td>
                <strong>{{ __('order.shipper') }}</strong><br>
                {{ optional($data->shipper_data)->name ?? __('words.deleted')}}<br>
                {{ optional($data->shipper_data)->phone }}<br>
                {{ optional($data->shipper_data)->email }}<br>

              </td>
            </tr>

          </table>

        </td>
      </tr>



      <tr class="heading">
        <td>
          {{ __('words.name') }}
        </td>

        <td>
          {{ __('words.quantity') }}
        </td>
      </tr>


      @foreach ($data->items as $item)
      <tr class="item">
        <td>{{ $item->title }}</td>

        <td>{{ $item-> quantity }}</td>
      </tr>
      @endforeach


      <tr>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
      </tr>




      <tr class="total">
        <td></td>
        <td>
          {{ __('order.total_first') }} : {{ $data->price   }}
        </td>
      </tr>
      <tr class="total">
        <td></td>
        <td>
          {{ __('order.shipping') }} : {{optional($data->offer)->shipping  }}
        </td>
      </tr>
      <tr class="total">
        <td></td>
        <td>
          {{ __('commission.commissions ') }} : {{$data->commission   }}
        </td>
      </tr>
      <tr class="total">
        <td></td>
        <td>
          {{ __('order.discount')  }} : {{floatval($data->discount)  }}
        </td>
      </tr>
      <tr class="total">
        <td></td>
        <td>
          {{ __('order.total') }} : {{ $data->price + optional($data->offer)->shipping - floatval($data->discount)+floatval($data->commission)  }}
        </td>
      </tr>

      <tr>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
      </tr>

      <tr class="details">
        <td><strong>{{ __('order.comment') }}</strong> </td>
        <td>{{ $data->comment }}</td>
      </tr>
      <tr class="details">
        <td><strong>{{ __('order.note') }}</strong></td>
        <td>{{ $data->note }} </td>
      </tr>

    </table>
  </div>


</body>

</html>