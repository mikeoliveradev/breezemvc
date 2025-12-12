/**
 * Form Formats - Sistema de Formatos Automáticos
 * Aplica formatos automáticos a campos usando el atributo idformatocampo
 * 
 * Uso:
 * <input type="text" idformatocampo="1" id="precio">
 * 
 * @version 1.0
 * @author Mike Olivera mikeolivera.com
 */

// ============================================
// FORMATOS DISPONIBLES
// ============================================

const FORMAT_TYPES = {
    1: 'onlyRealNumbers',        // Solo números reales (con decimales)
    2: 'onlyNaturalNumbers',     // Solo números naturales (enteros positivos)
    3: 'onlyAlphabetics',        // Solo letras
    4: 'toLowerCase',            // Convertir a minúsculas
    7: 'onlyAlphaNumeric',       // Alfanuméricos
    8: 'validateEmail',          // Validar email
    9: 'toUpperCase',            // Convertir a mayúsculas
    10: 'toCapitalize',          // Capitalizar palabras
    11: 'onlyAlphabeticsCapitalize', // Solo letras + capitalizar
    12: 'zipCode',               // Código postal (5 dígitos)
    13: 'phone',                 // Teléfono (10 dígitos)
    19: 'rfc',                   // RFC (13 caracteres)
    20: 'curp'                   // CURP/Clave Elector (18 caracteres)
};

// ============================================
// INICIALIZACIÓN
// ============================================

/**
 * Inicializa los formatos automáticos
 */
function initFormFormats() {
    const fields = document.querySelectorAll('[idformatocampo]');
    
    fields.forEach(field => {
        const formatType = field.getAttribute('idformatocampo');
        applyFormat(field, formatType);
    });
}

/**
 * Aplica un formato específico a un campo
 */
function applyFormat(field, formatType) {
    const formatName = FORMAT_TYPES[formatType];
    
    if (!formatName) {
        console.warn(`Formato desconocido: ${formatType}`);
        return;
    }
    
    switch (formatName) {
        case 'onlyRealNumbers':
            field.addEventListener('input', () => {
                field.value = field.value.replace(/[^0-9.]/g, '');
                // Permitir solo un punto decimal
                const parts = field.value.split('.');
                if (parts.length > 2) {
                    field.value = parts[0] + '.' + parts.slice(1).join('');
                }
            });
            break;
            
        case 'onlyNaturalNumbers':
            field.addEventListener('input', () => {
                field.value = field.value.replace(/[^0-9]/g, '');
            });
            break;
            
        case 'onlyAlphabetics':
            field.addEventListener('keypress', (e) => {
                const char = String.fromCharCode(e.which || e.keyCode);
                if (!/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(char)) {
                    e.preventDefault();
                }
            });
            break;
            
        case 'toLowerCase':
            field.addEventListener('input', () => {
                field.value = field.value.toLowerCase();
            });
            field.addEventListener('blur', () => {
                field.value = field.value.toLowerCase();
            });
            break;
            
        case 'onlyAlphaNumeric':
            field.addEventListener('keypress', (e) => {
                const char = String.fromCharCode(e.which || e.keyCode);
                if (!/[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]/.test(char)) {
                    e.preventDefault();
                }
            });
            break;
            
        case 'validateEmail':
            field.addEventListener('blur', () => {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (field.value && !emailRegex.test(field.value)) {
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            break;
            
        case 'toUpperCase':
            field.addEventListener('input', () => {
                field.value = field.value.toUpperCase();
            });
            field.addEventListener('blur', () => {
                field.value = field.value.toUpperCase();
            });
            break;
            
        case 'toCapitalize':
            field.addEventListener('input', () => {
                capitalizeField(field);
            });
            field.addEventListener('blur', () => {
                capitalizeField(field);
            });
            break;
            
        case 'onlyAlphabeticsCapitalize':
            // Combina solo letras + capitalizar
            field.addEventListener('keypress', (e) => {
                const char = String.fromCharCode(e.which || e.keyCode);
                if (!/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(char)) {
                    e.preventDefault();
                }
            });
            field.addEventListener('input', () => {
                capitalizeField(field);
            });
            field.addEventListener('blur', () => {
                capitalizeField(field);
            });
            break;
            
        case 'zipCode':
            field.addEventListener('input', () => {
                field.value = field.value.replace(/[^0-9]/g, '');
                if (field.value.length > 5) {
                    field.value = field.value.slice(0, 5);
                }
                if (field.value.length >= 5) {
                    field.blur();
                }
            });
            break;
            
        case 'phone':
            field.addEventListener('input', () => {
                field.value = field.value.replace(/[^0-9]/g, '');
                if (field.value.length > 10) {
                    field.value = field.value.slice(0, 10);
                }
                if (field.value.length >= 10) {
                    field.blur();
                }
            });
            break;
            
        case 'rfc':
            field.addEventListener('input', () => {
                field.value = field.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                if (field.value.length > 13) {
                    field.value = field.value.slice(0, 13);
                }
                if (field.value.length >= 13) {
                    field.blur();
                }
            });
            field.addEventListener('blur', () => {
                field.value = field.value.toUpperCase();
            });
            break;
            
        case 'curp':
            field.addEventListener('input', () => {
                field.value = field.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                if (field.value.length > 18) {
                    field.value = field.value.slice(0, 18);
                }
                if (field.value.length >= 18) {
                    field.blur();
                }
            });
            field.addEventListener('blur', () => {
                field.value = field.value.toUpperCase();
            });
            break;
    }
}

/**
 * Capitaliza cada palabra de un campo
 */
function capitalizeField(field) {
    const words = field.value.split(' ');
    const capitalized = words.map(word => {
        if (word.length > 0) {
            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
        }
        return word;
    });
    field.value = capitalized.join(' ');
}

// ============================================
// FUNCIONES AUXILIARES
// ============================================

/**
 * Valida que un teléfono no empiece con 0
 */
function validatePhoneNumber(input) {
    const value = input.value;
    
    if (value.length > 0 && value.charAt(0) === '0') {
        alert('El teléfono no puede empezar con cero');
        input.value = '';
        input.focus();
        return false;
    }
    
    if (value.length !== 10) {
        alert('El teléfono debe tener 10 dígitos');
        input.focus();
        return false;
    }
    
    return true;
}

/**
 * Valida que no haya números repetidos en teléfono
 */
function validateUnrepeatPhone(input) {
    const value = input.value;
    const digits = value.split('');
    let maxRepeat = 0;
    let currentRepeat = 1;
    
    for (let i = 1; i < digits.length; i++) {
        if (digits[i] === digits[i-1]) {
            currentRepeat++;
            maxRepeat = Math.max(maxRepeat, currentRepeat);
        } else {
            currentRepeat = 1;
        }
    }
    
    if (maxRepeat > 6) {
        alert('Se detectó números repetidos en el teléfono');
        return false;
    }
    
    return true;
}

/**
 * Formatea número con separadores de miles
 */
function formatThousands(input) {
    let value = input.value.replace(/,/g, '');
    const number = parseFloat(value);
    
    if (!isNaN(number)) {
        input.value = new Intl.NumberFormat('es-MX').format(number);
    }
}

/**
 * Convierte número a letras (español)
 */
function numberToWords(num) {
    const units = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
    const teens = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
    const tens = ['', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
    const hundreds = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];
    
    if (num === 0) return 'cero';
    if (num < 10) return units[num];
    if (num < 20) return teens[num - 10];
    if (num < 100) {
        const ten = Math.floor(num / 10);
        const unit = num % 10;
        return tens[ten] + (unit > 0 ? ' y ' + units[unit] : '');
    }
    if (num === 100) return 'cien';
    if (num < 1000) {
        const hundred = Math.floor(num / 100);
        const rest = num % 100;
        return hundreds[hundred] + (rest > 0 ? ' ' + numberToWords(rest) : '');
    }
    
    return num.toString();
}

// ============================================
// INICIALIZACIÓN AUTOMÁTICA
// ============================================

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFormFormats);
} else {
    initFormFormats();
}

// Exportar funciones para uso global
window.FormFormats = {
    init: initFormFormats,
    validatePhoneNumber,
    validateUnrepeatPhone,
    formatThousands,
    numberToWords
};
