<?php
// Template: Recuperación de Contraseña
// Variables esperadas: $nombre, $token, $url
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 20px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; }
        .body { padding: 40px 30px; color: #333333; line-height: 1.6; }
        .body h2 { color: #667eea; margin-top: 0; }
        .btn { display: inline-block; padding: 14px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff !important; text-decoration: none; border-radius: 8px; margin: 20px 0; font-weight: 600; }
        .footer { background-color: #f8f8f8; padding: 20px; text-align: center; color: #999999; font-size: 12px; }
        .code { background-color: #f5f5f5; padding: 15px; border-radius: 5px; font-family: monospace; font-size: 18px; letter-spacing: 2px; text-align: center; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Recuperación de Contraseña</h1>
        </div>
        
        <div class="body">
            <h2>Hola, <?php echo htmlspecialchars($nombre ?? 'Usuario'); ?>!</h2>
            
            <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta.</p>
            
            <p>Haz clic en el siguiente botón para crear una nueva contraseña:</p>
            
            <div style="text-align: center;">
                <a href="<?php echo htmlspecialchars($url ?? '#'); ?>" class="btn">
                    Restablecer Contraseña
                </a>
            </div>
            
            <p>O copia y pega este enlace en tu navegador:</p>
            <div class="code">
                <?php echo htmlspecialchars($url ?? '#'); ?>
            </div>
            
            <p><strong>Este enlace expirará en 1 hora.</strong></p>
            
            <p>Si no solicitaste restablecer tu contraseña, puedes ignorar este email de forma segura.</p>
            
            <p>Saludos,<br>El equipo de soporte</p>
        </div>
        
        <div class="footer">
            <p>Este es un email automático, por favor no respondas a este mensaje.</p>
            <p>&copy; <?php echo date('Y'); ?> Tu Aplicación. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
