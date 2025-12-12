<?php
// src/integrations/GoogleAuth.php

namespace src\integrations;

/**
 * Wrapper para Google OAuth 2.0 sin dependencias externas.
 * Usa cURL para comunicarse con la API de Google.
 */
class GoogleAuth
{
    // =============================================
    // CONFIGURACIÓN - REEMPLAZAR CON TUS CREDENCIALES
    // =============================================
    
    // Obtén estas credenciales en: https://console.cloud.google.com/
    private const GOOGLE_CLIENT_ID = 'TU_CLIENT_ID.apps.googleusercontent.com';
    private const GOOGLE_CLIENT_SECRET = 'TU_CLIENT_SECRET';
    private const GOOGLE_REDIRECT_URI = 'http://localhost/auth/googleCallback';
    
    // URLs de Google OAuth
    private const GOOGLE_AUTH_URL = 'https://accounts.google.com/o/oauth2/v2/auth';
    private const GOOGLE_TOKEN_URL = 'https://oauth2.googleapis.com/token';
    private const GOOGLE_USERINFO_URL = 'https://www.googleapis.com/oauth2/v2/userinfo';

    /**
     * Genera la URL de autorización de Google.
     * Redirige al usuario a esta URL para que autorice la aplicación.
     * 
     * @return string URL de autorización
     */
    public static function getAuthUrl(): string
    {
        $params = [
            'client_id' => self::GOOGLE_CLIENT_ID,
            'redirect_uri' => self::GOOGLE_REDIRECT_URI,
            'response_type' => 'code',
            'scope' => 'email profile',
            'access_type' => 'online',
            'prompt' => 'select_account'
        ];

        return self::GOOGLE_AUTH_URL . '?' . http_build_query($params);
    }

    /**
     * Intercambia el código de autorización por un token de acceso.
     * 
     * @param string $code Código recibido de Google
     * @return array|null Array con access_token o null si falla
     */
    public static function getAccessToken(string $code): ?array
    {
        $params = [
            'code' => $code,
            'client_id' => self::GOOGLE_CLIENT_ID,
            'client_secret' => self::GOOGLE_CLIENT_SECRET,
            'redirect_uri' => self::GOOGLE_REDIRECT_URI,
            'grant_type' => 'authorization_code'
        ];

        $ch = curl_init(self::GOOGLE_TOKEN_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            error_log("Google OAuth Token Error: " . $response);
            return null;
        }

        return json_decode($response, true);
    }

    /**
     * Obtiene la información del usuario desde Google.
     * 
     * @param string $accessToken Token de acceso
     * @return array|null Datos del usuario (id, email, name, picture) o null si falla
     */
    public static function getUserInfo(string $accessToken): ?array
    {
        $ch = curl_init(self::GOOGLE_USERINFO_URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            error_log("Google UserInfo Error: " . $response);
            return null;
        }

        return json_decode($response, true);
    }
}
