@if (count($cv->references) > 0)

    @if ($cv->page_break_before_references == "Y")
        <div class="page-break"></div>
    @endif
        <div>
            <div style="margin-top: 20px">
                <div style="border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 5px; font-weight: bold;">References</div>
            </div>
        </div>
        <table width="100%" border-width="0" cellpadding="0" cellspacing="0">
            <tr><td>
            @foreach($cv->references as $key => $reference)
                <div style="width:50%; vertical-align: top; display: inline-block">
                    <p style="margin-top: 10px">
                    @if ($reference->name){{$reference->name}}<br>@endif
                    @if ($reference->job_role){{$reference->job_role}}<br>@endif
                    @if ($reference->company){{$reference->company}}<br>@endif
                    @if ($reference->address_1){{$reference->address_1}}<br>@endif
                    @if ($reference->address_2){{$reference->address_2}}<br>@endif
                    @if ($reference->address_3){{$reference->address_3}}<br>@endif
                    @if ($reference->postcode){{$reference->postcode}}<br>@endif
                    @if ($reference->email){{$reference->email}}<br>@endif
                    @if ($reference->phone){{$reference->phone}}@endif</p>
                </div>
            @endforeach
            </td></tr>
        </table>
@endif