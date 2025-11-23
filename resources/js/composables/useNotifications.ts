import { ref, computed } from 'vue';

/**
 * Notificaciones y mensajes de validación
 */

export interface Notification {
  type: 'success' | 'error' | 'warning' | 'info';
  message: string;
  duration?: number;
  id?: string;
}

/**
 * Mensajes de éxito comunes
 */
export const successMessages = {
  created: (entity: string) => `${entity} creado exitosamente`,
  updated: (entity: string) => `${entity} actualizado exitosamente`,
  deleted: (entity: string) => `${entity} eliminado exitosamente`,
  saved: 'Cambios guardados exitosamente',
  imported: 'Datos importados exitosamente',
};

/**
 * Mensajes de error comunes
 */
export const errorMessages = {
  validationError: 'Por favor revisa los errores en el formulario',
  serverError: 'Error del servidor. Por favor intenta nuevamente',
  notFound: (entity: string) => `${entity} no encontrado`,
  unauthorized: 'No tienes permisos para realizar esta acción',
  alreadyExists: (entity: string) => `${entity} ya existe`,
  cannotDelete: (entity: string, reason: string) => `No se puede eliminar ${entity}: ${reason}`,
  networkError: 'Error de conexión. Verifica tu conexión a internet',
};

/**
 * Mensajes de advertencia
 */
export const warningMessages = {
  unsavedChanges: 'Tienes cambios sin guardar',
  deleteConfirmation: (entity: string) => `¿Estás seguro que deseas eliminar ${entity}?`,
  largeFile: 'El archivo es muy grande, esto puede tomar más tiempo',
};

/**
 * Composable para manejar notificaciones (puede integrarse con un toast service)
 */
export function useNotification() {
  const notifications = ref<Notification[]>([]);

  /**
   * Generar ID único
   */
  function generateId(): string {
    return `notification-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
  }

  /**
   * Añadir notificación
   */
  function addNotification(notification: Omit<Notification, 'id'>) {
    const id = generateId();
    const notifWithId: Notification = { ...notification, id };
    notifications.value.push(notifWithId);

    if (notification.duration !== undefined && notification.duration > 0) {
      setTimeout(() => {
        removeNotification(id);
      }, notification.duration);
    }

    return id;
  }

  /**
   * Remover notificación
   */
  function removeNotification(id: string) {
    notifications.value = notifications.value.filter((n) => n.id !== id);
  }

  /**
   * Mostrar éxito
   */
  function success(message: string, duration = 3000) {
    return addNotification({ type: 'success', message, duration });
  }

  /**
   * Mostrar error
   */
  function error(message: string, duration = 5000) {
    return addNotification({ type: 'error', message, duration });
  }

  /**
   * Mostrar advertencia
   */
  function warning(message: string, duration = 4000) {
    return addNotification({ type: 'warning', message, duration });
  }

  /**
   * Mostrar info
   */
  function info(message: string, duration = 3000) {
    return addNotification({ type: 'info', message, duration });
  }

  /**
   * Limpiar todas las notificaciones
   */
  function clearAll() {
    notifications.value = [];
  }

  return {
    notifications: computed(() => notifications.value),
    addNotification,
    removeNotification,
    success,
    error,
    warning,
    info,
    clearAll,
  };
}
