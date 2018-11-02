<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no"/>
    <title>@lang('passwords.reset_pwd')</title>
</head>
<body topmargin="0" rightmargin="0" bottommargin="0" leftmargin="0" marginwidth="0" marginheight="0" width="100%" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%; height: 100%; -webkit-font-smoothing: antialiased; text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 100%;background-color: #f0f0f0; color: #000000;" bgcolor="#bdbdbd" text="#000000">
    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%;">
        <tr>
            <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;" bgcolor="#F0F0F0">
                <table border="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit; max-width: 560px; margin-top: 40px">
                    <!-- Header -->
                    <tr>
                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 22px; font-weight: bold; line-height: 130%; padding-top: 25px; color: #312a58; font-family: sans-serif">
                            <img border="0" vspace="0" hspace="0" style="padding: 0; margin: 0 0 13px 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block; color: #000000;" src="{{ asset('storage/other/logo.png') }}" alt="logo" width="50">
                            @lang('passwords.reset_pwd')
                        </td>
                    </tr>
                    <!-- Message -->
                    <tr>
                        <td align="justify" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%; padding-top: 25px; color: #000000; font-family: sans-serif">
                            @lang('passwords.we_got_request', ['username' => $user->username])
                        </td>
                    </tr>
                    <!-- Button -->
                    <tr>
                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; padding-top: 25px; padding-bottom: 5px;">
                            <a href="{{ $url }}" target="_blank" style="font-family: sans-serif">
                                {{ $url }}
                            </a>
                        </td>
                    </tr>
                    <!-- Line -->
                    <tr>
                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; padding-top: 25px">
                            <hr color="#999999" align="center" width="100%" size="1" noshade style="margin: 0; padding: 0;" />
                        </td>
                    </tr>
                </table>
                <!-- Footer -->
                <table border="0" cellpadding="0" cellspacing="0" align="center" width="560" style="border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit; max-width: 560px">
                    <tr>
                        <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 13px; font-weight: 400; line-height: 150%; padding-top: 20px; padding-bottom: 20px; color: #555555; font-family: sans-serif;">
                            @lang('passwords.ignore_if_not_you')
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>