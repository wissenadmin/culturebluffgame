<?php //print_r($data); ?>
<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Email Template</title>

</head>

<body style="background-color:#eeeeee;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center" valign="top" bgcolor="#eeeeee" style="background-color:#eeeeee;">
<table width="600" border="0" cellspacing="0" cellpadding="0">
<tr>
        <td align="center" valign="top"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top" bgcolor="#294c83" style="background-color:#2EA9FD;  font-size: 20px; font-weight: bold; padding: 32px; color:#fff; font-family:Arial, Helvetica, sans-serif;">Purchase Game Link From Culture Buff Games</td>
          </tr>
        </table></td>
      </tr> 

<tr>
<td align="center" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;">
<table width="600" border="0" cellspacing="0" cellpadding="15">

<tr>
<td align="left" valign="top">
<font id="welcome" size="+2" color="#274d84" face="verdana"><strong style="color:#3972D5;">Hi  {{$data['first_name']}}</strong></font><br><br>
<font size="3" color="#333" face="verdana">My name is Culture Buff and Welcome to Culture Buff Games !</font><br><br>
<font size="3" color="#333" face="verdana">To complete your purchase please click on the link below.<br>
<a href="{{ URL::to('register/purchase/' . $data['confirmation_code']) }}">Link</a>
</font><br>

</td>
</tr>
<tr>
<td align="left" valign="top">
<font size="3" color="#000" face="verdana">Hope you have a fun time playing our games !</font><br>
</td>
</tr>


<tr>
<td align="left" valign="top">
<img src="{{url()}}/resources/dashboard/images/mail-cartoon.png">
</td>
</tr>
<tr>
<td align="left" valign="top">
 <font size="3" color="#000" face="verdana"><b>Culture Buff Games</b></font>
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