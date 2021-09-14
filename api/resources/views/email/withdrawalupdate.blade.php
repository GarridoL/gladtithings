@component('email.header')
@endcomponent
<span class="text">
    <br>
    <label>Withdrawal Update</label>
    <br>
    <br>
    Hello, Test!
    <br>
    <br>
    <label>The withdrawal you requested was successfully processed.</label>
    <br>
    <br>
    <label>Amount: {{$amount}}</label>
    <br>
    <label>Date of Request: {{$date}}</label>
    <br>
    <label>Date processed: {{$date}}</label>
    <br>
    <label>Account Balance: {{$balance}}</label>
    <br>
    <br>
    Thank you!
    <br>
    <br>
</span>
@component('email.footer')
@endcomponent