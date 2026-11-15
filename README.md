# NoreTel CRM — Suite de Pruebas y Conciliación Yape (PA2)

**Universidad Continental**  
**Asignatura:** Pruebas y Calidad de Software  
**Producto Académico:** N° 02 — Estrategia y Planificación de Pruebas de Software  
**Estudiante:** Yhon Mamani Kjuro (`41918221@continental.edu.pe`) — 100% Participación  
**Docente Evaluador:** `jcastrofl@continental.edu.pe`  

---

## 1. Descripción del Proyecto

Este repositorio contiene la **suite de pruebas automatizadas y prototipo ejecutable** para el flujo crítico de **Conciliación de Pagos Yape** del sistema **NoreTel CRM** (operador de telecomunicaciones e internet en el contexto peruano).

El prototipo está diseñado como un entorno aislado, autocontenido y completamente reproducible basado en:
- **Lenguaje y Framework:** PHP 8.2+ / Laravel.
- **Motor de Persistencia de Prueba:** SQLite (`academic.sqlite` y SQLite `:memory:` para pruebas unitarias).
- **Aislamiento y Confidencialidad:** Fixtures con datos 100% sintéticos (clientes, contratos, facturas y pagos ficticios). No se conecta a servicios productivos de Yape, WhatsApp, BCP ni bases empresariales.
- **Servicio Real Evaluado:** El algoritmo de conciliación (`YapeReconciliationService::tryReconcile`) y registro de pagos (`PaymentService`) se ejecutan directamente con su lógica de producción.

---

## 2. Requisitos Previos

- **PHP:** Versión 8.1 o superior (con extensiones `pdo_sqlite`, `sqlite3`, `mbstring`, `xml`, `fileinfo`).
- **Composer:** Versión 2.x.
- *(Opcional)* **Python 3:** Para ejecución de suite automatizada HTTP (smoke test).

---

## 3. Inicio Rápido en 3 Pasos

Abra una terminal en la raíz de esta carpeta (`academic-demo`):

### Paso 1: Instalar dependencias
```bash
composer install --no-scripts --no-plugins
```

### Paso 2: Inicializar la base de datos de pruebas sintéticas
```bash
php artisan demo:setup
php artisan demo:verify
```
*Este comando migra el esquema SQLite y precarga 4 clientes ficticios y 4 facturas independientes de S/ 65.00.*

### Paso 3: Ejecutar la batería de pruebas PHPUnit
```bash
php vendor/phpunit/phpunit/phpunit --configuration phpunit.xml --filter AcademicDemo
```
**Resultado esperado:**
```text
OK (13 tests, 37 assertions)
```

---

## 4. Ejecución del Prototipo Web Interactivo

Para interactuar visualmente con la simulación de escenarios de pago Yape:

1. Inicie el servidor web local:
```bash
php -S 127.0.0.1:8091 -t public public/router.php
```

2. Abra su navegador en: [http://127.0.0.1:8091/login](http://127.0.0.1:8091/login)
   - **Usuario Evaluador:** `evaluador@example.test`
   - **Contraseña:** `DemoAcademica2026!`

3. Ingrese a la sección **Simulación Yape** (`/demo/yape`) para disparar interactivamente cualquiera de los 5 escenarios de prueba:
   - **CP01 (Coincidencia válida):** Intención validada, pago registrado y factura marcada como pagada.
   - **CP02 (Importe discordante):** Intención observada, factura pendiente, no se aplica pago.
   - **CP03 (Código de seguridad inválido):** Intención observada, factura pendiente, rechazo seguro.
   - **CP04 (Falta de evento receptor):** Intención en espera (`waiting_receiver_event`), factura pendiente.
   - **CP05 (Reintento de operación):** Idempotencia garantizada, conserva el pago previo y no genera cobro duplicado.

*(Para detener el servidor, presione `Ctrl + C` en la terminal).*

---

## 5. Batería de Pruebas Automatizadas Adicionales (Smoke Test HTTP)

Para validar todas las rutas web, autenticación, protección CSRF y los 5 escenarios funcionales mediante un cliente HTTP automatizado:

```bash
python tools/smoke.py --php php
```

**Resultado esperado:**
```json
{"status": "passed", "checks": 15, "state": {"payments": 1, "invoices_paid": 1, "idempotency": true}}
```

---

## 6. Trazabilidad de Casos de Prueba (Jira NYP)

Los casos de prueba están vinculados al proyecto Jira **NoreTel Yape PA2 (NYP)**:

| ID Caso | Requisito | Resumen del Escenario | Tipo de Prueba | Estado Jira |
|---|---|---|---|---|
| **CP01** | RF01 | Conciliación válida y registro de pago único (S/ 65.00) | Integración / Funcional | Listo (`NYP-1`) |
| **CP02** | RF02 | Discrepancia en importe (Observación sin pago) | Caja Negra / Partición | Listo (`NYP-2`) |
| **CP03** | RF03 | Discrepancia en código de seguridad (Rechazo seguro) | Caja Negra / Validación | Listo (`NYP-3`) |
| **CP04** | RF04 | Ausencia de evento receptor (Estado en espera) | Transición de Estados | Listo (`NYP-4`) |
| **CP05** | RF05 | Reintento sobre intención ya validada (Idempotencia) | Fiabilidad / Seguridad | Listo (`NYP-5`) |

---

## 7. Estructura de Carpetas

```text
academic-demo/
├── app/
│   └── Academic/          # Controladores y runners de escenarios académicos
├── database/              # Migraciones y seeders SQLite
├── Modules/               # Servicios reales de Billing y conciliación Yape
├── public/                # Enrutador y assets estáticos locales
├── resources/views/       # Vistas Blade del prototipo académico
├── routes/academic.php    # Rutas delimitadas para la evaluación
├── tests/                 # Suite PHPUnit (AcademicDemoScenarioTest, AcademicDemoIsolationTest)
├── tools/                 # Scripts de verificación (smoke.py, check_guards.py)
├── composer.json          # Definición de dependencias
├── phpunit.xml            # Configuración de pruebas automatizadas
└── README.md              # Documentación de reproducción
```
