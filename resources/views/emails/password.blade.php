<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Email Template</title>

</head>

<body >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center" valign="top" bgcolor="#eeeeee" style="background-color:#eeeeee;">
<table width="600" border="0" cellspacing="0" cellpadding="0">
 <tr>
        <td align="center" valign="top"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top" bgcolor="#294c83" style="background-color:#294c83;  font-size: 20px; font-weight: bold; padding: 32px; color:#fff; font-family:Arial, Helvetica, sans-serif;">New Password Request For Culture Buff Games</td>
          </tr>
        </table></td>
      </tr> 
<tr>
<td align="center" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;">
<table width="600" border="0" cellspacing="0" cellpadding="15">
 <tr>
<td align="left" valign="top">

<font size="3" color="#333" face="verdana">My name is Culture Buff and welcome to Culture Buff Games!</font><br><br>

<font size="3" color="#333" face="verdana">We have received your request to reset your password. Please click on the link below to reset your password.</font><br>

<br>
<font size="3" color="#333" face="verdana"><a href="{{ url('password/reset/'.$token) }}">Link</a> </font>
<br><br><br>

<font size="3" color="#333" face="verdana"><img src="{{url()}}/resources/dashboard/images/mail-cartoon.png"></font><br><br><br>
<font size="3" color="#333" face="verdana"><strong>Culture Buff Games</strong></font><br><br>
</td>
</tr>
<tr>
</table>
</td>
</tr>

</table>
</td>
</tr>   
</table>
</body>
</html>

