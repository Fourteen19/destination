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

    #Personal Profile
    <p>{{$cv->personal_profile}}</p>

    #Additional Interests
    <p>{{$cv->additional_interests}}</p>


    #References
    @foreach($cv->references()->get() as $key => $reference)

        <p>{{$reference->company}}</p>
        <p>{{$reference->address_1}}</p>
        <p>{{$reference->address_2}}</p>
        <p>{{$reference->address_3}}</p>
        <p>{{$reference->postcode}}</p>
        <p>{{$reference->email}}</p>
        <p>{{$reference->phone}}</p>

    @endforeach

  </body>
</html>
