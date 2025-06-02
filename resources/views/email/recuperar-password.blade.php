<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
</head>
<body style="margin: 0; padding: 0; background-color: #004467; font-family: Arial, sans-serif;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding: 20px;">
                <!-- Logo fuera de la tabla principal -->
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="text-align: center; padding-bottom: 20px;">
                    <tr>
                        <td align="center">
                            <img src="{{asset('images/logo_cenace_white.png')}}" alt="Logo" width="200">
                        </td>
                    </tr>
                </table>
                
                <table role="presentation" width="100%" max-width="600px" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; border-radius: 10px; padding: 30px; text-align: center;">
                    <tr>
                        <td align="center" style="font-size: 20px; font-weight: bold; color: #004467;">
                            Código para recuperar contraseña
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size: 32px; font-weight: bold; color: #000000; padding: 10px 0;">
                            {{$codigo}}
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size: 16px; color: #555555; padding-bottom: 20px;">
                            Este código le servirá para crear una nueva contraseña.
                        </td>
                    </tr>
                </table>
                
                <p style="color: #ffffff; font-size: 14px; padding-top: 20px;">{{ date('Y') }} © Cenace</p>
            </td>
        </tr>
    </table>

</body>
</html>
