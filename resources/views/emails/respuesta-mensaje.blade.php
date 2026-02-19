<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
</head>
<body style="margin:0; padding:0; background:#f4f4f4; font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4; padding:30px 0;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 8px 25px rgba(0,0,0,0.1);">

<!-- HEADER -->
<tr>
<td align="center" style="background:linear-gradient(135deg,#7b1e3a,#4a0f23); padding:25px;">
    <img src="{{ url('images/logos/cpap-logo.jpg') }}"
         width="70"
         alt="CPAP Logo"
         style="display:block; margin-bottom:10px;">
    <h2 style="color:#ffffff; margin:0; font-size:18px;">
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

<h3 style="color:#7b1e3a; margin-top:0;">
Respuesta a tu mensaje
</h3>

<p>Estimado/a <strong>{{ $messageData->nombre }}</strong>,</p>

<p>Hemos recibido tu mensaje y te respondemos a continuación:</p>

<div style="margin-top:20px; padding:15px; background:#f9f9f9; border-left:4px solid #7b1e3a; border-radius:8px;">
    {{ $messageData->respuesta }}
</div>

<p style="margin-top:25px;">
Si tienes alguna consulta adicional, puedes comunicarte con nosotros.
</p>

<p style="margin-top:30px;">
Atentamente,<br>
<strong>CPAP Región Centro</strong>
</p>

</td>
</tr>

<!-- FOOTER -->
<tr>
<td align="center" style="background:#f4f4f4; padding:15px; font-size:12px; color:#777;">
Este correo fue enviado automáticamente desde el sistema institucional CPAP.
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>
