@component('email.header')
@endcomponent
<span class="holder">
    <span class="thank-you-header">
        <h1 style="line-height: 125px;">Receipt of Transaction</h1>
        <label>{{$user->email}}</label>
    </span>
    <span class="thank-you-item">
        <label><b>Date</b></label>
        <label><b>Church Name</b></label>
        <label><b>Total Amount</b></label>
        <label><b>Payment Method</b></label>
        <label><b>Receipt No.</b></label>
    </span>
    <span class="thank-you-item">
        <label>{{$dataReceipt['date']}}</label>
        <label>{{$dataReceipt['title']}}</label>
        <label>PHP {{$dataReceipt['amount']}}</label>
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
        <label>#{{$dataReceipt['receipt_number']}}</label>
    </span>
</span>
@component('email.footer')
@endcomponent


