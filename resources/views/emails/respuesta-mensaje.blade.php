<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body style="margin:0; padding:0; background:#f4f4f4; font-family:'Arial', 'Helvetica', sans-serif; width:100%;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4; padding:30px 0; mso-table-lspace:0pt; mso-table-rspace:0pt;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden; mso-table-lspace:0pt; mso-table-rspace:0pt;">

<!-- HEADER -->
<tr>
<td align="center" style="background-color:#7b1e3a; padding:25px; mso-padding-alt:25px;">
    <img src="{{ url('images/logos/cpap-logo.jpg') }}"
         width="70"
         height="70"
         alt="CPAP Logo"
         style="display:block; margin-bottom:10px; border:0;">
    <h2 style="color:#ffffff; margin:0; font-size:18px; font-weight:bold;">
        Colegio Profesional de Antropólogos del Perú
    </h2>
    <p style="color:#f8d7da; margin:5px 0 0 0; font-size:13px;">
        Región Centro
    </p>
</td>
</tr>

<!-- BODY -->
<tr>
<td style="padding:30px;">

<h3 style="color:#7b1e3a; margin-top:0; font-weight:bold;">
Respuesta a tu mensaje
</h3>

<p>Estimado/a <strong>{{ $nombre }}</strong>,</p>

<p>Hemos recibido tu mensaje y te respondemos a continuación:</p>

<div style="margin-top:20px; padding:15px; background:#f9f9f9; border-left:4px solid #7b1e3a; border-radius:8px; word-wrap:break-word; white-space:pre-wrap;">
    {!! nl2br(e($respuesta)) !!}
</div>

<p style="margin-top:25px; line-height:1.6;">
Si tienes alguna consulta adicional, puedes comunicarte con nosotros.
</p>

<p style="margin-top:30px; line-height:1.6;">
Atentamente,<br>
<strong>CPAP Región Centro</strong>
</p>

</td>
</tr>

<!-- FOOTER -->
<tr>
<td align="center" style="background:#f4f4f4; padding:15px; font-size:12px; color:#777; line-height:1.5;">
Este correo fue enviado automáticamente desde el sistema institucional CPAP. Por favor, no responder directamente a este correo.
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>
