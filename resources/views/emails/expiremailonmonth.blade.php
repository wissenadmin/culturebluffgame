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
            <td align="center" valign="top" bgcolor="#294c83" style="background-color:#294c83;  font-size: 20px; font-weight: bold; padding: 32px; color:#fff; font-family:Arial, Helvetica, sans-serif;">Account expire on Culture Buff Games</td>
          </tr>
        </table></td>
      </tr> 

<tr>
<td align="center" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;">
<table width="600" border="0" cellspacing="0" cellpadding="15">

<tr>
<td align="left" valign="top">
<font id="welcome" size="+2" color="#274d84" face="verdana"><strong>Hi {!! $key->user_username !!}</strong></font><br><br>
<font size="3" color="#333" face="verdana">My name is Culture Buff and Welcome to Culture Buff Games !</font><br><br>
<font size="3" color="#333" face="verdana">
Your licence ,({!! $key->licence_type!!}) is expired after 30 days, please renew that account befor expire.
</font><br><br>
</td>
</tr>
<tr>
<td align="left" valign="top">
<font size="3" color="#000" face="verdana">Hope you have a fun time playing our Culture Buff Games !</font><br>
</td>
</tr>
<tr>
<td align="left" valign="top">
<img src="{{url()}}/resources/dashboard/images/mail-cartoon.png">
</td>
</tr>
<br>
<tr>
<td align="left" valign="top">
 <font size="3" color="#000" face="verdana"> Culture Buff Games </font>
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