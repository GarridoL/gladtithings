@component('email.header')
@endcomponent
<span class="text">
    <br>
    <label>Account Verification</label>
    <br>
    <br>
    <label>Hello, {{$user->username}}!</label>
    <br>
    <br>
    <label>Welcome to {{env('APP_NAME')}}!</label>
    <br>
    <br>
    We need to verify your account first for you to be able to continue to the app.
    <br>
    Click the button below to:
    <br>
    <a href="{{env('APP_FRONT_END_URL')}}/login_verification/{{$user->username}}/{{$user->code}}">
        <button class="button">Verify</button>
    </a>
    <br>
</span>
<span class="text">
    If you did not make this change, please <a href="{{env('APP_FRONT_END_URL')}}/reset_password/{{$user->username}}/{{$user->code}}">reset</a> your password to secure your account and reply to this message to notify us.
</span>
@component('email.footer')
@endcomponent