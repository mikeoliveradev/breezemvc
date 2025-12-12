# BreezeMVC - Project Metadata

**Nombre del Proyecto:** BreezeMVC  
**Versión:** 1.0.1  
**Tipo:** PHP MVC Template  
**Licencia:** MIT  

---

## 📋 Información del Proyecto

### Descripción
BreezeMVC es una plantilla PHP moderna, ligera y profesional con arquitectura MVC. Desarrollo ágil sin complicaciones, sin dependencias de frameworks pesados.

### Características
- Arquitectura MVC nativa
- Sin dependencias de Composer (Zero Config)
- Ligero (~40MB)
- Script de Inicialización Interactivo
- PHP 8.0+
- Sistema de validación
- CLI Helper (Generadores de código)
- Migraciones de BD
- Sistema de caché
- Autenticación completa

---

## 👨‍💻 Autor

**Nombre:** Mike Olivera  
**Email:** rinoceronte.digital@gmail.com  
**Website:** https://mikeolivera.com  
**GitHub:** [@mikeoliveradev](https://github.com/mikeoliveradev)  

---

## 🔗 Enlaces

**Repositorio:** https://github.com/mikeoliveradev/breezemvc  
**Issues:** https://github.com/mikeoliveradev/breezemvc/issues  
**Wiki:** https://github.com/mikeoliveradev/breezemvc/wiki  
**Documentación:** [README.md](README.md)  

---

## 📦 Requisitos

- **PHP:** 8.0 o superior
- **MySQL:** 5.7 o superior
- **MySQL Client:** Recomendado para `init-project.sh`
- **Extensiones PHP:**
  - mysqli (requerido)
  - session (requerido)
  - json (requerido)
  - mbstring (recomendado)
  - redis (opcional, para caché)
  - gd (opcional, para imágenes)

---

## 🏷️ Keywords

php, mvc, framework, template, breezemvc, lightweight, vanilla-php, crud, orm, no-dependencies, simple, fast

---

## 📄 Licencia

MIT License - Copyright (c) 2025 Mike Olivera

Ver archivo [LICENSE](LICENSE) para más detalles.

---

## 🌟 Filosofía

> "No uses un camión de 18 ruedas para ir al supermercado"

BreezeMVC es perfecto para:
- Desarrolladores freelance
- Agencias pequeñas/medianas
- Startups con presupuesto limitado
- Aprendizaje de arquitectura MVC
- Proyectos que necesitan velocidad de desarrollo

---

## 📊 Comparación

| Característica          | BreezeMVC            | Laravel          | CodeIgniter    |
|-------------------------|----------------------|------------------|----------------|
| **Tamaño**              | ~40MB                | ~1.85GB          | ~2MB           |
| **Archivos Core**       | ~160                 | ~3000            | ~500           |
| **Composer**            | ❌ No Requerido      | ✅ Requerido     | ⚠️ Opcional    |
| **Hosting compartido**  | ✅ Nativo            | ❌ Complejo      | ✅ Nativo      |
| **Configuración**       | ✅ Script Automático | ⚠️ Manual (.env) | ⚠️ Manual      |
| **Curva aprendizaje**   | 🟢 Baja              | 🔴 Alta          | 🟡 Media       |

---

## 🚀 Instalación Rápida

```bash
# 1. Clonar repositorio
git clone https://github.com/mikeoliveradev/breezemvc.git
cd breezemvc

# 2. Ejecutar script de inicialización
# (Configura BD, .env, migraciones y URL automáticamente)
./init-project.sh

# 3. Iniciar servidor de desarrollo
php -S localhost:8000 -t public/
```

---

## 📞 Soporte

- 📧 Email: rinoceronte.digital@gmail.com
- 🐛 Issues: [GitHub Issues](https://github.com/mikeoliveradev/breezemvc/issues)
- 📖 Documentación: [Wiki](https://github.com/mikeoliveradev/breezemvc/wiki)

---

## 🎯 Roadmap

### v1.0 (Actual)
- ✅ Arquitectura MVC
- ✅ Sistema de validación
- ✅ CLI Helper
- ✅ Migraciones
- ✅ Sistema de caché
- ✅ Autenticación completa

### v1.1 (Futuro)
- [ ] Sistema de roles y permisos
- [ ] API REST helper
- [ ] Paginación automática
- [ ] Generador de CRUD completo
- [ ] Testing framework integrado

### v2.0 (Futuro)
- [ ] Soporte para múltiples bases de datos
- [ ] Queue system
- [ ] WebSocket support
- [ ] Admin panel generator

---

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama (`git checkout -b feature/nueva-caracteristica`)
3. Commit tus cambios (`git commit -m 'Añadir nueva característica'`)
4. Push a la rama (`git push origin feature/nueva-caracteristica`)
5. Abre un Pull Request

---

## 📝 Changelog

### v1.0.1 (2025-11-25)
- **Nuevo:** Script `init-project.sh` interactivo para configuración automática.
- **Mejora:** Filosofía "Zero Composer" real (vendor incluido en git).
- **Mejora:** Generadores de código (Modelos/Controladores) integrados en la inicialización.
- **Limpieza:** Eliminación masiva de assets basura (~30MB ahorrados).
- **Fix:** Restauración de configuración .htaccess optimizada.

### v1.0.0 (2025-11-24)
- Lanzamiento inicial
- Arquitectura MVC completa
- Sistema de validación PHP + JavaScript
- CLI Helper para generación de código
- Sistema de migraciones SQL
- Sistema de caché (File/Redis)
- Autenticación completa (Login, Registro, Google OAuth, Recuperación)
- Sistema de emails híbrido (PHPMailer/mail())
- Documentación completa

---

**Última actualización:** 24 de noviembre, 2025  
**Mantenido por:** Mike Olivera
