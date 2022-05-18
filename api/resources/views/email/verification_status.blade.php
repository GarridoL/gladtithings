@component('email.header')
@endcomponent
<span class="text">
    <h3>Verification Status</h3>
    Hello {{$user->username}}!
    <br>
    <br>
    @if(str_contains($details, 'blocked'))
        Sorry, {{$details}}
    @else
        Congratulations, {{$details}}
    @endif
    <br>
    <!-- Click the button below to apply:
    <br>
    <a href="https://calendly.com/payhiramph/videocallverification">
        <button class="button">Apply</button>
    </a> -->
    <br>
</span>
<!-- <span class="text" style="text-align: center;">
    If you did not make this change, please <a href="{{env('APP_FRONT_END_URL')}}/reset_password/{{$user->username}}/{{$user->code}}">reset</a> your password to secure your account. This is a system-generated email. Please do not reply.
</span> -->
@component('email.footer')
@endcomponent
