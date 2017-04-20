<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style>
.test a{color:black !important;text-decoration: none;}

</style>
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
            <td align="center" valign="top" bgcolor="#2382FD" style="background-color:#2382FD;  font-size: 20px; font-weight: bold; padding: 32px; color:#fff; font-family:Arial, Helvetica, sans-serif;">Login information for Culture Buff Games Trial</td>
          </tr>
        </table></td>
      </tr> 

<tr>
<td align="center" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;">
<table width="600" border="0" cellspacing="0" cellpadding="15">
 
<tr>
<td align="left" valign="top">
<font id="welcome" size="+2" color="#1155CC" face="verdana"><strong>Hi {{$userData['first_name']}}</strong></font><br><br>
<font size="3" color="#333" face="verdana">My name is Culture Buff and welcome to Culture Buff Games !</font><br><br>
<font size="3" color="#333" face="verdana" style="text-align:justify;"><span><b>Thanks for signing up for the Trial version of our  game.</b><br><br>The Trial version is an abbreviated version of our complete games which you can purchase via our website <a href="www.culturebuffgames.com">www.culturebuffgames.com.</a>
</font><br><br>
<font size="3" color="#333" face="verdana">To access the Trial version of the game, please use the following login details and click on the link below: <br>
<a href="{{ URL::to('register/verify/' . $userData['link']) }}">{{ URL::to('register/verify/' . $userData['link']) }}</a></font>
</td>
</tr>
<tr>
<td align="left" valign="top" class="test">
<font size="3"  face="verdana" > <b><span style="color:#1155CC;">Username</span> {{$userData['email']}}</b></font><br>
</td>
</tr>

<tr>
<td align="left" valign="top">
<font size="3"  face="verdana"><b> <span style="color:#1155CC;">Password</span>  <span style="color:black;">{{$userData['password']}}</span></b> </font><br>
</td>
</tr>

<tr> 
<td align="left" valign="top">
<font size="3" color="#000" face="verdana"> <i> Your trial will expire on <b> {{changeDateFormat($userData['licence_valid_till'])}}.</b></i>   </font><br>
</td>
</tr>
<tr> 
<td align="left" valign="top">
<font size="3" color="#000" face="verdana">Please contact us at techsupport@culturebuffgames.com for any technical assistance with accessing the games.</font><br>
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
<tr>
<td align="left" valign="top">
 <font size="3" color="#000" face="verdana"> <b>Culture Buff Games</b> </font>
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
