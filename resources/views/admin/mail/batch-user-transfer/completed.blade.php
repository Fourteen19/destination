@extends('admin.mail.master')

@section('content')
<div style="background-color: #e0e0e0; padding: 16px; border-radius:6px;">
    <div style="background-color: #fff; padding: 10px;">
        <table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:500px;" width="500px" align="center" border="0" cellpadding="5" cellspacing="3" class="inner-table">
            <tr>
                <td>{{ $details['email_message'] }}</td>
            </tr>
        </table>
    </div>
</div>

@endsection
