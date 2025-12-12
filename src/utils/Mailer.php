<?php
// src/utils/Mailer.php

namespace src\utils;

use src\config\Database;

/**
 * Wrapper híbrido para envío de emails.
 * Usa PHPMailer si está disponible, o mail() nativo como fallback.
 */
class Mailer
{
    private string $fromEmail = 'noreply@tudominio.com';
    private string $fromName = 'Tu Aplicación';
    private bool $usePHPMailer = false;
    private $phpMailer = null;

    public function __construct()
    {
        // Detectar si PHPMailer está disponible
        $phpMailerPath = __DIR__ . '/../../vendor/PHPMailer/src/PHPMailer.php';
        
        if (file_exists($phpMailerPath)) {
            try {
                require_once $phpMailerPath;
                require_once __DIR__ . '/../../vendor/PHPMailer/src/SMTP.php';
                require_once __DIR__ . '/../../vendor/PHPMailer/src/Exception.php';
                
                // Detectar versión: 6.x usa namespace, 5.x no
                if (class_exists('\\PHPMailer\\PHPMailer\\PHPMailer')) {
                    // PHPMailer 6.x (con namespace)
                    $this->usePHPMailer = true;
                    $this->phpMailer = new \PHPMailer\PHPMailer\PHPMailer(true);
                    $this->configurePHPMailer();
                } elseif (class_exists('PHPMailer')) {
                    // PHPMailer 5.x (sin namespace)
                    $this->usePHPMailer = true;
                    $this->phpMailer = new \PHPMailer(true);
                    $this->configurePHPMailer();
                }
            } catch (\Exception $e) {
                error_log("Mailer: Error cargando PHPMailer: " . $e->getMessage());
                $this->usePHPMailer = false;
            }
        }
    }

    /**
     * Configura PHPMailer con SMTP.
     */
    private function configurePHPMailer(): void
    {
        try {
            // Configuración SMTP
            $this->phpMailer->isSMTP();
            $this->phpMailer->Host = Database::SMTP_HOST;
            $this->phpMailer->SMTPAuth = true;
            $this->phpMailer->Username = Database::SMTP_USERNAME;
            $this->phpMailer->Password = Database::SMTP_PASSWORD;
            
            // Para PHPMailer 6.x usar constante, para 5.x usar string
            if (defined('PHPMailer\\PHPMailer\\PHPMailer::ENCRYPTION_STARTTLS')) {
                $this->phpMailer->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                $this->phpMailer->SMTPSecure = 'tls';
            }
            
            $this->phpMailer->Port = defined('src\\config\\Database::SMTP_PORT') ? Database::SMTP_PORT : 587;
            $this->phpMailer->CharSet = 'UTF-8';
            
            // Remitente por defecto
            $this->phpMailer->setFrom($this->fromEmail, $this->fromName);
        } catch (\Exception $e) {
            error_log("Mailer: Error configurando PHPMailer: " . $e->getMessage());
            $this->usePHPMailer = false;
        }
    }

    /**
     * Configura el remitente del email.
     * @param string $email Email del remitente
     * @param string $name Nombre del remitente
     * @return self
     */
    public function setFrom(string $email, string $name = ''): self
    {
        $this->fromEmail = $email;
        $this->fromName = $name ?: $email;
        
        if ($this->usePHPMailer) {
            try {
                $this->phpMailer->setFrom($email, $name);
            } catch (\Exception $e) {
                error_log("Mailer: Error en setFrom: " . $e->getMessage());
            }
        }
        
        return $this;
    }

    /**
     * Envía un email.
     * @param string $to Email del destinatario
     * @param string $subject Asunto del email
     * @param string $body Cuerpo del email
     * @param bool $isHtml Si el cuerpo es HTML (por defecto true)
     * @return bool True si se envió correctamente
     */
    public function send(string $to, string $subject, string $body, bool $isHtml = true): bool
    {
        // Validar email
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            error_log("Mailer: Email inválido: {$to}");
            return false;
        }

        if ($this->usePHPMailer) {
            return $this->sendWithPHPMailer($to, $subject, $body, $isHtml);
        } else {
            return $this->sendWithNativeMail($to, $subject, $body, $isHtml);
        }
    }

    /**
     * Envía email usando PHPMailer.
     */
    private function sendWithPHPMailer(string $to, string $subject, string $body, bool $isHtml): bool
    {
        try {
            $this->phpMailer->clearAddresses();
            $this->phpMailer->addAddress($to);
            $this->phpMailer->Subject = $subject;
            
            if ($isHtml) {
                $this->phpMailer->isHTML(true);
                $this->phpMailer->Body = $body;
                $this->phpMailer->AltBody = strip_tags($body);
            } else {
                $this->phpMailer->isHTML(false);
                $this->phpMailer->Body = $body;
            }

            $success = $this->phpMailer->send();
            
            if ($success) {
                error_log("Mailer: Email enviado con PHPMailer a {$to}");
            }
            
            return $success;
        } catch (\Exception $e) {
            error_log("Mailer: Error PHPMailer: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Envía email usando mail() nativo.
     */
    private function sendWithNativeMail(string $to, string $subject, string $body, bool $isHtml): bool
    {
        $headers = $this->buildHeaders($isHtml);
        $success = mail($to, $subject, $body, $headers);

        if (!$success) {
            error_log("Mailer: Error al enviar email nativo a {$to}");
        } else {
            error_log("Mailer: Email enviado con mail() nativo a {$to}");
        }

        return $success;
    }

    /**
     * Envía un email usando un template.
     * @param string $to Email del destinatario
     * @param string $subject Asunto del email
     * @param string $template Nombre del template (sin extensión)
     * @param array $data Datos para el template
     * @return bool True si se envió correctamente
     */
    public function sendTemplate(string $to, string $subject, string $template, array $data = []): bool
    {
        $body = $this->renderTemplate($template, $data);
        
        if (!$body) {
            error_log("Mailer: Error al renderizar template: {$template}");
            return false;
        }

        return $this->send($to, $subject, $body, true);
    }

    /**
     * Renderiza un template de email.
     * @param string $template Nombre del template
     * @param array $data Datos para el template
     * @return string|false HTML renderizado o false si falla
     */
    private function renderTemplate(string $template, array $data): string|false
    {
        $templatePath = __DIR__ . '/../../public/views/emails/' . $template . '.php';

        if (!file_exists($templatePath)) {
            error_log("Mailer: Template no encontrado: {$templatePath}");
            return false;
        }

        // Extraer datos para el template
        extract($data);

        // Capturar output del template
        ob_start();
        require $templatePath;
        $html = ob_get_clean();

        return $html;
    }

    /**
     * Construye los headers del email para mail() nativo.
     * @param bool $isHtml Si el email es HTML
     * @return string Headers formateados
     */
    private function buildHeaders(bool $isHtml): string
    {
        $headers = [];

        // From
        $headers[] = "From: {$this->fromName} <{$this->fromEmail}>";
        
        // Reply-To
        $headers[] = "Reply-To: {$this->fromEmail}";

        // Content-Type
        if ($isHtml) {
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-Type: text/html; charset=UTF-8";
        } else {
            $headers[] = "Content-Type: text/plain; charset=UTF-8";
        }

        // X-Mailer
        $headers[] = "X-Mailer: PHP/" . phpversion();

        return implode("\r\n", $headers);
    }

    /**
     * Verifica qué driver está usando.
     * @return string 'phpmailer' o 'native'
     */
    public function getDriver(): string
    {
        return $this->usePHPMailer ? 'phpmailer' : 'native';
    }

    /**
     * Envía un email de prueba.
     * Útil para verificar configuración.
     * @param string $to Email de prueba
     * @return bool
     */
    public static function sendTest(string $to): bool
    {
        $mailer = new self();
        $driver = $mailer->getDriver();
        
        $subject = "Email de Prueba - Driver: {$driver}";
        $body = "<h1>¡Funciona!</h1><p>El sistema de emails está configurado correctamente.</p><p><strong>Driver usado:</strong> {$driver}</p>";
        
        return $mailer->send($to, $subject, $body);
    }
}

