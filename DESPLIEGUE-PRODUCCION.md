# 🚀 Guía de Despliegue y Reparación para Producción

**Fecha**: 9 de abril de 2026  
**Proyecto**: CPAP Web  
**Hosting**: Compartido con SSH (almacenamiento ilimitado)

---

## 📋 DIAGNÓSTICO ACTUAL

### Problemas en Producción:
❌ Imágenes/PDFs suben pero devuelven 404  
❌ Errores variados al acceder a `/admin/*`  
❌ Probablemente falta el symlink `public/storage`  

### Root Cause:
1. El symlink `public/storage → storage/app/public` no existe
2. Laravel intenta servir archivos que no encuentra
3. Sin SSH manual, el symlink no se creó

---

## 🔧 OPCIÓN A: Reparación Rápida (si la web ya estaba subida)

### Paso 1: Conectarse por SSH

```bash
ssh usuario@tu-dominio.com
# O si usas host específico:
ssh usuario@ip-hosting -p puerto
```

### Paso 2: Navegar al directorio de la web

```bash
cd public_html  # O la carpeta donde está Laravel
# o si está en subcarpeta:
cd public_html/cpap-web
pwd  # Verifica dónde estás
```

### Paso 3: Crear el symlink

```bash
php artisan storage:link
```

**Si da error "storage/app/public does not exist":**
```bash
mkdir -p storage/app/public
mkdir -p storage/logs
chmod -R 755 storage
php artisan storage:link
```

### Paso 4: Verificar que funcionó

```bash
ls -la public/storage
# Deberías ver: storage -> /../storage/app/public
```

### Paso 5: Limpiar cache de Laravel

```bash
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
```

### Paso 6: Establecer permisos correctos

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data .  # Si tienes permisos de root
```

---

## 🔄 OPCIÓN B: Despliegue Completo desde Cero (RECOMENDADO)

Si necesitas volver a subir todo limpio:

### Paso 1: Limpiar hosting

```bash
ssh usuario@tu-dominio.com
cd public_html
# BACKUP PRIMERO (importante):
tar -czf backup-viejo-$(date +%Y%m%d).tar.gz .
rm -rf *  # Elimina todo
```

### Paso 2: Descargar código desde GitHub

```bash
git clone https://github.com/cpap-centro-junin/cpap-web.git .
# O si es privado:
git clone https://usuario:token@github.com/cpap-centro-junin/cpap-web.git .
```

### Paso 3: Instalar dependencias

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### Paso 4: Configurar .env

```bash
cp .env.example .env
nano .env  # O editor que prefieras
```

**Cambios importantes en `.env`:**
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=tu_base_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

MAIL_HOST=smtp.tu-hosting.com
MAIL_PORT=587
MAIL_USERNAME=tu@email.com
MAIL_PASSWORD=tu_contraseña
```

### Paso 5: Generar key y crear estructura

```bash
php artisan key:generate
php artisan storage:link
mkdir -p storage/app/public
mkdir -p storage/logs
```

### Paso 6: Migrar base de datos (si es nueva)

```bash
php artisan migrate --force
php artisan db:seed  # Si tienes seeders
```

### Paso 7: Establecer permisos

```bash
chmod -R 755 storage bootstrap/cache
# Si tienes acceso root:
chown -R www-data:www-data .
```

### Paso 8: Optimizar para producción

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## ✅ Verificación Post-Despliegue

### Test 1: Acceder a la web
```
https://tu-dominio.com
```
**Deberías ver**: Home page normal sin 500 errors

### Test 2: Panel de admin
```
https://tu-dominio.com/admin
```
**Deberías ver**: Login sin errores de rutas

### Test 3: Subir una imagen
```
1. Admin → Biblioteca → Nuevo Recurso
2. Sube un PDF y portada
3. Guarda
4. Verifica que la imagen aparece en la lista
```

### Test 4: Revisar logs
```bash
ssh usuario@tu-dominio.com
tail -f storage/logs/laravel.log
# Ctrl+C para salir
```

---

## 🛡️ Prevención Futura: Proceso de Despliegue Automático

### Script Deploy (guárda como `deploy.sh` en raíz del proyecto)

```bash
#!/bin/bash

# deploy.sh - Script de despliegue seguro
# Uso: ./deploy.sh

set -e  # Exit on error

echo "🚀 Iniciando despliegue a producción..."

# 1. Backup
echo "📦 Creando backup..."
tar -czf backups/backup-$(date +%Y%m%d-%H%M%S).tar.gz \
    storage/app/public \
    database \
    .env 2>/dev/null || true

# 2. Git pull (si está en repo)
echo "📥 Actualizando código..."
git pull origin main

# 3. Dependencias
echo "📚 Instalando dependencias..."
composer install --optimize-autoloader --no-dev -q
npm ci --no-audit

# 4. Build assets
echo "🎨 Compilando assets..."
npm run build

# 5. Migrations
echo "🗄️ Ejecutando migraciones..."
php artisan migrate --force --no-interaction

# 6. Cache
echo "⚡ Optimizando..."
php artisan config:cache -q
php artisan route:cache -q
php artisan view:cache -q

# 7. Permisos
echo "🔒 Configurando permisos..."
chmod -R 755 storage bootstrap/cache

# 8. Done
echo "✅ Despliegue completado exitosamente"
```

**Uso desde SSH:**
```bash
chmod +x deploy.sh
./deploy.sh
```

---

## 🐛 Solución de Errores Comunes

### Error: "No such file or directory: storage/app/public"
```bash
mkdir -p storage/app/public
php artisan storage:link
```

### Error: "Permission denied" en storage
```bash
chmod -R 777 storage bootstrap/cache
```

### Error: "SQLSTATE[HY000]: General error"
```bash
php artisan cache:clear
php artisan config:clear
php artisan optimize:clear
```

### Imágenes aún devuelven 404
```bash
# Verificar que el symlink existe:
ls -la public/storage

# Verificar que los archivos están en storage/app/public:
ls -la storage/app/public/

# Ver logs de errores:
tail -50 storage/logs/laravel.log
```

---

## 📝 Checklist Pre-Despliegue

- [ ] Base de datos creada y accesible
- [ ] Archivo `.env` configurado correctamente
- [ ] SSH probado y funciona
- [ ] Credenciales de GitHub (si es privado) disponibles
- [ ] Backup de datos sensibles guardado
- [ ] Dominio apuntando correctamente (DNS)
- [ ] SSL certificate activado

---

## 🔐 Seguridad Post-Despliegue

```bash
# 1. Cambiar permisos de archivos sensibles
chmod 600 .env
chmod 644 .env.example

# 2. Deshabilitar debug (ya está en .env APP_DEBUG=false)

# 3. Revisar que no hay archivos de desarrollo
rm -rf node_modules .git/hooks composer.lock.test

# 4. Configurar CORS si es necesario
# En config/cors.php

# 5. Verificar que logs no son públicos
# storage/logs/ debe estar protegido
```

---

## 📞 Contacto Soporte Hosting

Si necesitas ayuda desde el hosting:
- **Panel Control**: cPanel, Plesk o similar
- **Crear ticket mencionando**: 
  - "Necesito crear symlink en /public/storage"
  - "Necesito capacidad de ejecutar `php artisan` por SSH"

---

## ⏰ Timeline Estimado

| Tarea | Tiempo |
|-------|--------|
| Backup actual | 5 min |
| Descarga código | 2 min |
| Instalar dependencias | 5 min |
| Configurar .env | 5 min |
| Migraciones | 2 min |
| Permisos y symlinks | 3 min |
| Pruebas | 10 min |
| **TOTAL** | **~30 min** |

---

## 🎯 Próximos Pasos

1. **Hoy**: Conectarse por SSH y aplicar Opción A (reparación rápida)
2. **Si no funciona**: Aplicar Opción B (despliegue completo)
3. **Verificar**: Todo funciona según checklist
4. **Documentar**: Guardar credenciales y procesos

---

**¿Necesitas ayuda?** Proporciona:
- Usuario SSH
- Resultado de `pwd` en producción
- Resultado de `php artisan storage:link` (si lo ejecutaste)
- Últimas líneas de `storage/logs/laravel.log`
