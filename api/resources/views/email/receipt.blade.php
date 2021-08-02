@component('email.header')
@endcomponent
<span>
    <p>Hi, <span style="font-weight: bold;">{{$data['reservee']}}</span></p>
    <br>
    <!-- <br> -->
    <p>Your reservation at <span style="font-weight: bold;">{{$data['merchant']}}</span> has been <span style="font-weight: bold;">{{$data['status']}}</span>.</p>
    <br>
    <p>Reservee: <b>{{$data['reservee']}}</b> </p>
    <p>Date of Reservation: <b>{{$data['date']}}</b></p>
    <p>No. of Guest: <b>{{$data['number_of_guests']}}</b></p>
    <p>Status: <b>{{$data['status']}}</b></p>
    <p>Restaurant Name: <b>{{$data['merchant']}}</b></p>
    <p>Code: <b>{{$data['code']}}</b></p>
    <br>
    <span>Present above information to verify or as your proof of transaction.</span>
    <br>
    <span><b>Thank you.</b></span>
</span>
@component('email.footer')
@endcomponent