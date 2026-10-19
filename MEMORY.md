# Memoria durable de gpcenter-back

- API Laravel 12/PHP 8.2 de GP Center; SPA hermano en `../GP-CENTER-WEB`.
- Prefijo: `/api/gpCenter`; autenticación Bearer con Sanctum; respuesta común mediante `app/Models/ObjResponse.php`.
- Dominio: usuarios/roles/menús/empleados, vehículos/placas/movimientos, servicios/taller/inventario y vales/detalles.
- El esquema incluye vistas `vw_*` y `sp_vehicle_history`; comprobar MySQL/MariaDB antes de migrar.
- Estados de servicio: ABIERTA, APROBADA, RECHAZADA, EN REVISIÓN, APROBADA POR CV, RECHAZADA POR CV, CERRADA.
- Estados de vale: CREADO, ALTA, VoBo, APROBADA, CANCELADA.
- La consulta de empleados a GP Central pasa por `GpCentralClient` y el proxy autenticado `/api/gpCenter/employees/getBy/employee_code/{employeeCode}`; nunca exponer `GPCENTRAL_API_KEY` al frontend.
- Cada ambiente requiere un cliente propio y rotatable de GP Central en `GPCENTRAL_CLIENT_ID`/`GPCENTRAL_API_KEY`; los errores 401/403 entre servicios se traducen a 502 para no invalidar la sesión humana.
- Pendiente material: autorización de servidor por permiso, conciliación de endpoints con Contexts, verbos HTTP, transacciones de estados, almacenamiento privado y contrato/scopes de escrituras hacia GP Central.
- Guía transversal para crear o modificar módulos: `../GP-CENTER-WEB/CREACION_DE_PAGINAS.md`.
- Contexto canónico transversal: `../GP-CENTER-WEB/CONTEXTO_SISTEMA.md`.
