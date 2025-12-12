<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $subject ?? 'Email'; ?></title>
    <style>
        /* Reset básico */
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f4f4f4;
        }
        
        /* Container principal */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            text-align: center;
        }
        
        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
        }
        
        /* Body */
        .email-body {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.6;
        }
        
        .email-body h2 {
            color: #667eea;
            margin-top: 0;
        }
        
        .email-body p {
            margin: 15px 0;
        }
        
        /* Botón */
        .btn {
            display: inline-block;
            padding: 14px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: 600;
        }
        
        /* Footer */
        .email-footer {
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
            color: #999999;
            font-size: 12px;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1><?php echo $app_name ?? 'Tu Aplicación'; ?></h1>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <?php echo $content ?? ''; ?>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p>Este es un email automático, por favor no respondas a este mensaje.</p>
            <p>&copy; <?php echo date('Y'); ?> <?php echo $app_name ?? 'Tu Aplicación'; ?>. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
