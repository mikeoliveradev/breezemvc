/**
 * Form Validator Client-Side
 * Sistema de validación JavaScript para formularios
 * Compatible con Validator.php del servidor
 * 
 * Uso:
 * 1. Añade atributo data-validate a los inputs
 * 2. Llama initFormValidation() al cargar la página
 * 
 * @version 1.0
 * @author Mike Olivera mikeolivera.com
 */

// ============================================
// CONFIGURACIÓN
// ============================================

const VALIDATOR_CONFIG = {
    errorClass: 'is-invalid',
    successClass: 'is-valid',
    errorMessageClass: 'invalid-feedback',
    showSuccessState: true,
    validateOnBlur: true,
    validateOnInput: false
};

// ============================================
// REGLAS DE VALIDACIÓN
// ============================================

const ValidationRules = {
    /**
     * Campo requerido
     */
    required: (value) => {
        return value.trim().length > 0;
    },

    /**
     * Email válido
     */
    email: (value) => {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(value);
    },

    /**
     * Longitud mínima
     */
    min: (value, param) => {
        return value.length >= parseInt(param);
    },

    /**
     * Longitud máxima
     */
    max: (value, param) => {
        return value.length <= parseInt(param);
    },

    /**
     * Solo números
     */
    numeric: (value) => {
        return /^\d+$/.test(value);
    },

    /**
     * Coincide con otro campo
     */
    match: (value, param, form) => {
        const otherField = form.querySelector(`[name="${param}"]`);
        return otherField && value === otherField.value;
    },

    /**
     * Patrón regex personalizado
     */
    regex: (value, param) => {
        const regex = new RegExp(param);
        return regex.test(value);
    },

    /**
     * URL válida
     */
    url: (value) => {
        try {
            new URL(value);
            return true;
        } catch {
            return false;
        }
    },

    /**
     * Fecha válida (YYYY-MM-DD)
     */
    date: (value) => {
        const regex = /^\d{4}-\d{2}-\d{2}$/;
        if (!regex.test(value)) return false;
        const date = new Date(value);
        return date instanceof Date && !isNaN(date);
    }
};

// ============================================
// MENSAJES DE ERROR
// ============================================

const ErrorMessages = {
    required: 'Este campo es requerido',
    email: 'Ingresa un email válido',
    min: 'Debe tener al menos {param} caracteres',
    max: 'No puede exceder {param} caracteres',
    numeric: 'Solo se permiten números',
    match: 'Los campos no coinciden',
    regex: 'Formato inválido',
    url: 'Ingresa una URL válida',
    date: 'Ingresa una fecha válida'
};

// ============================================
// FUNCIONES PRINCIPALES
// ============================================

/**
 * Inicializa la validación de formularios
 */
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('[data-validate]');
        
        inputs.forEach(input => {
            // Validar en blur
            if (VALIDATOR_CONFIG.validateOnBlur) {
                input.addEventListener('blur', () => validateField(input, form));
            }
            
            // Validar en input (opcional)
            if (VALIDATOR_CONFIG.validateOnInput) {
                input.addEventListener('input', () => validateField(input, form));
            }
        });
        
        // Validar al enviar
        form.addEventListener('submit', (e) => {
            if (!validateForm(form)) {
                e.preventDefault();
            }
        });
    });
}

/**
 * Valida un campo individual
 */
function validateField(input, form) {
    const rules = input.getAttribute('data-validate').split('|');
    const errors = [];
    
    for (const rule of rules) {
        const [ruleName, param] = rule.split(':');
        
        if (ValidationRules[ruleName]) {
            const isValid = ValidationRules[ruleName](input.value, param, form);
            
            if (!isValid) {
                let message = ErrorMessages[ruleName] || 'Campo inválido';
                message = message.replace('{param}', param);
                errors.push(message);
            }
        }
    }
    
    showFieldErrors(input, errors);
    return errors.length === 0;
}

/**
 * Valida todo el formulario
 */
function validateForm(form) {
    const inputs = form.querySelectorAll('[data-validate]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!validateField(input, form)) {
            isValid = false;
        }
    });
    
    return isValid;
}

/**
 * Muestra errores en un campo
 */
function showFieldErrors(input, errors) {
    // Limpiar estados previos
    input.classList.remove(VALIDATOR_CONFIG.errorClass, VALIDATOR_CONFIG.successClass);
    
    // Eliminar mensajes de error previos
    const existingError = input.parentElement.querySelector(`.${VALIDATOR_CONFIG.errorMessageClass}`);
    if (existingError) {
        existingError.remove();
    }
    
    if (errors.length > 0) {
        // Mostrar error
        input.classList.add(VALIDATOR_CONFIG.errorClass);
        
        const errorDiv = document.createElement('div');
        errorDiv.className = VALIDATOR_CONFIG.errorMessageClass;
        errorDiv.textContent = errors[0];
        input.parentElement.appendChild(errorDiv);
    } else if (input.value.trim().length > 0 && VALIDATOR_CONFIG.showSuccessState) {
        // Mostrar éxito
        input.classList.add(VALIDATOR_CONFIG.successClass);
    }
}

// ============================================
// FORMATOS AUTOMÁTICOS
// ============================================

/**
 * Convierte texto a mayúsculas
 */
function toUpperCase(input) {
    input.value = input.value.toUpperCase();
}

/**
 * Convierte texto a minúsculas
 */
function toLowerCase(input) {
    input.value = input.value.toLowerCase();
}

/**
 * Capitaliza cada palabra
 */
function toCapitalize(input) {
    const words = input.value.split(' ');
    const capitalized = words.map(word => {
        if (word.length > 0) {
            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
        }
        return word;
    });
    input.value = capitalized.join(' ');
}

/**
 * Solo permite números
 */
function onlyNumbers(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
}

/**
 * Solo permite letras
 */
function onlyLetters(input) {
    input.value = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
}

/**
 * Solo permite alfanuméricos
 */
function onlyAlphanumeric(input) {
    input.value = input.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]/g, '');
}

/**
 * Limita longitud máxima
 */
function maxLength(input, length) {
    if (input.value.length > length) {
        input.value = input.value.slice(0, length);
    }
}

// ============================================
// VALIDACIONES ESPECÍFICAS
// ============================================

/**
 * Valida RFC mexicano (13 caracteres)
 */
function validateRFC(input) {
    input.value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    maxLength(input, 13);
}

/**
 * Valida CURP mexicano (18 caracteres)
 */
function validateCURP(input) {
    input.value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    maxLength(input, 18);
}

/**
 * Valida teléfono (10 dígitos)
 */
function validatePhone(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
    maxLength(input, 10);
}

/**
 * Valida código postal (5 dígitos)
 */
function validateZipCode(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
    maxLength(input, 5);
}

// ============================================
// UTILIDADES
// ============================================

/**
 * Muestra/oculta contraseña
 */
function togglePasswordVisibility(buttonId, inputId) {
    const button = document.getElementById(buttonId);
    const input = document.getElementById(inputId);
    
    if (button && input) {
        button.addEventListener('click', () => {
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            button.textContent = type === 'password' ? '👁️' : '🙈';
        });
    }
}

/**
 * Valida fecha no futura
 */
function validateDateNotFuture(input) {
    const inputDate = new Date(input.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    if (inputDate > today) {
        showFieldErrors(input, ['La fecha no puede ser futura']);
        return false;
    }
    return true;
}

/**
 * Calcula edad desde fecha de nacimiento
 */
function calculateAge(birthDate) {
    const today = new Date();
    const birth = new Date(birthDate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    
    return age;
}

// ============================================
// INICIALIZACIÓN AUTOMÁTICA
// ============================================

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFormValidation);
} else {
    initFormValidation();
}

// Exportar funciones para uso global
window.FormValidator = {
    init: initFormValidation,
    validateField,
    validateForm,
    toUpperCase,
    toLowerCase,
    toCapitalize,
    onlyNumbers,
    onlyLetters,
    onlyAlphanumeric,
    validateRFC,
    validateCURP,
    validatePhone,
    validateZipCode,
    togglePasswordVisibility,
    calculateAge
};
