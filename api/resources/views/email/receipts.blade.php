@component('email.header')
@endcomponent
<span class="holder">
    <!-- <span class="thank-you-header">
        <h1 style="line-height: 125px;">Receipt of Transaction</h1>
        <label>{{$user['email']}}</label>
    </span> -->
    <br>
    <div class="thank-you-item2">
        <label>&nbsp;</label>
        <label><b>Date</b></label>
        <label>{{$dataReceipt['date']}}</label>
        <label>&nbsp;</label>
    </div>
    <div class="thank-you-item2">
        <label>&nbsp;</label>
        <label><b>Church Name</b></label>
        <label>{{$dataReceipt['title']}}</label>
        <label>&nbsp;</label>
    </div>
    <div class="thank-you-item2">
        <label>&nbsp;</label>
        <label><b>Total Amount</b></label>
        <label>PHP {{$dataReceipt['amount']}}</label>
        <label>&nbsp;</label>
    </div>
    <div class="thank-you-item2">
        <label>&nbsp;</label>
        <label><b>Payment Method</b></label>
        @if($dataReceipt['method']['stripe'] != null)
          <label>
              <i class="fa fa-credit-card"></i>
              ********{{$dataReceipt['method']['stripe']['last4']}}
          </label>
        @elseif($dataReceipt['method']['paypal'] != null)
          <label>
              <i class="fa fa-paypal"></i> {{$dataReceipt['method']['paypal']['email']}}
          </label>
        @else
          <label>
              No payment method
          </label>
        @endif
    </div>
</span>
@component('email.footer')
@endcomponent


