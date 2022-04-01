<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{{$vacancy->title}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
  </head>
  <body style="font-family: helvetica; font-size:12px">
    <div style="background-color: #e0e0e0; padding: 1rem; margin-bottom: 2rem">
        <div style="font-size: 14px"><b>+MyDirections Job Advert</b></div>
    </div>
    <h1 style="border-bottom: 1px solid #999999; padding-bottom: 0.635rem; font-size: 24px">{{$vacancy->title}}</h2>

    <table cellpadding="0" cellspacing="0" width="100%">
        <tbody>
            <tr>
                <td width="50%">
                    <div style="font-size: 14px; margin-bottom: 0.625rem">Location: <span style="font-weight: bold">{{$vacancy->region->name}}</span></div>
                    <div style="font-size: 14px; margin-bottom: 0.625rem">Posted: <span style="font-weight: bold">{{ Carbon\Carbon::parse($vacancy->created_at)->format('jS F Y')}}</span></div>
                    <div style="font-size: 14px; margin-bottom: 0.625rem">Employer: <span style="font-weight: bold">{{$vacancy->employer->name}}</span></div>
                    <div style="font-size: 14px; margin-bottom: 0.625rem">Role type: <span style="font-weight: bold">{{$vacancy->role->name}}</span></div>
                    <div style="font-size: 14px; margin-bottom: 0.625rem">Entry Requirements: <span style="font-weight: bold">{!! $vacancy->entry_requirements !!}</span></div>

                </td>
                <td style="text-align: right" width="50%">
                    <img src="{{$vacancy->getFirstMediaPath('vacancy_image', 'banner') ?? ''}}" onerror="this.style.display='none'" width="150px" style="float: right; width:150px;">
                </td>
            </tr>
        </tbody>
    </table>
    <p><b>{{ $vacancy->lead_para }}</b></p>
    <div style="border-bottom: 1px solid #999999; padding-bottom: 1rem; margin-bottom: 1rem">{!! $vacancy->description !!}</div>




    <h2 style="font-size: 18px; margin-bottom: 1rem">To enquire about this role:</h2>

    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="75%">
                <table>
                   <tbody>

                        @if (!empty($vacancy->contact_name))
                            <tr>
                                <td width="20%" valign="top" style="vertical-align: top"><div style="margin-bottom: 0.625rem">Contact Name:</div></td>
                                <td width="80%" valign="top" style="vertical-align: top"><b>{{$vacancy->contact_name}}</b></td>
                            </tr>
                        @endif

                        @if (!empty($vacancy->contact_email))
                            <tr>
                                <td valign="top" style="vertical-align: top"><div style="margin-bottom: 0.625rem">Email:</div></td>
                                <td valign="top" style="vertical-align: top"><b>{{$vacancy->contact_email}}</b></td>
                            </tr>
                        @endif

                        @if (!empty($vacancy->contact_number))
                            <tr>
                                <td valign="top" style="vertical-align: top"><div style="margin-bottom: 0.625rem">Phone:</div></td>
                                <td valign="top" style="vertical-align: top"><b>{{$vacancy->contact_number}}</b></td>
                            </tr>
                        @endif

                        @if (!empty($vacancy->contact_link))
                            <tr>
                                <td valign="top" style="vertical-align: top"><div style="margin-bottom:0.625rem">Company website:</div></td>
                                <td valign="top" style="vertical-align: top"><b>https://{{$vacancy->contact_link}}</b></td>
                            </tr>
                        @endif

                        @if (!empty($vacancy->online_link))
                            <tr>
                                <td valign="top" style="vertical-align: top"><div style="margin-bottom: 0.625rem">Apply online:</div></td>
                                <td valign="top" style="vertical-align: top"><b>https://{{ $vacancy->online_link }}</b></td>
                            </tr>
                        @endif

                    </tbody>
               </table>
            </td>
            <td width="25%">
            <img src="{{$vacancy->employerImage->getFirstMedia('logo')->getPath() ?? ''}}" onerror="this.style.display='none'" width="150px" style="float: right; width:150px">
            </td>
        </tr>
    </table>



  </body>
</html>
