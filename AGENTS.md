# Instrucciones operativas de gpcenter-back

## Alcance y fuente de verdad

- Este repositorio es la API Laravel de GP Center; el SPA hermano está en `../GP-CENTER-WEB`.
- Consulta `../GP-CENTER-WEB/CONTEXTO_SISTEMA.md` antes de cambiar dominio, rutas, permisos, estados o el contrato API.
- Para cualquier página o módulo extremo a extremo, sigue `../GP-CENTER-WEB/CREACION_DE_PAGINAS.md` y valida su matriz de integración.
- Trata modelos/controladores con `copy` y rutas comentadas como legado, no como patrón vigente.

## Convenciones

- Mantén las rutas de dominio bajo `/api/gpCenter` y protegidas por Sanctum, salvo una decisión explícita documentada.
- Modelo singular PascalCase, tabla `snake_case`, `$fillable` mínimo; usa `*View` para vistas SQL de lectura.
- Para módulos nuevos: migración/restricciones, modelo, controlador, ruta, seeder si es catálogo, prueba Feature y adaptación del Context frontend.
- Devuelve el contrato compartido `ObjResponse` y un código HTTP concordante. No expongas mensajes internos/excepciones en producción.
- Prefiere verbos HTTP correctos; no añadas mutaciones mediante GET ni nuevas variantes arbitrarias de `create`, `createOrUpdate`, `delete` y `destroy`.
- Usa transacciones para efectos multientidad, en especial estados de servicio/vale y movimientos vehiculares.

## Seguridad y datos

- Aplica autorización de servidor por rol/permiso; ocultar botones en React no autoriza una operación.
- Valida todos los campos y archivos (tipo, tamaño y nombre generado por servidor).
- No desactives validación TLS. No escribas secretos ni valores `.env` en código, logs o documentación.
- No agregues documentos operativos o datos personales a `public/GPCenter` o Git; usa almacenamiento privado y descargas autorizadas.
- Cambiar enums/IDs de estados o roles exige revisar migraciones, seeders, controladores, vistas SQL, menús y frontend.

## Verificación

- Ejecuta `composer test`, `php artisan route:list --path=api` y `vendor/bin/pint --test` sobre cambios.
- Añade pruebas Feature de autenticación, autorización, validación, respuesta y transición. Las pruebas actuales son solo las de ejemplo.
- No asumas que SQLite valida el esquema: vistas y procedimientos actuales requieren comprobar el motor SQL real.
