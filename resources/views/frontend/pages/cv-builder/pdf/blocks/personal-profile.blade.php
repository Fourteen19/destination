@if ($cv->personal_profile)
    <tr>
        <td>
            <div style="margin-top: 10px">
            <div style="font-weight: bold; margin-bottom: 5px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Personal profile</div>
            <div>{{$cv->personal_profile}}</div>
            </div>
        </td>
    </tr>
@endif
