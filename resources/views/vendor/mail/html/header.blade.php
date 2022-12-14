@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'LC-CITADEL')
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
