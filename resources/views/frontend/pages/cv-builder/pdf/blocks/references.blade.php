@if (count($cv->references) > 0)
    <table width="100%" border-width="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2">
                <div style="margin-top: 20px">
                <div style="border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 5px; font-weight: bold;">References</div>
                </div>
            </td>
        </tr>
        <tr>
            @foreach($cv->references as $key => $reference)
                <td width="50%">
                    <p>{{$reference->name}}<br>
                    {{$reference->job_role}}<br>
                    {{$reference->company}}<br>
                    {{$reference->address_1}}<br>
                    {{$reference->address_2}}<br>
                    {{$reference->address_3}}<br>
                    {{$reference->postcode}}<br>
                    {{$reference->email}}<br>
                    {{$reference->phone}}</p>
                </td>
            @endforeach
        </tr>
    </table>
@endif
