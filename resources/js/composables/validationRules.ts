import type { ValidationRule } from '@/composables/useFormValidation';

/**
 * Reglas de validación para todos los módulos
 * Cada módulo puede extender estas reglas
 */

export const clientes = {
  nombre: {
    required: true,
    minLength: 2,
    maxLength: 100,
  } as ValidationRule,
  email: {
    required: true,
    email: true,
  } as ValidationRule,
  telefono: {
    phone: true,
    minLength: 10,
    maxLength: 20,
  } as ValidationRule,
  direccion: {
    maxLength: 255,
  } as ValidationRule,
};

export const proyectos = {
  nombre: {
    required: true,
    minLength: 3,
    maxLength: 150,
  } as ValidationRule,
  descripcion: {
    maxLength: 1000,
  } as ValidationRule,
  fecha_inicio: {
    required: true,
  } as ValidationRule,
  fecha_fin: {
    required: true,
  } as ValidationRule,
  estado: {
    required: true,
  } as ValidationRule,
  presupuesto: {
    required: true,
    numeric: true,
  } as ValidationRule,
};

export const cotizaciones = {
  numero: {
    required: true,
    minLength: 3,
    maxLength: 50,
  } as ValidationRule,
  descripcion: {
    maxLength: 1000,
  } as ValidationRule,
  monto: {
    required: true,
    numeric: true,
  } as ValidationRule,
  fecha_vigencia: {
    required: true,
  } as ValidationRule,
  estado: {
    required: true,
  } as ValidationRule,
};

export const disenos = {
  nombre: {
    required: true,
    minLength: 3,
    maxLength: 150,
  } as ValidationRule,
  descripcion: {
    maxLength: 1000,
  } as ValidationRule,
  archivo_url: {
    maxLength: 255,
  } as ValidationRule,
  estado: {
    required: true,
  } as ValidationRule,
};

export const productos = {
  nombre: {
    required: true,
    minLength: 2,
    maxLength: 150,
  } as ValidationRule,
  descripcion: {
    maxLength: 1000,
  } as ValidationRule,
  precio: {
    required: true,
    numeric: true,
  } as ValidationRule,
  cantidad: {
    numeric: true,
  } as ValidationRule,
  categoria: {
    maxLength: 100,
  } as ValidationRule,
};

export const proveedores = {
  nombre: {
    required: true,
    minLength: 2,
    maxLength: 150,
  } as ValidationRule,
  email: {
    email: true,
  } as ValidationRule,
  telefono: {
    phone: true,
  } as ValidationRule,
  direccion: {
    maxLength: 255,
  } as ValidationRule,
  persona_contacto: {
    minLength: 2,
    maxLength: 100,
  } as ValidationRule,
};

export const planPagos = {
  numero_cuota: {
    required: true,
    numeric: true,
  } as ValidationRule,
  monto: {
    required: true,
    numeric: true,
  } as ValidationRule,
  fecha_vencimiento: {
    required: true,
  } as ValidationRule,
  estado: {
    required: true,
  } as ValidationRule,
};

export const pagos = {
  monto: {
    required: true,
    numeric: true,
  } as ValidationRule,
  fecha_pago: {
    required: true,
  } as ValidationRule,
  metodo_pago: {
    required: true,
  } as ValidationRule,
  numero_referencia: {
    minLength: 3,
    maxLength: 100,
  } as ValidationRule,
};

export const cronogramas = {
  nombre: {
    required: true,
    minLength: 3,
    maxLength: 150,
  } as ValidationRule,
  descripcion: {
    maxLength: 1000,
  } as ValidationRule,
  fecha_inicio: {
    required: true,
  } as ValidationRule,
  fecha_fin: {
    required: true,
  } as ValidationRule,
  estado: {
    required: true,
  } as ValidationRule,
};

export const tareas = {
  titulo: {
    required: true,
    minLength: 3,
    maxLength: 200,
  } as ValidationRule,
  descripcion: {
    maxLength: 1000,
  } as ValidationRule,
  fecha_inicio: {
    required: true,
  } as ValidationRule,
  fecha_fin: {
    required: true,
  } as ValidationRule,
  estado: {
    required: true,
  } as ValidationRule,
  prioridad: {
    required: true,
  } as ValidationRule,
};

export const evaluacionServicios = {
  puntuacion: {
    required: true,
    numeric: true,
  } as ValidationRule,
  comentarios: {
    maxLength: 1000,
  } as ValidationRule,
  fecha_evaluacion: {
    required: true,
  } as ValidationRule,
  aspectos: {
    maxLength: 500,
  } as ValidationRule,
};

export const menuItems = {
  name: {
    required: true,
    minLength: 2,
    maxLength: 100,
  } as ValidationRule,
  label: {
    required: true,
    minLength: 2,
    maxLength: 100,
  } as ValidationRule,
  icon: {
    maxLength: 50,
  } as ValidationRule,
  route: {
    maxLength: 100,
  } as ValidationRule,
  href: {
    maxLength: 255,
  } as ValidationRule,
  order: {
    numeric: true,
  } as ValidationRule,
};
