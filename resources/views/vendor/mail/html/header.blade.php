@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
<img src="https://jakartatrading.my.id/logo/logo1.png" height="60px" alt="{{ config('app.name') }}">
{{-- @if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
<img src="{{ asset('logo/logo1.png') }}" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif --}}
</a>
</td>
</tr>
