<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Laravel PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  </head>
  <body>
    <h2 class="mb-3">{{$vacancy->title}}</h2>
    <ul>
        <li>Location: <span>{{$vacancy->region->name}}</span></li>
        <li>Posted: <span>{{ Carbon\Carbon::parse($vacancy->created_at)->format('jS F Y')}}</span></li>
        <li>Employer: <span>{{$vacancy->employer->name}}</span></li>
        <li>Role type: <span>{{$vacancy->role->name}}</span></li>
    </ul>

    <p>{{ $vacancy->lead_para }}</p>

    <div>{!! $vacancy->description !!}</div>

    @if (!empty($vacancy->map))
        {!! $vacancy->vac_map !!}
    @endif


    {{asset('images/vacancies-bg.jpg')}}
    <img src="http://ck.platformbrand.com:8000/images/vacancies-bg.jpg">
    <img src="https://ck.mydirections.co.uk/media/dc6da863-b595-4b3c-986d-51c6b0fb6dde/4719cc86-3f42-4318-96eb-6578bbdd2fd5/Year_9_banner_001_purple.png">

{{-- {{$vacancy->employerImage->getFirstMediaUrl('logo')}} --}}
    {{-- <img src="{{parse_encode_url($vacancy->employerImage->getFirstMediaUrl('logo')) ?? ''}}"  style="width: 200px; height: 200px"> --}}

    <table>
        <tbody>

            @if (!empty($vacancy->contact_name))
                <tr>
                    <td width="5%"><i class="fas fa-user-circle fa-lg"></i></td>
                    <td class="text-left">Contact<br><span class="fw700">{{$vacancy->contact_name}}</span></td>
                </tr>
            @endif

            @if (!empty($vacancy->contact_email))
                <tr>
                    <td><i class="fas fa-at fa-lg"></i></td>
                    <td class="text-left"><a href="mailto:{{$vacancy->contact_email}}" class="fw700 td-no">{{$vacancy->contact_email}}</a></td>
                </tr>
            @endif

            @if (!empty($vacancy->contact_number))
                <tr>
                    <td><i class="fas fa-phone-square fa-lg"></i></td>
                    <td class="text-left"><a href="tel:{{$vacancy->contact_number}}" class="fw700 td-no">{{$vacancy->contact_number}}</a></td>
                </tr>
            @endif

            @if (!empty($vacancy->contact_link))
                <tr>
                    <td><i class="fas fa-link fa-lg"></i></td>
                    <td class="text-left"><a href="https://{{$vacancy->contact_link}}" class="fw700 td-no">Company website</a></td>
                </tr>
            @endif
        </tbody>
    </table>

    @if (!empty($vacancy->online_link))
        <a href="https://{{ $vacancy->online_link }}" class="platform-button pb-lge pb-inv">Apply online</a>
    @endif




    <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>

      </tr>
      </thead>
      <tbody>
        <tr>
            <td>text</td>
        </tr>
      </tbody>
    </table>



  </body>
</html>
