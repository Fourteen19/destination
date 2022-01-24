@if (count($cv->educations) > 0)

    @if ($cv->page_break_before_education == "Y")
        <div class="page-break"></div>
    @endif

    <div style="width: 100%;">
        <div style="border-bottom: 1px solid #ccc; margin-top: 10px; padding-bottom: 5px; margin-bottom: 10px; font-weight: bold;">Education</div>
        @foreach($cv->educations as $key => $education)
            
            <table width="100%" border-width="0" cellpadding="0" cellspacing="0" style="margin-bottom: 5px">
                <tr>
                    <td width="51%" style="width: 51%; font-weight: bold; padding-bottom: 3px">{{$education->name}}</td>
                    <td width="14%" style="width: 14%; font-weight: bold; padding-bottom: 3px">Grade</td>
                    <td width="35%" style="width: 35%; text-align: right; vertical-align: top;font-weight: bold; padding-bottom: 3px">{{$education->from}} - {{$education->to}}</td>
                </tr>
            @foreach($education->grades as $keyGrade => $grade)
                <tr>
                    <td width="51%" style="width: 51%; line-height: 1.1; vertical-align: top; padding-bottom: 3px">{{$grade->title}}</td>
                    <td width="49%" colspan="2" style="width: 49%; vertical-align: top; line-height: 1.1; padding-bottom: 3px">{{$grade->grade}} @if ($grade['predicted'] == "Y") (predicted) @endif</td>
                </tr>
            @endforeach
            </table>
        @endforeach
    </div>
@endif
