<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="format-detection" content="telephone=no">

        <title>{{ $details['email_title'] }}</title>
		<style type="text/css">
			#outlook a {
				padding:0;
			}
			body {
				width:100% !important;
				-webkit-text-size-adjust:100%;
				-ms-text-size-adjust:100%;
				margin:0;
				padding:0;
			}
			.ExternalClass {
				width:100%;
			}
			.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div {
				line-height:100%;
			}
			p {
				padding:0;
				margin:0 0 18px;
			}
			img {
				outline:none;
				text-decoration:none;
				-ms-interpolation-mode:bicubic;
			}
			a img {
				border:none;
			}
			.image_fix {
				display:block;
			}
			table td {
				border-collapse:collapse;
			}
			table {
				border-collapse:collapse;
				mso-table-lspace:0pt;
				mso-table-rspace:0pt;
			}
			ul,
			ol,
			dl {
				display:block;
				list-style-position:outside !important;
				margin:0 0 10px 18px;
				padding:0;
				text-align:left;
			}
			ul li {
				margin:0 0 3px 0;
			}
			ol li {
				margin:0 0 3px 0;
			}
			li:last-child,li:last-of-type {
				margin-bottom:0;
			}
			@media screen and (max-width:600px) {
				table[class="container-table"] {
					width: 100% !important;
				}
				table[class="inner-table"] {
					width: 100% !important;
				}
				img[class="full-width-image"] {
					width:100% !important;
					height:auto !important;
				}
				td[class="text-padding"] {
					padding:30px 25px !important;
				}
				td[class="footer-padding"]{
					padding:25px 25px 25px !important;
				}
			}
		</style>
		<!--[if (gte mso 9)|(IE)]>
			<style type="text/css">
				ul {
					margin: 0 0 0 24px;
					padding: 0;
					list-style-position: inside;
				}
			</style>
		<![endif]-->

</head>
<body>

<body bgcolor="#ffffff">
	<table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" width="100%" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">

		<table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:600px;" width="600" align="center" border="0" cellpadding="0" cellspacing="0" class="container-table">
		<tr>
			<td align="center" style="padding-top:25px; padding-bottom:35px; font-family:Arial, Helvetica, sans-serif; color:#424242;"><h1 style="font-weight: 700; font-size: 20px;">+MyDirections</h1></td>
		</tr>
		<tr>
			<td align="center" height="1">

			<table width="600" align="center" bgcolor="{{$clientSettings['colour_bg1'] ?? $clientSettings['bg1']}}" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:600px;" border="0" cellpadding="0" cellspacing="0" class="container-table">
			<tr>
				<td height="9" align="left" style="font-size: 1px; line-height: 1px;">&nbsp;</td>
			</tr>
			</table>

			</td>
		</tr>
		<tr>
			<td align="center" class="text-padding" style="padding:50px;">

			<table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:500px;" width="500px" align="center" border="0" cellpadding="0" cellspacing="0" class="inner-table">
			<tr>
                <td align="left" style="font-family:Arial, Helvetica, sans-serif; color:#424242; font-size:14px; line-height:16px;">
                    @yield('content')

                    <p><br>Thanks</p>
                    <p>Your MyDirections Team</p>
                </td>
			</tr>
			</table>

			</td>
		</tr>
		<tr>
			<td align="center" height="4">

			<table width="600" align="center" bgcolor="{{$clientSettings['colour_bg1'] ?? $clientSettings['bg1']}}" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:600px;" border="0" cellpadding="0" cellspacing="0" class="container-table">
			<tr>
				<td height="4" align="left" style="font-size: 1px; line-height: 1px;">&nbsp;</td>
			</tr>
			</table>

			</td>
		</tr>
		<tr>
			<td align="center">

			<table width="600" align="center" bgcolor="#dddddd" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:600px;" border="0" cellpadding="0" cellspacing="0" class="container-table">
			<tr>
				<td align="center" class="footer-padding" style="padding:25px 50px 50px;">

				<table style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:500px;" width="500px" align="center" border="0" cellpadding="0" cellspacing="0" class="inner-table">
				<tr>
					<td align="left" style="font-family:Arial, Geneva, sans-serif; font-size:10px; line-height:13px;"><strong>This correspondence is confidential and is solely for the intended recipient(s). If you are not the intended recipient, you must not use, disclose, copy, distribute or retain this message or any part of it. If you are not the intended recipient please delete this correspondence from your system and notify the sender immediately. No warranty is given that this correspondence is free from any virus. In keeping with good computer practice, you should ensure that it is actually virus free.</strong></td>
				</tr>
				<tr>
					<td height="25" align="left" style="font-size: 1px; line-height: 1px;">&nbsp;</td>
				</tr>
				<tr>
					<td align="left" style="font-family:Arial, Geneva, sans-serif; font-size:10px; line-height:13px;"><strong><a href="#" target="_blank" title="Visit MyDirections" style="text-decoration:none;">Visit Mydirections website</a>&nbsp; &copy; 2021 C & K Careers</strong></td>
				</tr>
				</table>

				</td>
			</tr>
			</table>

			</td>
		</tr>
		</table>

		</td>
	</tr>
	</table>

	</body>
	</html>
