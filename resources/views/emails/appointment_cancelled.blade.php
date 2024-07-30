@component('mail::message')
# Introduction

We sincerely apologize for the inconvenience caused by the cancellation of your appointment.

Here are the details of the cancelled appointment:

- **Doctor Name:** Dr. {{ $appointment->doctor->firstname }} {{ $appointment->doctor->lastname }}
- **Service:**
    @if($appointment->services->isNotEmpty())
        @foreach($appointment->services as $service)
            {{ $service->name }}@if(!$loop->last), @endif
        @endforeach
    @else
        <span style="color:red">Service Not Found</span>
    @endif
- **Date:** {{ $appointment->date }}
- **Time:** {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}

We understand that your time is valuable, and we regret any inconvenience this cancellation may have caused.

If you have any questions or need further assistance, please don't hesitate to contact us.

@component('mail::button', ['url' => route('index')])
Book Again
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
