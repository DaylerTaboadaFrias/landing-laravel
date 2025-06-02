<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo curso disponible</title>
</head>
<body style="margin: 0; padding: 0; background-color: #004467; font-family: Arial, sans-serif;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding: 20px;">
          
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="text-align: center; padding-bottom: 20px;">
                    <tr>
                        <td align="center">
                            <img src="{{asset('images/logo_cenace_white.png')}}" alt="Logo" width="200">
                        </td>
                    </tr>
                </table>
                
                <table role="presentation" width="100%" max-width="600px" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; border-radius: 10px; padding: 30px; text-align: left;">
                    <tr>
                        <td style="font-size: 20px; font-weight: bold; color: #555555;text-align: center;">
                            ¡Tenemos un nuevo curso disponible!
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family: 'Lato', sans-serif; font-size:14px; color:#000; line-height:24px; font-weight: 300;padding-left: 20px;padding-right: 20px;text-align: center;">
                        <img style="line-height:0px; font-size:0px; border:0px;" src="{{asset($curso->imagen)}}" width="490" height="218" alt="logo">
                        </td>
                    </tr>
                    <tr>
                         <td height="5"></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px; color: #555555; padding: 10px 0;">
                            Estimado/a,
                            Te informamos que tenemos un nuevo curso disponible <strong>{{$curso->nombre}}</strong> de <strong>{{$curso->rango_fechas}}</strong> con un precio de <strong>{{$curso->precio_descuento}}</strong>. <br>
                        </td>
                    </tr>
                  <tr>
                     <td>
                        <br>
                        <a href="{{$url.'/detalle-curso/'.$curso->id}}"
                        style="display: inline-block;
                        text-decoration: none; 
                        font-weight: 400;
                        text-align: center;
                        border: 1px solid transparent;
                        padding: .375rem .75rem;
                        font-size: 1rem;
                        line-height: 1.5;
                        border-radius: 1.25rem;
                        color: #fff;
                        background-color: #004467;
                         margin-right: 20px;
                         margin-bottom: 20px;
                        "
                        >Ver curso</a >
                     </td>
                  </tr>
                </table>
                
                <p style="color: #ffffff; font-size: 14px; padding-top: 20px;">{{ date('Y') }} © Campos de Solana</p>
            </td>
        </tr>
    </table>

</body>
</html>
