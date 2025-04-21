@component('mail::message')
# Interview Invitation

Dear {{ $interview->user->name }},

You have been invited to an interview for the position of **{{ $interview->job->title }}** at **{{ $interview->job->company->name }}**.

**Interview Details:**
- **Date:** {{ $interview->scheduled_at->format('l, F j, Y') }}
- **Time:** {{ $interview->scheduled_at->format('h:i A') }}
- **Duration:** {{ $interview->duration_minutes }} minutes
- **Type:** {{ ucfirst($interview->interview_type) }}

@if($interview->interview_type == 'in-person')
**Location:**
{{ $interview->location }}
@elseif($interview->interview_type == 'video')
**Meeting Link:**
{{ $interview->meeting_link }}
@else
**You will receive a phone call at the scheduled time.**
@endif

@if($interview->notes)
**Additional Notes:**
{{ $interview->notes }}
@endif

Please confirm your attendance by clicking the button below:

@component('mail::button', ['url' => route('candidate.interviews')])
Confirm Attendance
@endcomponent

If you need to reschedule, please log in to your dashboard and request a reschedule.

Best regards,<br>
{{ $interview->job->company->name }} Team<br>
{{ config('app.name') }}
@endcomponent