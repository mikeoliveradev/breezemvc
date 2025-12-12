<?php
// Template: Email de Bienvenida
// Variables esperadas: $nombre
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
        .feature { background-color: #f9f9f9; padding: 15px; border-left: 4px solid #667eea; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Bienvenido!</h1>
        </div>
        
        <div class="body">
            <h2>Hola, <?php echo htmlspecialchars($nombre ?? 'Usuario'); ?>!</h2>
            
            <p>¡Gracias por registrarte! Estamos emocionados de tenerte con nosotros.</p>
            
            <p>Tu cuenta ha sido creada exitosamente y ya puedes comenzar a usar todas nuestras funcionalidades.</p>
            
            <div class="feature">
                <strong>✨ Características principales:</strong>
                <ul>
                    <li>Acceso completo a todas las funcionalidades</li>
                    <li>Soporte técnico 24/7</li>
                    <li>Actualizaciones automáticas</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="<?php echo htmlspecialchars($login_url ?? '/auth/login'); ?>" class="btn">
                    Iniciar Sesión
                </a>
            </div>
            
            <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
            
            <p>¡Bienvenido a bordo!<br>El equipo</p>
        </div>
        
        <div class="footer">
            <p>Este es un email automático, por favor no respondas a este mensaje.</p>
            <p>&copy; <?php echo date('Y'); ?> Tu Aplicación. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
