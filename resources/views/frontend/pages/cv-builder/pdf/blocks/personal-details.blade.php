<tr>
    <td style="text-align: center; font-weight: bold;">
        <span style="font-weight: bold; font-size:14px">{{$cv->first_name}} {{$cv->last_name}}</span><br>
        @if ($cv->address) {{$cv->address}}<br> @endif
        @if ($cv->email) {{$cv->email}}<br> @endif
        @if ($cv->phone) {{$cv->phone}} @endif
    </td>
</tr>
