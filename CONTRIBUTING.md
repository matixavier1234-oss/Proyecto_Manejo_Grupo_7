# 📖 Guía de Contribución y Reglas del Equipo

Este documento define la estructura de colaboración para garantizar un código limpio y evitar conflictos críticos. Trabajaremos bajo el estándar **GitFlow**.

## 1. Estructura de Ramas
* **`main`**: Rama de producción. Contiene únicamente código estable y funcional. **Prohibido realizar commits directos.**
* **`develop`**: Rama de integración principal. Todo el desarrollo se unifica aquí antes de pasar a producción.
* **`feature/*`**: Ramas de trabajo individual. Cada nueva funcionalidad (ej. `feature/catalogo`, `feature/layout`) debe nacer obligatoriamente desde `develop`.
* **`release/*`**: Ramas para preparar una nueva versión para producción. Nacen de `develop` y se fusionan tanto en `main` como en `develop`.
* **`hotfix/*`**: Ramas para solucionar errores críticos urgentes en producción. Nacen de `main` y se fusionan tanto en `main` como en `develop`.

## 2. Flujo de Trabajo
1. Actualiza tu entorno local: `git checkout develop` seguido de `git pull origin develop`.
2. Crea tu rama de trabajo: `git flow feature start nombre-de-tu-tarea`
3. Desarrolla tu código realizando commits atómicos y descriptivos.
4. Sube tu rama al repositorio remoto: `git push origin feature/nombre-de-tu-tarea`.

## 3. Pull Requests (PR) y Revisiones
* **Requisito Académico:** Cada integrante debe realizar un mínimo de dos Pull Requests durante el proyecto.
* Ningún PR puede fusionarse (*merge*) hacia `develop` sin antes recibir una revisión de código. Los compañeros deben dejar comentarios o sugerencias de mejora en la plataforma web.
* La resolución de conflictos es responsabilidad del autor del PR antes de solicitar la integración final.