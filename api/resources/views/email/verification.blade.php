@component('email.header')
@endcomponent
<span class="text">
    <br>
    <label>Email Verification</label>
    <br>
    <br>
    <label>Hello, {{$user->username}}!</label>
    <br>
    <br>
    <label>Welcome to {{env('APP_NAME')}}!</label>
    <br>
    <br>
    We just need to verify that {{$user->email}} is your email address.
    <br>
    <br>
    Click the button below to:
    <br>
    <a href="{{env('APP_FRONT_END_URL')}}/login_verification/{{$user->username}}/{{$user->code}}">
        <button class="button">Confirm</button>
    </a>
    <br>
</span>
<span class="text">
    If you did not make this change, please <a href="{{env('APP_FRONT_END_URL')}}/reset_password/{{$user->username}}/{{$user->code}}">reset</a> your password to secure your account and reply to this message to notify us.
</span>
@component('email.footer')
@endcomponent