@component('mail::message')
# Appointment Approved

Your appointment has been approved. Here are the details:

- **Doctor Name:** Dr. {{ $appointment->doctor->firstname }} {{ $appointment->doctor->lastname }}
- **Service:** {{ $appointment->service->name }}
- **Date:** {{ $appointment->date }}
- **Time:** {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}

Thank you for choosing us.

@component('mail::button', ['url' => route('index')])
Visit Us!
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
