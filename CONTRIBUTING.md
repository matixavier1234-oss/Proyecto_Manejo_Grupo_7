# Guía de Contribución y Reglas del Equipo

Este documento define la estructura de colaboración para garantizar un código limpio y evitar conflictos críticos. Trabajaremos bajo el estándar **GitFlow**[cite: 1].

## 1. Estructura de Ramas
* **`main`**: Rama de producción. Contiene únicamente código estable y funcional[cite: 1]. **Prohibido realizar commits directos.**
* **`develop`**: Rama de integración principal[cite: 1]. Todo el desarrollo se unifica aquí antes de pasar a producción.
* **`feature/*`**: Ramas de trabajo individual. Cada nueva funcionalidad (ej. `feature/catalogo`, `feature/layout`) debe nacer obligatoriamente desde `develop`[cite: 1].

## 2. Flujo de Trabajo
1. Actualiza tu entorno local: `git checkout develop` seguido de `git pull origin develop`.
2. Crea tu rama de trabajo: `git checkout -b feature/nombre-de-tu-tarea`.
3. Desarrolla tu código realizando commits atómicos y descriptivos.
4. Sube tu rama al repositorio remoto: `git push origin feature/nombre-de-tu-tarea`.

## 3. Pull Requests (PR) y Revisiones
* **Requisito Académico:** Cada integrante debe realizar un mínimo de dos Pull Requests durante el proyecto[cite: 1].
* Ningún PR puede fusionarse (*merge*) hacia `develop` sin antes recibir una revisión de código. Los compañeros deben dejar comentarios o sugerencias de mejora en la plataforma web[cite: 1].
* La resolución de conflictos es responsabilidad del autor del PR antes de solicitar la integración final.