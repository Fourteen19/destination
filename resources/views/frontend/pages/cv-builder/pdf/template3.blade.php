<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>MyDirections - CV</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
  </head>
  <body style="font-family: helvetica; font-size:12px">
    <div style="background-color: #e0e0e0; padding: 1rem; margin-bottom: 2rem">
        <div style="font-size: 14px"><b>+MyDirections CV</b></div>
    </div>

    #Personal Details
    <p>{{$cv->first_name}}</p>
    <p>{{$cv->last_name}}</p>
    <p>{{$cv->address}}</p>
    <p>{{$cv->email}}</p>
    <p>{{$cv->phone}}</p>

    #Education
    @foreach($cv->educations as $key => $education)
        <p>{{$education->name}}</p>
        <p>{{$education->from}}</p>
        <p>{{$education->to}}</p>
        @foreach($education->grades as $keyGrade => $grade)
            <p>{{$grade->title}}</p>
            <p>{{$grade->grade}}</p>
            <p>{{$grade->predicted}}</p>
        @endforeach
    @endforeach

    #Personal Profile
    <p>{{$cv->personal_profile}}</p>

    #Additional Interests
    <p>{{$cv->additional_interests}}</p>

    #References
    @foreach($cv->references as $key => $reference)
        <p>{{$reference->name}}</p>
        <p>{{$reference->job_role}}</p>
        <p>{{$reference->company}}</p>
        <p>{{$reference->address_1}}</p>
        <p>{{$reference->address_2}}</p>
        <p>{{$reference->address_3}}</p>
        <p>{{$reference->postcode}}</p>
        <p>{{$reference->email}}</p>
        <p>{{$reference->phone}}</p>
    @endforeach


    #Employments
    @foreach($cv->employments as $key => $employment)
        <p>{{$employment->organisation}}</p>
        <p>{{$employment->job_role}}</p>
        <p>@if ($employment->job_type == "employed")
                Employed
            @elseif ($employment->job_type == "volunteering")
                Volunteering
            @elseif ($employment->job_type == "work-experience")
                Work Experience
            @endif
        </p>
        <p>{{$employment->from}}</p>
        <p>{{$employment->to}}</p>
        @if ($employment->tasks_type == 'bullets')
            @if (count($employment->tasks) > 0)
                @foreach($employment->tasks as $keyTask => $task)
                    <p>{{$task->description}}</p>
                @endforeach
            @endif
        @else
            <p>{{$employment->tasks_txt}}</p>
        @endif
    @endforeach


  </body>
</html>
