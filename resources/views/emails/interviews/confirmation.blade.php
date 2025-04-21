@component('mail::message')
# {{ $confirmed ? 'Interview Confirmation' : 'Interview Reschedule Request' }}

Dear {{ $interview->job->company->user->name }},

{{ $confirmed ? 
    'The candidate has confirmed their attendance for the interview.' :
    'The candidate has requested to reschedule the interview.'
}}

**Interview Details:**
- **Candidate:** {{ $interview->user->name }}
- **Position:** {{ $interview->job->title }}
- **Date:** {{ $interview->scheduled_at->format('l, F j, Y') }}
- **Time:** {{ $interview->scheduled_at->format('h:i A') }}

@if(!$confirmed && $interview->notes)
**Reschedule Reason:**
{{ $interview->notes }}
@endif

@component('mail::button', ['url' => route('recruiter.interviews')])
View Interview Details
@endcomponent

Thank you,<br>
{{ config('app.name') }}
@endcomponent