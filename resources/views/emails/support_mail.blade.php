@component('mail::message')
# <p style="text-align:center; color:#000;">  Support Request </p>

<p> {{ $data['message'] }} </p>
<hr />
Thanks,<br>
{{ $data['name'] }} <br/>
{{ $data['phone'] }} <br/>
{{ $data['email'] }}
@endcomponent
