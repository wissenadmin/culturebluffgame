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
                            <td align="center" valign="top" bgcolor="#ffffff" style="background-color:#ffffff;">
                                <table width="550" border="0" cellspacing="0" cellpadding="15">
                                    <tr>
                                        <td align="left" valign="top">
                                            <font size="3" color="#333" face="verdana"><img height="150"  src="http://britishgame.projectstatus.in/resources/dashboard/images/mail-cartoon.png"></font><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom: solid 1px #000"  align="center" valign="top">
                                            <font size="4" color="#333" face="verdana"><strong>Culture Buff Games</strong></font><br><br>
                                            <a href="www.culturebuffgames.com" style="color: #000;">www.culturebuffgames.com</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <table border="0" cellspacing="0" cellpadding="0" width="600">
                                                <tr>
                                                    <td align="left" valign="top">
                                                        <font size="3" color="#333" face="verdana"><strong>Sold To:</strong></font><br><br>
                                                        <font size="2" color="#333" face="verdana">{{$data['users_infos']['first_name']}}  {{$data['users_infos']['last_name']}}</font><br>
                                                        <font size="2" color="#333" face="verdana">@if(!empty($data['users_infos']['company_name'])) {{$data['users_infos']['company_name']}} @endif</font><br>
                                                        <font size="2" color="#333" face="verdana">Email: {{$data['email']}} </font><br>
                                                    </td>
                                                    <td align="left" valign="top">
                                                        <table cellpadding="0" cellspacing="0" width="200">
                                                            <tr>
                                                                <td align="left" valign="top"><font size="3" color="#333" face="verdana"><strong>Purchase Date:</strong></font></td>
                                                                <td align="left" valign="top"><font size="2" color="#333" face="verdana">{{$data['invoiceData']['purchase_date']}}</font></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <table cellpadding="0" cellspacing="0" width="500">
                                                <tr>
                                                    <td width="29%" align="left" valign="top"><font size="3" color="#333" face="verdana"><strong>Invoice Number:</strong></font></td>
                                                    <td width="71%" align="left" valign="top"><font size="2" color="#333" face="verdana"> {{$data['invoiceData']['invoice_number']}} </font></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <font size="3" color="#000" face="verdana">Thanks for purchasing the following games!</font><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <table border="0" cellspacing="0" cellpadding="10" width="500">
                                                <tr>
                                                    <td align="center" valign="top" bgcolor="#27ace8" style="background-color:#27ace8;"><font size="2" color="#fff" face="verdana"> <strong>Game Title</strong></font></td>
                                                    <td align="center" valign="top"  bgcolor="#27ace8" style="background-color:#27ace8;"><font size="2" color="#fff" face="verdana"><strong>Unit Price</strong></font></td>
                                                    <td align="center" valign="top"  bgcolor="#27ace8" style="background-color:#27ace8;"><font size="2" color="#fff" face="verdana"><strong>Currency</strong></font></td>
                                                    <td align="center" valign="top"  bgcolor="#27ace8" style="background-color:#27ace8;"><font size="2" color="#fff" face="verdana"><strong>No.Of Licenses</strong></font></td>
                                                    <td align="center" valign="top"  bgcolor="#27ace8" style="background-color:#27ace8;"><font size="2" color="#fff" face="verdana"><strong>Expiration Date</strong></font></td>
                                                    <td align="center" valign="top"  bgcolor="#27ace8" style="background-color:#27ace8;"><font size="2" color="#fff" face="verdana"><strong>Sub-Total</strong></font></td>
                                                </tr>
                                                @foreach($data['invoiceData']['orderSaveData'] as $key => $value)
                                                <tr>
                                                    <td align="center" valign="top" style="border-right:solid 1px #CCC; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC"><font size="2" color="#000" face="verdana"><strong> {{$value['licence_type']}}</strong>  </font></td>
                                                    <td align="center" valign="top" style="border-right:solid 1px #CCC; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC"><font size="2" color="#000" face="verdana"><strong> {{$value['licence_price']}}</strong> </font></td>
                                                    <td align="center" valign="top"  style="border-right:solid 1px #CCC; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC"><font size="2" color="#000" face="verdana"><strong> {{$value['currency']}} </strong></font></td>
                                                    <td align="center" valign="top"  style="border-right:solid 1px #CCC; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC"><font size="2" color="#000" face="verdana"><strong> {{$value['numbers']}}</strong> </font></td>
                                                    <td align="center" valign="top"  style="border-right:solid 1px #CCC; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC"><font size="2" color="#000" face="verdana"><strong> {{$value['licence_valid_till']}} </strong> </font></td>
                                                    <td align="center" valign="top"  style="border-right:solid 1px #CCC; border-left:solid 1px #CCC;border-bottom:solid 1px #CCC"><font size="2" color="#000" face="verdana"><strong> {{$value['subtotal']}} </strong> </font></td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right" valign="top">
                                            <table cellpadding="0" cellspacing="0" width="500">
                                                <tr>
                                                    <td width="81%" align="right" valign="top"><font size="3" color="#000" face="verdana"><strong>Invoice Total:</strong></font></td>
                                                    <td width="19%" align="right" valign="top"><font size="3" color="#000" face="verdana">{{$data['invoiceData']['total_price']}} GBP</font></td>
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