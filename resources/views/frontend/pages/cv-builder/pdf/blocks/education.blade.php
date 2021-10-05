@if (count($cv->educations) > 0)

    @if ($cv->page_break_before_education == "Y")
        <div class="page-break"></div>
    @endif

    <table width="100%" border-width="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2">
                <div style="border-bottom: 1px solid #ccc; margin-top: 20px; padding-bottom: 5px; margin-bottom: 5px"><span style="font-weight: bold;">Education</span></div>
            </td>
        </tr>
        @foreach($cv->educations as $key => $education)
            <tr>
                <td style="font-weight: bold;"><div style="margin-bottom: 3px">{{$education->name}}</div></td>
                <td style="font-weight: bold;"><div style="margin-bottom: 3px">Grade</div></td>
                <td style="font-weight: bold; text-align: right; vertical-align: top" valign="top">{{$education->from}} - {{$education->to}}</td>
            </tr>
                @foreach($education->grades as $keyGrade => $grade)
                <tr>
                    <td width="60%"><div style="margin-bottom: 3px">{{$grade->title}}</div></td>
                    <td width="40%" colspan="2"><div style="margin-bottom: 3px">{{$grade->grade}} @if ($grade['predicted'] == "Y") (predicted) @endif</div></td>
                </tr>
                @endforeach
            <tr><td><div style="margin-bottom: 5px">&nbsp;</div></td></tr>
        @endforeach
    </table>
@endif
