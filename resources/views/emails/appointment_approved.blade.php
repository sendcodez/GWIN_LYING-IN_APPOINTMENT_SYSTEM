@component('mail::message')

# Appointment Approved

Your appointment has been approved. Here are the details:

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

Thank you for choosing us.

@component('mail::button', ['url' => route('index')])
Visit Us!
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@endcomponent
