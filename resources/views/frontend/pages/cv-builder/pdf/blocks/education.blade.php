@if (count($cv->educations) > 0)

    @if ($cv->page_break_before_education == "Y")
        <div class="page-break"></div>
    @endif

    <div style="width: 100%;">
        <div style="border-bottom: 1px solid #ccc; margin-top: 13px; padding-bottom: 0px; margin-bottom: 10px;font-weight: bold;">Education</div>
        @foreach($cv->educations as $key => $education)
        <div style="margin-bottom: 20px">
        <table width="100%" style="padding: 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td width="100%" style="width: 100%"><span style="font-weight: bold; display: inline-block; width: 45%; padding: 0">{{$education->name}}</span><span style="font-weight: bold; display: inline-block; width: 20%; padding: 0">Grade</span><span style="font-weight: bold; display: inline-block; width: 35%; text-align: right; vertical-align: top; padding: 0">{{$education->from}} - {{$education->to}}</span></td>
            </tr>
        </table>@foreach($education->grades as $keyGrade => $grade)
            <table width="100%" style="padding: 0; margin-bottom: 3px" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="100%" style="width: 100%"><span style="display: inline-block; width: 45%; line-height: 1.1; vertical-align: top;">{{$grade->title}}</span><span style="display: inline-block; width: 55%; vertical-align: top; line-height: 1.1;">{{$grade->grade}} @if ($grade['predicted'] == "Y") (predicted) @endif</span></td>
                </tr>
            </table>
        @endforeach 
        </div>
        @endforeach
</div>
@endif