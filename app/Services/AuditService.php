<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuditService
{
    /**
     * Registra una actividad de auditoría
     *
     * @param string $action La acción realizada
     * @param string $entity La entidad afectada
     * @param mixed $oldData Los datos antiguos (opcional)
     * @param mixed $newData Los datos nuevos (opcional)
     * @param int|null $entityId ID de la entidad afectada (opcional)
     * @return void
     */
    public static function log(string $action, string $entity, $oldData = null, $newData = null, $entityId = null)
    {
        $user = Auth::user();
        $username = $user ? $user->name . ' (' . $user->email . ')' : 'Sistema';
        $userId = $user ? $user->id : null;

        $logData = [
            'user_id' => $userId,
            'username' => $username,
            'action' => $action,
            'entity' => $entity,
            'entity_id' => $entityId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        // Agregar datos antiguos y nuevos sólo si existen
        if ($oldData !== null) {
            $logData['old_data'] = $oldData;
        }

        if ($newData !== null) {
            $logData['new_data'] = $newData;
        }

        // Usar el canal audit para la auditoría
        Log::channel('audit')->info($action . ' en ' . $entity, $logData);
    }
}
