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
    <img src="{{ url('images/logos/cpap-logo.jpg') }}" width="70"
         alt="CPAP Logo"
         width="70"
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
Nuevo mensaje recibido desde la web institucional
</h3>

<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px; font-size:14px;">
<tr>
<td style="padding:8px 0;"><strong>Nombre:</strong></td>
<td style="padding:8px 0;">{{ $messageData->nombre }}</td>
</tr>

<tr>
<td style="padding:8px 0;"><strong>Email:</strong></td>
<td style="padding:8px 0;">{{ $messageData->email }}</td>
</tr>

<tr>
<td style="padding:8px 0;"><strong>Teléfono:</strong></td>
<td style="padding:8px 0;">{{ $messageData->telefono ?? 'No proporcionado' }}</td>
</tr>

<tr>
<td style="padding:8px 0;"><strong>Asunto:</strong></td>
<td style="padding:8px 0;">{{ $messageData->asunto }}</td>
</tr>
</table>

<div style="margin-top:25px; padding:15px; background:#f9f9f9; border-left:4px solid #7b1e3a; border-radius:8px;">
<strong>Mensaje:</strong>
<p style="margin-top:10px; line-height:1.6;">
{{ $messageData->mensaje }}
</p>
</div>

</td>
</tr>

<!-- FOOTER -->
<tr>
<td align="center" style="background:#f4f4f4; padding:15px; font-size:12px; color:#777;">
Este mensaje fue enviado automáticamente desde el sitio web oficial del CPAP Región Centro.
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>
