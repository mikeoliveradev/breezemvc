<?php
// src/utils/Validator.php

namespace src\utils;

use src\config\Database;

/**
 * Sistema de validación de formularios con API fluida.
 * Permite validar datos de entrada con reglas comunes.
 */
class Validator
{
    private array $data;
    private array $errors = [];
    private array $messages = [];

    /**
     * Mensajes de error por defecto en español.
     */
    private array $defaultMessages = [
        'required' => 'El campo :field es obligatorio.',
        'email' => 'El campo :field debe ser un email válido.',
        'min' => 'El campo :field debe tener al menos :min caracteres.',
        'max' => 'El campo :field no debe exceder :max caracteres.',
        'numeric' => 'El campo :field debe ser numérico.',
        'match' => 'El campo :field debe coincidir con :other.',
        'unique' => 'El :field ya está registrado.',
        'regex' => 'El formato del campo :field no es válido.'
    ];

    /**
     * Constructor.
     * @param array $data Datos a validar (generalmente $_POST)
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Valida que los campos especificados no estén vacíos.
     * @param array $fields Lista de nombres de campos
     * @return self
     */
    public function required(array $fields): self
    {
        foreach ($fields as $field) {
            if (!isset($this->data[$field]) || trim($this->data[$field]) === '') {
                $this->addError($field, 'required');
            }
        }
        return $this;
    }

    /**
     * Valida que el campo sea un email válido.
     * @param string $field Nombre del campo
     * @return self
     */
    public function email(string $field): self
    {
        if (isset($this->data[$field]) && !empty($this->data[$field])) {
            if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
                $this->addError($field, 'email');
            }
        }
        return $this;
    }

    /**
     * Valida longitud mínima del campo.
     * @param string $field Nombre del campo
     * @param int $length Longitud mínima
     * @return self
     */
    public function min(string $field, int $length): self
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->addError($field, 'min', ['min' => $length]);
        }
        return $this;
    }

    /**
     * Valida longitud máxima del campo.
     * @param string $field Nombre del campo
     * @param int $length Longitud máxima
     * @return self
     */
    public function max(string $field, int $length): self
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $this->addError($field, 'max', ['max' => $length]);
        }
        return $this;
    }

    /**
     * Valida que el campo sea numérico.
     * @param string $field Nombre del campo
     * @return self
     */
    public function numeric(string $field): self
    {
        if (isset($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->addError($field, 'numeric');
        }
        return $this;
    }

    /**
     * Valida que dos campos coincidan.
     * @param string $field Nombre del primer campo
     * @param string $otherField Nombre del segundo campo
     * @return self
     */
    public function match(string $field, string $otherField): self
    {
        if (isset($this->data[$field]) && isset($this->data[$otherField])) {
            if ($this->data[$field] !== $this->data[$otherField]) {
                $this->addError($field, 'match', ['other' => $otherField]);
            }
        }
        return $this;
    }

    /**
     * Valida que el valor sea único en la base de datos.
     * @param string $field Nombre del campo
     * @param string $table Nombre de la tabla
     * @param string $column Nombre de la columna (por defecto usa el nombre del campo)
     * @param int|null $excludeId ID a excluir (útil para updates)
     * @return self
     */
    public function unique(string $field, string $table, string $column = null, ?int $excludeId = null): self
    {
        if (!isset($this->data[$field]) || empty($this->data[$field])) {
            return $this;
        }

        $column = $column ?? $field;
        $value = $this->data[$field];

        $conn = Database::getConnection();
        
        if ($excludeId) {
            $sql = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ? AND id != ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $value, $excludeId);
        } else {
            $sql = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $value);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row['count'] > 0) {
            $this->addError($field, 'unique');
        }

        return $this;
    }

    /**
     * Valida con una expresión regular personalizada.
     * @param string $field Nombre del campo
     * @param string $pattern Patrón regex
     * @return self
     */
    public function regex(string $field, string $pattern): self
    {
        if (isset($this->data[$field]) && !preg_match($pattern, $this->data[$field])) {
            $this->addError($field, 'regex');
        }
        return $this;
    }

    /**
     * Añade un error a la lista.
     * @param string $field Nombre del campo
     * @param string $rule Nombre de la regla
     * @param array $params Parámetros adicionales para el mensaje
     */
    private function addError(string $field, string $rule, array $params = []): void
    {
        $message = $this->messages[$field][$rule] ?? $this->defaultMessages[$rule] ?? 'Error de validación.';
        
        // Reemplazar placeholders
        $message = str_replace(':field', $field, $message);
        foreach ($params as $key => $value) {
            $message = str_replace(":{$key}", $value, $message);
        }

        $this->errors[$field][] = $message;
    }

    /**
     * Personaliza mensajes de error.
     * @param array $messages Array de mensajes ['campo.regla' => 'Mensaje']
     * @return self
     */
    public function messages(array $messages): self
    {
        foreach ($messages as $key => $message) {
            [$field, $rule] = explode('.', $key);
            $this->messages[$field][$rule] = $message;
        }
        return $this;
    }

    /**
     * Verifica si la validación falló.
     * @return bool
     */
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Verifica si la validación pasó.
     * @return bool
     */
    public function passes(): bool
    {
        return empty($this->errors);
    }

    /**
     * Obtiene todos los errores.
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Obtiene el primer error de todos los campos.
     * @return string|null
     */
    public function firstError(): ?string
    {
        if (empty($this->errors)) {
            return null;
        }

        $firstField = array_key_first($this->errors);
        return $this->errors[$firstField][0] ?? null;
    }

    /**
     * Obtiene el primer error de un campo específico.
     * @param string $field Nombre del campo
     * @return string|null
     */
    public function firstErrorFor(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }

    /**
     * Obtiene todos los errores de un campo específico.
     * @param string $field Nombre del campo
     * @return array
     */
    public function errorsFor(string $field): array
    {
        return $this->errors[$field] ?? [];
    }
}
