# 📘 Guía Rápida de Despliegue - CPAP Web

## 🎯 ¿Cuál es tu situación?

### Opción 1: "La web ya está en producción pero las imágenes no aparecen" ⚠️
→ **USA**: `quick-fix.sh`  
⏱️ **Tiempo**: 5 minutos

### Opción 2: "Necesito volver a subir todo limpio" 🔄
→ **LEE**: `DESPLIEGUE-PRODUCCION.md` (Opción B)  
⏱️ **Tiempo**: 30 minutos

### Opción 3: "Quiero automatizar el despliegue" 🚀
→ **USA**: `deploy.sh`  
⏱️ **Tiempo**: Automático (~10 min)

---

## 🚀 INICIO RÁPIDO

### Para Opción 1 - Quick Fix (RECOMENDADO PRIMERO)

```bash
# 1. Conectarte por SSH
ssh usuario@tu-dominio.com

# 2. Navegar a la carpeta del proyecto
cd public_html  # O donde esté tu Laravel
cd cpap-web     # Si está en subcarpeta

# 3. Hacer executable el script
chmod +x quick-fix.sh

# 4. Ejecutar el script
./quick-fix.sh

# 5. Listo! Abre en navegador:
# https://tu-dominio.com
```

### Para Opción 3 - Deploy Automatizado

```bash
# 1. En producción, en la carpeta raíz del proyecto:
chmod +x deploy.sh
./deploy.sh

# 2. Esperar a que termine
# 3. Verificar que no hay errores
```

---

## 📋 Archivos en esta guía

| Archivo | Uso | Cuándo |
|---------|-----|--------|
| `DESPLIEGUE-PRODUCCION.md` | Guía completa paso a paso | Primera vez o despliegue total |
| `deploy.sh` | Script automatizado | Despliegues recurrentes |
| `quick-fix.sh` | Reparación rápida | Symlink/permisos rotos |
| `.env.production.example` | Plantilla de configuración | Copiar a `.env` |

---

## ⚠️ Problemas Comunes y Soluciones

### Error: "Permission denied" al ejecutar scripts

```bash
chmod +x deploy.sh quick-fix.sh
```

### Error: "php artisan not found"

Verifica que estés en la carpeta correcta:
```bash
ls -la artisan  # Debería existir
pwd             # Debería terminar en /cpap-web
```

### Las imágenes aún devuelven 404

```bash
# 1. Verificar symlink
ls -la public/storage

# 2. Ver si archivos existen
ls storage/app/public/

# 3. Ver logs de error
tail -50 storage/logs/laravel.log
```

### Error: "SQLSTATE[HY000]" o errores de BD

```bash
# 1. Verificar .env
cat .env | grep DB_

# 2. Probar conexión
php artisan tinker
>>> DB::connection()->getPdo()
```

---

## 🔐 Checklist Seguridad Post-Deploy

- [ ] `APP_DEBUG=false` en `.env`
- [ ] `.env` tiene permisos `600` (no público)
- [ ] SSH no permite root login
- [ ] Base de datos tiene contraseña fuerte
- [ ] SSL/HTTPS activo
- [ ] Backups programados
- [ ] Logs monitoreados

---

## 💡 Tips Importantes

### Nunca hagas esto en Producción:
❌ Ejecutar migraciones sin backup  
❌ Cambiar .env sin guardar valores actuales  
❌ Dejar APP_DEBUG=true  
❌ Subir código sin probar localmente  

### Siempre haz esto:
✅ Backup antes de cualquier cambio  
✅ Probar en local primero  
✅ Usar `.env.production.example` como referencia  
✅ Monitorear logs después de deploy  

---

## 📞 Si Necesitas Ayuda

Proporciona esta información:

```
1. ¿Qué error ves exactamente?
2. ¿Qué script ejecutaste?
3. ¿Cuál es el output último del script?
4. Resultado de: tail -20 storage/logs/laravel.log
5. Resultado de: php artisan storage:link
```

---

## 🔗 Recursos Útiles

- [Laravel Storage](https://laravel.com/docs/11.x/filesystem)
- [Laravel Deployment](https://laravel.com/docs/11.x/deployment)
- [Shared Hosting Troubleshooting](https://laravel.com/docs/11.x/deployment#shared-hosting)

---

**¿Todo funcionando?** 🎉  
Felicidades! Ahora:
- Prueba subir contenido en `/admin`
- Verifica que aparecen sin errores
- Guarda esta documentación para referencias futuras

---

*Última actualización: 9 de abril de 2026*
