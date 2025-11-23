import { ref, computed } from 'vue';

export interface ValidationRule {
  required?: boolean;
  minLength?: number;
  maxLength?: number;
  pattern?: RegExp;
  email?: boolean;
  phone?: boolean;
  numeric?: boolean;
  custom?: (value: any) => string | null;
}

export interface ValidationErrors {
  [key: string]: string | null;
}

/**
 * Mensajes de error en español
 */
const errorMessages = {
  required: (field: string) => `${field} es requerido`,
  minLength: (field: string, min: number) => `${field} debe tener al menos ${min} caracteres`,
  maxLength: (field: string, max: number) => `${field} no puede exceder ${max} caracteres`,
  email: (field: string) => `${field} debe ser un correo válido`,
  phone: (field: string) => `${field} debe ser un teléfono válido`,
  numeric: (field: string) => `${field} debe contener solo números`,
  pattern: (field: string, pattern: string) => `${field} no tiene el formato correcto (${pattern})`,
  custom: (message: string) => message,
};

/**
 * Patrones de validación comunes
 */
export const patterns = {
  email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
  phone: /^[\d\s\-\+\(\)]+$/,
  numeric: /^\d+$/,
  url: /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/,
  zipCode: /^\d{4,6}$/,
  creditCard: /^(\d{4}\s?){3}\d{4}$/,
  identificationNumber: /^\d{1,20}$/,
};

/**
 * Hook para validación de formularios con soporte multi-campo
 */
export function useFormValidation(
  fields: Record<string, any>,
  rules: Record<string, ValidationRule>,
) {
  const errors = ref<ValidationErrors>({});

  /**
   * Obtener nombre legible del campo
   */
  function getFieldName(fieldKey: string): string {
    // Convertir snake_case a Nombre Legible
    return fieldKey
      .split('_')
      .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
      .join(' ');
  }

  /**
   * Validar un campo individual
   */
  function validateField(fieldKey: string, value: any): string | null {
    const rule = rules[fieldKey];
    if (!rule) return null;

    const fieldName = getFieldName(fieldKey);

    // Validar required
    if (rule.required && (!value || (typeof value === 'string' && value.trim() === ''))) {
      return errorMessages.required(fieldName);
    }

    // Si está vacío y no es requerido, pasar
    if (!value || (typeof value === 'string' && value.trim() === '')) {
      return null;
    }

    const stringValue = String(value).trim();

    // Validar minLength
    if (rule.minLength && stringValue.length < rule.minLength) {
      return errorMessages.minLength(fieldName, rule.minLength);
    }

    // Validar maxLength
    if (rule.maxLength && stringValue.length > rule.maxLength) {
      return errorMessages.maxLength(fieldName, rule.maxLength);
    }

    // Validar email
    if (rule.email && !patterns.email.test(stringValue)) {
      return errorMessages.email(fieldName);
    }

    // Validar phone
    if (rule.phone && !patterns.phone.test(stringValue)) {
      return errorMessages.phone(fieldName);
    }

    // Validar numeric
    if (rule.numeric && !patterns.numeric.test(stringValue)) {
      return errorMessages.numeric(fieldName);
    }

    // Validar pattern custom
    if (rule.pattern && !rule.pattern.test(stringValue)) {
      return errorMessages.pattern(fieldName, rule.pattern.source);
    }

    // Validar función custom
    if (rule.custom) {
      return rule.custom(value);
    }

    return null;
  }

  /**
   * Validar todos los campos
   */
  function validate(): boolean {
    const newErrors: ValidationErrors = {};
    let hasErrors = false;

    for (const fieldKey in rules) {
      const error = validateField(fieldKey, fields[fieldKey]);
      newErrors[fieldKey] = error;
      if (error) hasErrors = true;
    }

    errors.value = newErrors;
    return !hasErrors;
  }

  /**
   * Validar un campo individual (en tiempo real)
   */
  function validateFieldReal(fieldKey: string) {
    errors.value[fieldKey] = validateField(fieldKey, fields[fieldKey]);
  }

  /**
   * Limpiar errores
   */
  function clearErrors() {
    errors.value = {};
  }

  /**
   * Limpiar error de un campo específico
   */
  function clearFieldError(fieldKey: string) {
    errors.value[fieldKey] = null;
  }

  /**
   * Verificar si hay errores
   */
  const hasErrors = computed(() => Object.values(errors.value).some((error) => error !== null));

  /**
   * Obtener todos los errores
   */
  const allErrors = computed(() =>
    Object.entries(errors.value)
      .filter(([, error]) => error !== null)
      .map(([field, error]) => ({ field, message: error })),
  );

  return {
    errors,
    hasErrors,
    allErrors,
    validate,
    validateFieldReal,
    clearErrors,
    clearFieldError,
    getFieldName,
  };
}

/**
 * Hook simplificado para validación rápida
 */
export function useFieldValidation() {
  /**
   * Validar email
   */
  function isValidEmail(email: string): boolean {
    return patterns.email.test(email);
  }

  /**
   * Validar teléfono
   */
  function isValidPhone(phone: string): boolean {
    return patterns.phone.test(phone);
  }

  /**
   * Validar número
   */
  function isValidNumber(value: string): boolean {
    return patterns.numeric.test(value);
  }

  /**
   * Validar URL
   */
  function isValidUrl(url: string): boolean {
    return patterns.url.test(url);
  }

  /**
   * Validar código postal
   */
  function isValidZipCode(zipCode: string): boolean {
    return patterns.zipCode.test(zipCode);
  }

  /**
   * Validar tarjeta de crédito
   */
  function isValidCreditCard(cardNumber: string): boolean {
    return patterns.creditCard.test(cardNumber.replace(/\s/g, ''));
  }

  /**
   * Validar número de identificación
   */
  function isValidIdentificationNumber(number: string): boolean {
    return patterns.identificationNumber.test(number);
  }

  /**
   * Validar longitud de texto
   */
  function isValidLength(value: string, min: number, max: number): boolean {
    return value.length >= min && value.length <= max;
  }

  /**
   * Validar contraseña fuerte (min 8 caracteres, al menos 1 mayúscula, 1 número)
   */
  function isStrongPassword(password: string): { valid: boolean; errors: string[] } {
    const errors: string[] = [];

    if (password.length < 8) {
      errors.push('La contraseña debe tener al menos 8 caracteres');
    }
    if (!/[A-Z]/.test(password)) {
      errors.push('La contraseña debe contener al menos una mayúscula');
    }
    if (!/[0-9]/.test(password)) {
      errors.push('La contraseña debe contener al menos un número');
    }
    if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
      errors.push('La contraseña debe contener al menos un carácter especial');
    }

    return {
      valid: errors.length === 0,
      errors,
    };
  }

  return {
    isValidEmail,
    isValidPhone,
    isValidNumber,
    isValidUrl,
    isValidZipCode,
    isValidCreditCard,
    isValidIdentificationNumber,
    isValidLength,
    isStrongPassword,
  };
}
