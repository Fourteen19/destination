<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>MyDirections - CV</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
  </head>
  <body style="font-family: serif; font-size:12px">
        <table width="100%" border-width="0" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align: center; font-weight: bold;"><span style="font-weight: bold; font-size:14px">{{$cv->first_name}} {{$cv->last_name}}</span><br>
            {{$cv->address}}<br>
            {{$cv->email}}<br>
            {{$cv->phone}}
            </td>
        </tr>
        <tr>
            <td>
                <div style="margin-top: 10px">
                <div style="font-weight: bold; margin-bottom: 5px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Personal Profile</div>
                <div>{{$cv->personal_profile}}</div>
                </div>
            </td>
        </tr>
        </table>
        <table width="100%" border-width="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2">
                <div style="border-bottom: 1px solid #ccc; margin-top: 20px; padding-bottom: 5px; margin-bottom: 5px"><span style="font-weight: bold;">Employment history</span></div>
            </td>
        </tr>
        @foreach($cv->employments as $key => $employment)
        <tr>
            <td style="font-weight: bold;"><div style="margin-bottom: 2px">{{$employment->organisation}} @if ($employment->job_type == "employed") @elseif ($employment->job_type == "volunteering")(Volunteering) @elseif ($employment->job_type == "work-experience")(Work Experience)@endif</div><div style="margin-bottom: 3px">{{$employment->job_role}}</div></td>
            <td style="font-weight: bold; text-align: right; vertical-align: top" valign="top">{{$employment->from}} - {{$employment->to}}</td>
        </tr>
        <tr>
            <td colspan="2">
            @if ($employment->tasks_type == 'bullets')
                @if (count($employment->tasks) > 0)
                    <ul style="margin-bottom: 15px">
                    @foreach($employment->tasks as $keyTask => $task)
                        <li>{{$task->description}}</li>
                    @endforeach
                    </ul>
                @endif
            @else
            <div style="margin-bottom: 15px">{{$employment->tasks_txt}}</div>
            @endif
            </td>
        </tr>
        @endforeach
        </table>

        <table width="100%" border-width="0" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2">
                <div style="border-bottom: 1px solid #ccc; margin-top: 20px; padding-bottom: 5px; margin-bottom: 5px"><span style="font-weight: bold;">Education</span></div>
            </td>
        </tr>
        @foreach($cv->educations as $key => $education)
        <tr>
            <td style="font-weight: bold;"><div style="margin-bottom: 3px">{{$education->name}}</div></td>
            <td style="font-weight: bold; text-align: right; vertical-align: top" valign="top">{{$education->from}} - {{$education->to}}</td>
        </tr>
            @foreach($education->grades as $keyGrade => $grade)
            <tr>
                <td width="60%"><div style="margin-bottom: 3px">{{$grade->title}}</div></td>
                <td width="40%"><div style="margin-bottom: 3px">{{$grade->grade}} @if ($grade['predicted'] == "Y") (predicted) @endif</div></td>
            </tr>
            @endforeach
        <tr><td><div style="margin-bottom: 5px">&nbsp;</div></td></tr>
        @endforeach
        </table>

        <table width="100%" border-width="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div style="margin-top: 10px">
                <div style="border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 5px; font-weight: bold;">Additional Interests</div>
                <div>{{$cv->additional_interests}}</div>
                </div>
            </td>
        </tr>
        </table>
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
  </body>
</html>