<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns:v='urn:schemas-microsoft-com:vml'>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <!--[if !mso]--><!-- -->
    <link href='https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Quicksand:300,400,700' rel='stylesheet'>
    <!--<![endif]-->
    <title>Top Savers</title>
    <style type='text/css'>
        /* Your CSS unchanged */
    </style>
</head>

<body class='respond' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>
    <table border='0' width='100%' cellpadding='0' cellspacing='0' bgcolor='#ffffff'>
        <!-- Header Section -->
        <tr>
            <td align='center'>
                <table border='0' width='590' cellpadding='0' cellspacing='0' class='container590'>
                    <tr>
                        <td height='25' style='font-size: 25px; line-height: 25px;'>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align='center'>
                            <a href=''><img width='300' border='0' style='display: block; width: 300px; margin: 0 auto;' src='{{ asset('logo.png') }}' alt=''></a>
                            <img src='{{ asset('thumbup.png') }}' style='width: 40px; height: 40px;' alt='Thumbs Up'>
                        </td>
                    </tr>
                    <tr>
                        <td height='25' style='font-size: 25px; line-height: 25px;'>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Content Section -->
        <tr>
            <td align='center' style='padding: 0 15px;'>
                <table border='0' width='590' cellpadding='0' cellspacing='0' class='container590'>
                    <tr>
                        <td align='center' style='color: #888888; font-size: 16px; font-family: "Work Sans", Calibri, sans-serif; line-height: 24px;'>
                            <h2 style='margin-bottom: 15px;'>Transaction Approval!</h2>
                            <p style='line-height: 24px; margin-bottom: 15px;'>
                                Your ${{ $data['amount'] }} for {{ $data['transactionType'] }} 
                                with Transaction ID <strong>{{ $data['transactionId'] }}</strong> has been approved successfully.
                            </p>
                            <p style='line-height: 24px;'>Kind Regards,<br/>Top Savers</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Footer Section -->
        <tr>
            <td align='center'>
                <table border='0' width='590' cellpadding='0' cellspacing='0' class='container590' bgcolor='#f4f4f4'>
                    <tr>
                        <td height='25' style='font-size: 25px; line-height: 25px;'>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align='center' style='color: #aaaaaa; font-size: 14px; font-family: "Work Sans", Calibri, sans-serif; line-height: 24px;'>
                            <div style='line-height: 24px;'>
                                <span style='color: #333333;'>Copyright 2024 - All Rights Reserved</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align='center' style='font-size: 14px; font-family: "Work Sans", Calibri, sans-serif; line-height: 24px;'>
                            <a href='' style='color: #5caad2; text-decoration: none; font-weight: bold;'>UNSUBSCRIBE</a>
                        </td>
                    </tr>
                    <tr>
                        <td height='25' style='font-size: 25px; line-height: 25px;'>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
