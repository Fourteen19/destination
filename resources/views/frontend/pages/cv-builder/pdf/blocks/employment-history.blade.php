@if ( ($cv->employment == "Y") && (count($cv->employments) > 0) )

    @if ($cv->page_break_before_employment == "Y")
        <div class="page-break"></div>
    @endif
       
    <div style="width: 100%;">
        <div style="border-bottom: 1px solid #ccc; margin-top: 20px; padding-bottom: 5px; margin-bottom: 10px;font-weight: bold;">{{$block_title}}</div>
        @foreach($cv->employments as $key => $employment)
        <table width="100%" border-width="0" cellpadding="0" cellspacing="0">    
            <tr>
                <td style="font-weight: bold;"><div style="margin-bottom: 2px">{{$employment->organisation}} @if ($employment->job_type == "employed") @elseif ($employment->job_type == "volunteering")(Volunteering) @elseif ($employment->job_type == "work-experience")(Work experience)@endif</div><div style="margin-bottom: 3px">{{$employment->job_role}}</div></td>
                <td style="font-weight: bold; text-align: right; vertical-align: top" valign="top">{{$employment->from}} - {{$employment->to}}</td>
            </tr>
            <tr>
                <td colspan="2">
                @if ($employment->tasks_type == 'bullets')
                    @if (count($employment->tasks) > 0)
                        <ul style="margin-bottom: 12px">
                        @foreach($employment->tasks as $keyTask => $task)
                            <li>{{$task->description}}</li>
                        @endforeach
                        </ul>
                    @endif
                @else
                <div style="margin-bottom: 12px">{{$employment->tasks_txt}}</div>
                @endif
                </td>
            </tr>
        </table>
        @endforeach
</div>
@endif
