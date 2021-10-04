@if ( ($cv->employment == "N") && (count($cv->employmentSkills) > 0) )

    @if ($cv->page_break_before_employment == "Y")
        <div class="page-break"></div>
    @endif

    <table width="100%" border-width="0" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="2">
            <div style="border-bottom: 1px solid #ccc; margin-top: 20px; padding-bottom: 5px; margin-bottom: 5px"><span style="font-weight: bold;">Key Skills</span></div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            @foreach($cv->employmentSkills as $keySkill => $skill) 
                <div style="margin-bottom: 3px"><span style="font-weight: bold;">{{$skill['title']}}</span>: {{$skill['description']}}</div>
            @endforeach
        </td>
    </tr>
@endif