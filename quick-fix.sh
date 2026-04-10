#!/bin/bash

# ╔════════════════════════════════════════════════════════════╗
# ║    CPAP WEB - QUICK FIX (Reparación de Symlink/Permisos)  ║
# ║        Para cuando la web ya está pero las imágenes no     ║
# ╚════════════════════════════════════════════════════════════╝

echo "═══════════════════════════════════════════════════════════"
echo "🔧 Reparación Rápida - CPAP Web"
echo "═══════════════════════════════════════════════════════════"
echo ""

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

info() { echo -e "${GREEN}✓${NC} $1"; }
warn() { echo -e "${YELLOW}⚠${NC} $1"; }
error() { echo -e "${RED}✗${NC} $1"; exit 1; }

# ═══════════════════════════════════════════════════════════
# 1. DIAGNOSIS
# ═══════════════════════════════════════════════════════════

echo ""
echo "📊 Haciendo diagnóstico..."
echo ""

echo "Ubicación actual:"
pwd

echo ""
echo "Verificando directorios:"

if [ -d storage/app/public ]; then
    info "storage/app/public existe"
else
    warn "storage/app/public NO existe"
fi

if [ -d storage/logs ]; then
    info "storage/logs existe"
else
    warn "storage/logs NO existe"
fi

if [ -d bootstrap/cache ]; then
    info "bootstrap/cache existe"
else
    warn "bootstrap/cache NO existe"
fi

if [ -L public/storage ]; then
    info "public/storage es un symlink ✓"
    echo "  Target: $(readlink public/storage)"
else
    warn "public/storage NO es válido o no existe"
fi

# ═══════════════════════════════════════════════════════════
# 2. CREATE DIRECTORIES
# ═══════════════════════════════════════════════════════════

echo ""
echo "📁 Creando directorios..."

mkdir -p storage/app/public && info "storage/app/public"
mkdir -p storage/logs && info "storage/logs"
mkdir -p bootstrap/cache && info "bootstrap/cache"

# ═══════════════════════════════════════════════════════════
# 3. REMOVE OLD SYMLINK IF BROKEN
# ═══════════════════════════════════════════════════════════

echo ""
echo "🔗 Preparando symlink..."

if [ -e public/storage ] && ! [ -L public/storage ]; then
    warn "public/storage es un directorio, convirtiéndolo a symlink..."
    rm -rf public/storage
    info "Directorio removido"
elif [ -L public/storage ] && ! [ -e public/storage ]; then
    warn "Symlink quebrado, removiendo..."
    rm public/storage
    info "Symlink roto removido"
fi

# ═══════════════════════════════════════════════════════════
# 4. CREATE SYMLINK
# ═══════════════════════════════════════════════════════════

echo ""
echo "🔗 Creando nuevo symlink..."

if php artisan storage:link; then
    info "Symlink creado exitosamente"
else
    error "Error al crear symlink con artisan"
fi

# Verify
if [ -L public/storage ]; then
    info "Symlink verificado"
    echo "  Real path: $(realpath public/storage)"
else
    error "Symlink no se creó correctamente"
fi

# ═══════════════════════════════════════════════════════════
# 5. PERMISSIONS
# ═══════════════════════════════════════════════════════════

echo ""
echo "🔒 Configurando permisos..."

chmod -R 755 storage && info "storage/ (755)"
chmod -R 755 bootstrap/cache && info "bootstrap/cache/ (755)"
chmod 644 .env && info ".env (644)"

# ═══════════════════════════════════════════════════════════
# 6. CACHE CLEAR
# ═══════════════════════════════════════════════════════════

echo ""
echo "⚡ Limpiando cachés..."

php artisan config:clear -q && info "Config cache limpiado"
php artisan cache:clear -q && info "Cache limpiado"
php artisan view:clear -q && info "View cache limpiado"

# ═══════════════════════════════════════════════════════════
# 7. VERIFY PHP
# ═══════════════════════════════════════════════════════════

echo ""
echo "✅ Verificaciones finales..."

if [ -f artisan ]; then
    info "Archivo artisan encontrado"
else
    error "Archivo artisan NO encontrado - ¿estás en la carpeta correcta?"
fi

if [ -f .env ]; then
    info "Archivo .env existe"
else
    error ".env no existe - cópialo de .env.example"
fi

# ═══════════════════════════════════════════════════════════
# DONE
# ═══════════════════════════════════════════════════════════

echo ""
echo "═══════════════════════════════════════════════════════════"
echo -e "${GREEN}✅ REPARACIÓN COMPLETADA${NC}"
echo "═══════════════════════════════════════════════════════════"
echo ""
echo "📋 Próximos pasos:"
echo "   1. Recarga tu navegador: https://tu-dominio.com"
echo "   2. Intenta subir una imagen/PDF en /admin"
echo "   3. Verifica que ahora aparecen sin errores 404"
echo ""
echo "❓ Si aún hay problemas:"
echo "   tail -f storage/logs/laravel.log"
echo ""
