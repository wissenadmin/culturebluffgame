<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Email Template</title><style>.test a{color:black !important;text-decoration: none;}</style>
</head>
<body >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center" valign="top" bgcolor="#eeeeee" style="background-color:#eeeeee;">
<table width="600" border="0" cellspacing="0" cellpadding="0">
<tr>
        <td align="center" valign="top"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top" bgcolor="#294c83" style="background-color:#294c83;  font-size: 20px; font-weight: bold; padding: 32px; color:#fff; font-family:Arial, Helvetica, sans-serif;">Thanks for purchasing Culture Buff Games</td>
          </tr>
        </table></td>
      </tr>
<tr>
<td align="center" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;">
<table width="600" border="0" cellspacing="0" cellpadding="15">
<tr>
<td align="left" valign="top">
<font id="welcome" size="+2" color="#274d84" face="verdana"><strong>Hi {{$data['first_name']}}</strong></font><br><br>
<font size="3" color="#333" face="verdana">My name is Culture Buff and welcome to Culture Buff Games!</font><br><br>
<font size="3" color="#333" face="verdana"><strong>Thanks for purchasing our games!</strong></font><br><br>
<font size="3" color="#333" face="verdana">As an administrator, please visit our website at www.culturebuffgames.com to monitor the game activity for each of the licenses purchased by your organization. Please click on the myCultureBuff button on the webpage.</font><br>
</td>
</tr>
<tr>
 <td align="left" valign="top">
 <table border="0" cellspacing="0" cellpadding="10" width="100%">
 <tr>
 <td align="left" valign="top" width="26%" bgcolor="#27ace8" style="border-bottom:solid 1px #fff;background-color:#27ace8;"><font size="2" color="#fff" face="verdana"> <strong>Username:</strong></font></td>
<td align="left" valign="top" width="74%" style=" border:solid 1px #CCC"><font size="2" color="#000" face="verdana"><strong> {{$data['user_username']}}</strong> </font></td>
</tr>
<tr>
 <td align="left" valign="top" width="26%" bgcolor="#27ace8" style="background-color:#27ace8;"> <font size="2" color="#fff" face="verdana"><strong>Password</strong></font></td>
 <td align="left" valign="top" width="74%" style="border-right:solid 1px #CCC; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC"><font size="2" color="#000" face="verdana"><strong> {{$data['password']}}</strong> </font></td>
 </tr>
  </table>
 </td>
</tr>
<tr>
<td align="left" valign="top">
<font size="3" color="#000" face="verdana">The following usernames have been created for each of the licenses purchased by your organization.</font><br>
</td>
</tr>
<tr>
 <td align="left" valign="top">
 <table border="0" cellspacing="0" cellpadding="10" width="100%">
 <tr>
 <td align="center" valign="top" bgcolor="#27ace8" style="background-color:#27ace8;"><font size="2" color="#fff" face="verdana"> <strong>Username</strong></font></td>
 <td align="center" valign="top"  bgcolor="#27ace8" style="background-color:#27ace8;"><font size="2" color="#fff" face="verdana"><strong>Password</strong></font></td>
 <td align="center" valign="top"  bgcolor="#27ace8" style="background-color:#27ace8;"><font size="2" color="#fff" face="verdana"><strong>Game License</strong></font></td>
 <td align="center" valign="top"  bgcolor="#27ace8" style="background-color:#27ace8;"><font size="2" color="#fff" face="verdana"><strong>Expiration Date</strong></font></td>
</tr>
@foreach($data['user_accounts'])
<tr>
<td align="center" valign="top" style="border-right:solid 1px #CCC; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC"><font size="2" color="#000" face="verdana"><strong> Indra Jangid</strong>  </font></td>
<td align="center" valign="top" style="border-right:solid 1px #CCC; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC"><font size="2" color="#000" face="verdana"><strong> ************</strong> </font></td>
<td align="center" valign="top"  style="border-right:solid 1px #CCC; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC"><font size="2" color="#000" face="verdana"><strong> 123456789958 </strong></font></td>
<td align="center" valign="top"  style="border-right:solid 1px #CCC; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC"><font size="2" color="#000" face="verdana"><strong> 27 Aushust 2017</strong> </font></td>
</tr>
@endforeach
</table>
 </td>
</tr>
<tr>
<td align="left" valign="top">
<font size="3" color="#000" face="verdana">Hope your users have a fun time playing our games!</font><br>
</td>
</tr>
<tr>
<td align="left" valign="top">
<img src="{{url()}}/resources/dashboard/images/mail-cartoon.png">
</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
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