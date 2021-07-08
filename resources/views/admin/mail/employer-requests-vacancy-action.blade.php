@extends('admin.mail.master')

@section('content')
<div style="background-color: #e0e0e0; padding: 16px; border-radius:6px;">
    <div style="background-color: #fff; padding: 10px;">
        <table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:500px;" width="500px" align="center" border="0" cellpadding="5" cellspacing="3" class="inner-table">
            <tr>
                <td style="color:#666666; width: 33%; vertical-align: top" valign="top">From:</td>
                <td style="vertical-align: top" valign="top">{{ Auth::guard('admin')->user()->TitleFullName }}</td>
            </tr>
            <tr>
                <td style="color:#666666; vertical-align: top">Query:</td>
                <td style="vertical-align: top" valign="top">
                    @if ($details['vacancyAction'] == 'Live')
                        Could you please make the follwing vacancy live?
                    @elseif ($details['vacancyAction'] == 'Live')
                        Could you please remove the follwing vacancy from live?
                    @elseif ($details['vacancyAction'] == 'Live')
                        Could you please delete the follwing vacancy?
                    @endif
                </td>
            </tr>
            <tr>
                <td style="color:#666666; vertical-align: top">Vacancy:</td>
                <td style="vertical-align: top" valign="top">{{ ($details['title']) }}</td>
            </tr>
        </table>
    </div>
</div>

@endsection
