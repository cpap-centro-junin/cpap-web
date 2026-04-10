#!/bin/bash

# ╔════════════════════════════════════════════════════════════╗
# ║         CPAP WEB - DEPLOY SCRIPT FOR PRODUCTION            ║
# ║                 Despliegue Automatizado                    ║
# ╚════════════════════════════════════════════════════════════╝

set -e

echo "═══════════════════════════════════════════════════════════"
echo "🚀 Iniciando despliegue a producción"
echo "═══════════════════════════════════════════════════════════"
echo ""

# Color codes
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

# Función para imprimir con color
info() { echo -e "${GREEN}✓${NC} $1"; }
warn() { echo -e "${YELLOW}⚠${NC} $1"; }
error() { echo -e "${RED}✗${NC} $1"; exit 1; }

# ═══════════════════════════════════════════════════════════
# 1. BACKUP
# ═══════════════════════════════════════════════════════════

echo ""
echo "📦 PASO 1: Creando backup..."

mkdir -p backups
BACKUP_FILE="backups/backup-$(date +%Y%m%d-%H%M%S).tar.gz"

if tar -czf "$BACKUP_FILE" \
    storage/app/public \
    database \
    .env 2>/dev/null ; then
    info "Backup guardado en: $BACKUP_FILE"
else
    warn "No se pudo hacer backup completo (esto es normal si es primera vez)"
fi

# ═══════════════════════════════════════════════════════════
# 2. ACTUALIZAR CÓDIGO
# ═══════════════════════════════════════════════════════════

echo ""
echo "📥 PASO 2: Actualizando código desde repositorio..."

if [ -d .git ]; then
    if git pull origin main; then
        info "Código actualizado exitosamente"
    else
        error "Error al hacer git pull. Verifica el repositorio."
    fi
else
    warn "No es un repositorio git. Saltando actualización de código."
fi

# ═══════════════════════════════════════════════════════════
# 3. INSTALAR DEPENDENCIAS
# ═══════════════════════════════════════════════════════════

echo ""
echo "📚 PASO 3: Instalando dependencias PHP..."

if command -v composer &> /dev/null; then
    if composer install --optimize-autoloader --no-dev --no-interaction -q; then
        info "Dependencias PHP instaladas"
    else
        error "Error al instalar dependencias con Composer"
    fi
else
    error "Composer no está instalado. Instálalo primero: https://getcomposer.org/"
fi

# ═══════════════════════════════════════════════════════════
# 4. INSTALAR ASSETS (Node)
# ═══════════════════════════════════════════════════════════

echo ""
echo "🎨 PASO 4: Compilando assets..."

if [ -f package.json ]; then
    if command -v npm &> /dev/null; then
        if npm ci --no-audit -q; then
            info "Dependencias Node instaladas"
        else
            warn "Error instalando npm. Continuando..."
        fi
        
        if npm run build; then
            info "Assets compilados exitosamente"
        else
            error "Error compilando assets"
        fi
    else
        warn "npm no está instalado. Saltando compilación de assets."
    fi
else
    info "package.json no encontrado. Saltando assets."
fi

# ═══════════════════════════════════════════════════════════
# 5. MIGRACIONES DE BD
# ═══════════════════════════════════════════════════════════

echo ""
echo "🗄️  PASO 5: Ejecutando migraciones..."

if php artisan migrate --force --no-interaction; then
    info "Migraciones completadas"
else
    warn "Error en migraciones o BD no configurada"
fi

# ═══════════════════════════════════════════════════════════
# 6. CREAR SYMLINK
# ═══════════════════════════════════════════════════════════

echo ""
echo "🔗 PASO 6: Creando symlink para storage..."

if mkdir -p storage/app/public; then
    if php artisan storage:link; then
        info "Symlink de storage creado"
    else
        error "Error creando symlink"
    fi
else
    error "No se pudo crear directorio storage/app/public"
fi

# ═══════════════════════════════════════════════════════════
# 7. CACHÉS Y OPTIMIZACIÓN
# ═══════════════════════════════════════════════════════════

echo ""
echo "⚡ PASO 7: Optimizando aplicación..."

php artisan config:cache -q && info "Config cacheado"
php artisan route:cache -q && info "Rutas cacheadas"
php artisan view:cache -q && info "Vistas cacheadas"
php artisan optimize -q && info "Optimización completada"

# ═══════════════════════════════════════════════════════════
# 8. PERMISOS
# ═══════════════════════════════════════════════════════════

echo ""
echo "🔒 PASO 8: Configurando permisos..."

chmod -R 755 storage bootstrap/cache
info "Permisos establecidos correctamente"

# ═══════════════════════════════════════════════════════════
# 9. VERIFICACIÓN
# ═══════════════════════════════════════════════════════════

echo ""
echo "✅ PASO 9: Verificando instalación..."

echo ""
echo "Verificaciones:"

# Verificar symlink
if [ -L public/storage ]; then
    info "Symlink public/storage existe"
else
    error "Symlink public/storage NO existe"
fi

# Verificar .env
if [ -f .env ]; then
    info "Archivo .env existe"
else
    error "Archivo .env NO existe. Cópialo de .env.example"
fi

# Verificar directorios críticos
if [ -d storage/app/public ] && [ -d storage/logs ] && [ -d bootstrap/cache ]; then
    info "Directorios críticos existen"
else
    warn "Algunos directorios no existen. Verifica manualmente."
fi

# ═══════════════════════════════════════════════════════════
# RESUMEN FINAL
# ═══════════════════════════════════════════════════════════

echo ""
echo "═══════════════════════════════════════════════════════════"
echo -e "${GREEN}✅ DESPLIEGUE COMPLETADO EXITOSAMENTE${NC}"
echo "═══════════════════════════════════════════════════════════"
echo ""
echo "📋 Próximos pasos:"
echo "   1. Accede a https://tu-dominio.com"
echo "   2. Verifica que no hay errores 500"
echo "   3. Prueba subiendo una imagen en /admin"
echo "   4. Si hay problemas, revisa: tail -f storage/logs/laravel.log"
echo ""
echo "💾 Tu backup está en: $BACKUP_FILE"
echo ""
