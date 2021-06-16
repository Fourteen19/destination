@extends('frontend.emails.master')

@section('content')
<div style="background-color: #e0e0e0; padding: 16px; border-radius:6px;">
    <div style="background-color: #fff; padding: 10px;">
        <table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:500px;" width="500px" align="center" border="0" cellpadding="5" cellspacing="3" class="inner-table">
            <tr>
                <td style="color:#666666; width: 33%; vertical-align: top" valign="top">From:</td>
                <td style="vertical-align: top" valign="top">{{ $details['first_name'] }} {{ $details['last_name'] }}</td>
            </tr>
            <tr>
                <td style="color:#666666; vertical-align: top">Year:</td>
                <td style="vertical-align: top" valign="top">##</td>
            </tr>
            <tr>
                <td style="color:#666666; vertical-align: top">Email Address:</td>
                <td style="vertical-align: top" valign="top">##@###.com</td>
            </tr>
            <tr>
                <td style="color:#666666; vertical-align: top">Institution:</td>
                <td style="vertical-align: top" valign="top">{{ $details['institution']}}</td>
            </tr>
            <tr>
                <td style="color:#666666; vertical-align: top">Subject:</td>
                <td style="vertical-align: top" valign="top">{{ $details['questionType']}}</td>
            </tr>
            <tr>
                <td style="color:#666666; vertical-align: top">Question:</td>
                <td style="vertical-align: top" valign="top">{{ $details['questionText'] }}</td>
            </tr>
        </table>
    </div>
</div>

@endsection
