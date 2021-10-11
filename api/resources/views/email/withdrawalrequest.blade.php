@component('email.header')
@endcomponent
<span class="text">
    <br>
    <label>Withdrawal Request</label>
    <br>
    <br>
    Hello, {{$user->username}}!
    <br>
    <br>
    <label>There is a request of withdrawal from your account.</label>
    <br>
    <br>
    <label>Amount: {{$amount}}</label>
    <br>
    <label>Date of Request: {{$date}}</label>
    <br>
    <br>
    We just need to verify that the said request is from you.
    <br>
    <br>
    Please click the button below to confirm.
    <br>
    <a href="{{env('APP_FRONT_END_URL')}}/withdrawal_request/">
        <button class="button">Confirm</button>
    </a>
    <br>
</span>
<span class="text">
    If you did not make this request, please <a href="{{env('APP_FRONT_END_URL')}}/reset_password/{{$user->username}}/{{$user->code}}">reset</a> your password to secure your account and reply to this message to notify us.
</span>
@component('email.footer')
@endcomponent