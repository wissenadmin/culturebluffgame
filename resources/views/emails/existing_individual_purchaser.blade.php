<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Email Template</title>
<style>
.test a{color:black !important;text-decoration: none;}
</style>
</head>

<body >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center" valign="top" bgcolor="#eeeeee" style="background-color:#eeeeee;">
<table width="600" border="0" cellspacing="0" cellpadding="0">
 <tr>
        <td align="center" valign="top"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top" bgcolor="#2382FD" style="background-color:#2382FD;  font-size: 20px; font-weight: bold; padding: 32px; color:#fff; font-family:Arial, Helvetica, sans-serif;">Thanks for purchasing Culture Buff Games</td>
          </tr>
        </table></td>
      </tr> 
<tr>
<td align="center" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;">
<table width="600" border="0" cellspacing="0" cellpadding="15">
 <tr>
<td align="left" valign="top">
<font id="welcome" size="+2" color="#1155CC" face="verdana"><strong>Hi {{$data['users_infos']['first_name']}}</strong></font><br><br>
<font size="3" color="#333" face="verdana">My name is Culture Buff and welcome to Culture Buff Games!</font><br><br>
<font size="3" color="#333" face="verdana">Thanks for purchasing our games!</font><br><br>
<font size="3" color="#333" face="verdana">Please visit our website at <a href="www.culturebuffgames.com">www.culturebuffgames.com</a> and click on the <b>myCultureBuff</b> button to access your recently purchased games using your existing login details. </font><br><br><br>

<font size="3" color="#333" face="verdana"> The following additional games were purchased by you: </font>
<br>
<font size="3" color="#333" face="verdana">
@foreach($data['games_info'] as $key => $value)
<b>{{$value['game_licence']}}</b> <br>
<i>Your license will expire on <b>{{changeDateFormat($value['licence_valid_till'])}}.<i></b><br><br>
@endforeach
</font>

<br><font size="3" color="#333" face="verdana">Please contact us at techsupport@culturebuffgames.com for any technical assistance with accessing the games.</font><br><br>



<font size="3" color="#333" face="verdana">Hope you have a fun time playing our games! </font>
<br>
<br>

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

