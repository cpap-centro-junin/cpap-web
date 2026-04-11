<?php $__env->startSection('title', 'Editar Slide'); ?>
<?php $__env->startSection('page-title', 'Editar Slide'); ?>

<?php $__env->startSection('content'); ?>

<div style="margin-bottom:24px;">
    <a href="<?php echo e(route('admin.inicio.slides.index')); ?>" class="secondary-btn">
        <i class="fas fa-arrow-left"></i> Volver a Slides
    </a>
</div>

<form action="<?php echo e(route('admin.inicio.slides.update', $slide)); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    
    <div class="admin-form-card" style="margin-bottom:24px;">
        <h2 style="font-size:18px;font-weight:700;color:var(--dark);margin:0 0 20px;padding-bottom:12px;border-bottom:2px solid var(--light-gray);">
            <i class="fas fa-layer-group" style="color:var(--primary);margin-right:10px;"></i>
            1. Tipo de Slide
        </h2>

        <div class="form-group" style="margin:0;">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;">
                <label style="display:flex;flex-direction:column;align-items:center;gap:12px;padding:20px;border:3px solid <?php echo e(old('tipo', $slide->tipo) === 'noticia' ? 'var(--primary)' : 'var(--light-gray)'); ?>;border-radius:12px;cursor:pointer;transition:all 0.3s;background:<?php echo e(old('tipo', $slide->tipo) === 'noticia' ? 'rgba(139,21,56,0.05)' : 'white'); ?>;"
                       class="tipo-card <?php echo e(old('tipo', $slide->tipo) === 'noticia' ? 'selected' : ''); ?>"
                       onclick="document.getElementById('tipo_noticia').checked=true;cambiarTipo('noticia');actualizarSeleccion(this);">
                    <input type="radio" name="tipo" value="noticia" id="tipo_noticia" <?php echo e(old('tipo', $slide->tipo) === 'noticia' ? 'checked' : ''); ?> style="display:none;">
                    <div style="width:60px;height:60px;background:linear-gradient(135deg,#2196F3,#1976D2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-newspaper" style="color:white;font-size:24px;"></i>
                    </div>
                    <div style="text-align:center;">
                        <strong style="display:block;font-size:16px;color:var(--dark);margin-bottom:4px;">Noticia</strong>
                        <span style="font-size:13px;color:var(--medium-gray);">Vincular con noticia existente</span>
                    </div>
                </label>

                <label style="display:flex;flex-direction:column;align-items:center;gap:12px;padding:20px;border:3px solid <?php echo e(old('tipo', $slide->tipo) === 'evento' ? 'var(--primary)' : 'var(--light-gray)'); ?>;border-radius:12px;cursor:pointer;transition:all 0.3s;background:<?php echo e(old('tipo', $slide->tipo) === 'evento' ? 'rgba(139,21,56,0.05)' : 'white'); ?>;"
                       class="tipo-card <?php echo e(old('tipo', $slide->tipo) === 'evento' ? 'selected' : ''); ?>"
                       onclick="document.getElementById('tipo_evento').checked=true;cambiarTipo('evento');actualizarSeleccion(this);">
                    <input type="radio" name="tipo" value="evento" id="tipo_evento" <?php echo e(old('tipo', $slide->tipo) === 'evento' ? 'checked' : ''); ?> style="display:none;">
                    <div style="width:60px;height:60px;background:linear-gradient(135deg,#9C27B0,#7B1FA2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-calendar-alt" style="color:white;font-size:24px;"></i>
                    </div>
                    <div style="text-align:center;">
                        <strong style="display:block;font-size:16px;color:var(--dark);margin-bottom:4px;">Evento</strong>
                        <span style="font-size:13px;color:var(--medium-gray);">Vincular con evento existente</span>
                    </div>
                </label>

                <label style="display:flex;flex-direction:column;align-items:center;gap:12px;padding:20px;border:3px solid <?php echo e(old('tipo', $slide->tipo) === 'personalizado' ? 'var(--primary)' : 'var(--light-gray)'); ?>;border-radius:12px;cursor:pointer;transition:all 0.3s;background:<?php echo e(old('tipo', $slide->tipo) === 'personalizado' ? 'rgba(139,21,56,0.05)' : 'white'); ?>;"
                       class="tipo-card <?php echo e(old('tipo', $slide->tipo) === 'personalizado' ? 'selected' : ''); ?>"
                       onclick="document.getElementById('tipo_personalizado').checked=true;cambiarTipo('personalizado');actualizarSeleccion(this);">
                    <input type="radio" name="tipo" value="personalizado" id="tipo_personalizado" <?php echo e(old('tipo', $slide->tipo) === 'personalizado' ? 'checked' : ''); ?> style="display:none;">
                    <div style="width:60px;height:60px;background:linear-gradient(135deg,#4CAF50,#388E3C);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-edit" style="color:white;font-size:24px;"></i>
                    </div>
                    <div style="text-align:center;">
                        <strong style="display:block;font-size:16px;color:var(--dark);margin-bottom:4px;">Personalizado</strong>
                        <span style="font-size:13px;color:var(--medium-gray);">Contenido completamente custom</span>
                    </div>
                </label>
            </div>
            <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color:var(--danger);font-size:13px;margin:8px 0 0;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div class="form-group" id="campo_noticia" style="display:<?php echo e($slide->tipo === 'noticia' ? 'block' : 'none'); ?>;margin-top:24px;padding-top:24px;border-top:2px solid var(--light-gray);">
            <label for="noticia_id" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:12px;">
                Seleccionar Noticia
            </label>
            <select name="noticia_id" id="noticia_id" class="form-control" style="font-size:15px;padding:14px;" onchange="actualizarUrlSegunVinculacion()">
                <option value="">-- Selecciona una noticia --</option>
                <?php $__currentLoopData = $noticias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noticia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($noticia->id); ?>" data-url="<?php echo e(route('noticias.show', $noticia->id)); ?>" <?php echo e(old('noticia_id', $slide->noticia_id) == $noticia->id ? 'selected' : ''); ?>>
                        <?php echo e($noticia->titulo); ?> (<?php echo e($noticia->created_at->format('d/m/Y')); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['noticia_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color:var(--danger);font-size:13px;margin:8px 0 0;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div class="form-group" id="campo_evento" style="display:<?php echo e($slide->tipo === 'evento' ? 'block' : 'none'); ?>;margin-top:24px;padding-top:24px;border-top:2px solid var(--light-gray);">
            <label for="evento_id" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:12px;">
                Seleccionar Evento
            </label>
            <select name="evento_id" id="evento_id" class="form-control" style="font-size:15px;padding:14px;" onchange="actualizarUrlSegunVinculacion()">
                <option value="">-- Selecciona un evento --</option>
                <?php $__currentLoopData = $eventos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($evento->id); ?>" data-url="<?php echo e(route('eventos.show', $evento->id)); ?>" <?php echo e(old('evento_id', $slide->evento_id) == $evento->id ? 'selected' : ''); ?>>
                        <?php echo e($evento->titulo); ?> (<?php echo e($evento->fecha_inicio->format('d/m/Y')); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['evento_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color:var(--danger);font-size:13px;margin:8px 0 0;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    
    <div class="admin-form-card" style="margin-bottom:24px;">
        <h2 style="font-size:18px;font-weight:700;color:var(--dark);margin:0 0 20px;padding-bottom:12px;border-bottom:2px solid var(--light-gray);">
            <i class="fas fa-align-left" style="color:var(--primary);margin-right:10px;"></i>
            2. Contenido del Slide
        </h2>

        <div class="form-group">
            <label for="tag" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:8px;">
                Etiqueta Superior (opcional)
            </label>
            <input type="text" id="tag" name="tag" value="<?php echo e(old('tag', $slide->tag)); ?>" 
                   placeholder="Ej: Proceso de Colegiatura, Aniversario..." 
                   maxlength="50" class="form-control" style="font-size:15px;">
            <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;">
                💡 Texto pequeño que aparece arriba del título
            </small>
            <?php $__errorArgs = ['tag'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color:var(--danger);font-size:13px;margin:8px 0 0;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="titulo" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:8px;">
                Título del Slide <span style="color:var(--danger);">*</span>
            </label>
            
            
            <div style="margin-bottom:10px;">
                <button type="button" onclick="insertarSaltoLineaSlide('titulo')" 
                        style="padding:8px 16px;background:#f5f5f5;border:1px solid #ddd;border-radius:6px;cursor:pointer;font-size:13px;display:inline-flex;align-items:center;gap:8px;transition:all 0.2s;font-weight:500;"
                        onmouseover="this.style.background='#e8e8e8';this.style.borderColor='#ccc'"
                        onmouseout="this.style.background='#f5f5f5';this.style.borderColor='#ddd'">
                    <i class="fas fa-level-down-alt" style="color:var(--primary);"></i>
                    <span>Salto de Línea</span>
                </button>
            </div>
            
            <input type="text" id="titulo" name="titulo" value="<?php echo e(old('titulo', $slide->titulo)); ?>" required 
                   placeholder="¡Proceso de Colegiatura 2026 Abierto!" 
                   maxlength="200" class="form-control" style="font-size:16px;font-weight:600;">
            <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;background:#f0f7ff;padding:10px;border-radius:6px;border-left:3px solid var(--primary);">
                💡 Coloca el cursor donde quieras el salto de línea y presiona el botón
            </small>
            <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color:var(--danger);font-size:13px;margin:8px 0 0;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="descripcion" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:8px;">
                Descripción (opcional)
            </label>
            <textarea id="descripcion" name="descripcion" rows="4" class="form-control" style="font-size:14px;line-height:1.6;"
                      placeholder="Texto descriptivo que acompaña al slide..."><?php echo e(old('descripcion', $slide->descripcion)); ?></textarea>
            <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color:var(--danger);font-size:13px;margin:8px 0 0;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="imagen" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:8px;">
                Imagen de Fondo (opcional)
            </label>
            
            <?php if($slide->imagen): ?>
                <div style="margin-bottom:16px;padding:16px;background:#f8f9fa;border-radius:8px;border-left:4px solid var(--primary);">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                        <div style="width:80px;height:80px;background:white;border-radius:6px;overflow:hidden;border:2px solid var(--light-gray);">
                            <img src="<?php echo e($slide->imagen_final); ?>" alt="Imagen actual" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <div>
                            <p style="margin:0 0 4px;font-weight:600;color:var(--dark);">📷 Imagen Actual</p>
                            <p style="margin:0;font-size:12px;color:var(--medium-gray);">Si subes una nueva, esta será reemplazada</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/jpg,image/png,image/webp" class="form-control">
            <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;background:#f0f7ff;padding:10px;border-radius:6px;border-left:3px solid #2196F3;">
                <strong>📐 Tamaño recomendado:</strong> 1400 x 620 píxeles<br>
                <strong>📦 Tamaño máximo:</strong> 5 MB<br>
                <strong>💡 Nota:</strong> Si vinculas con noticia/evento y no subes imagen, se usará su imagen automáticamente
            </small>
            <?php $__errorArgs = ['imagen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color:var(--danger);font-size:13px;margin:8px 0 0;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    
    <div class="admin-form-card" style="margin-bottom:24px;">
        <h2 style="font-size:18px;font-weight:700;color:var(--dark);margin:0 0 20px;padding-bottom:12px;border-bottom:2px solid var(--light-gray);">
            <i class="fas fa-mouse-pointer" style="color:var(--primary);margin-right:10px;"></i>
            3. Botón de Acción
        </h2>

        <div style="display:grid;grid-template-columns:1fr 2fr;gap:20px;">
            <div class="form-group">
                <label for="boton_texto" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:8px;">
                    Texto del Botón
                </label>
                <input type="text" id="boton_texto" name="boton_texto" value="<?php echo e(old('boton_texto', $slide->boton_texto ?? 'Ver Más')); ?>" 
                       placeholder="Ver Más" maxlength="50" class="form-control" style="font-size:15px;">
                <?php $__errorArgs = ['boton_texto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p style="color:var(--danger);font-size:13px;margin:8px 0 0;"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="boton_url" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:8px;">
                    Enlace (¿A dónde va?) <span style="color:var(--danger);">*</span>
                </label>
                <input type="text" id="boton_url" name="boton_url" value="<?php echo e(old('boton_url', $slide->boton_url)); ?>" required 
                       placeholder="/#colegiatura" class="form-control" style="font-size:15px;">
                <small id="url_helper" style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;background:#fff8e6;padding:10px;border-radius:6px;border-left:3px solid #FFC107;">
                    <strong>📍 Ejemplos:</strong><br>
                    • Sección interna: <code style="background:white;padding:2px 6px;border-radius:3px;">/#colegiatura</code><br>
                    • Página interna: <code style="background:white;padding:2px 6px;border-radius:3px;">/nosotros</code><br>
                    • Sitio externo: <code style="background:white;padding:2px 6px;border-radius:3px;">https://ejemplo.com</code>
                </small>
                <small id="url_bloqueado" style="display:none;color:#0288D1;font-size:12px;margin-top:8px;background:#E3F2FD;padding:10px;border-radius:6px;border-left:3px solid #0288D1;">
                    <strong>URL automática:</strong> Este campo se rellena automáticamente con la URL de la noticia/evento vinculado.
                </small>
                <?php $__errorArgs = ['boton_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p style="color:var(--danger);font-size:13px;margin:8px 0 0;"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </div>

    
    <div class="admin-form-card" style="margin-bottom:24px;">
        <h2 style="font-size:18px;font-weight:700;color:var(--dark);margin:0 0 20px;padding-bottom:12px;border-bottom:2px solid var(--light-gray);">
            <i class="fas fa-cog" style="color:var(--primary);margin-right:10px;"></i>
            4. Configuración
        </h2>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <div class="form-group">
                <label for="orden" style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:8px;">
                    Orden de Aparición
                </label>
                <input type="number" id="orden" name="orden" value="<?php echo e(old('orden', $slide->orden ?? 0)); ?>" min="0" class="form-control" style="font-size:15px;">
                <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;">
                    💡 Número menor = aparece primero en el carrusel
                </small>
                <?php $__errorArgs = ['orden'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p style="color:var(--danger);font-size:13px;margin:8px 0 0;"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label style="display:flex;align-items:center;gap:8px;font-weight:600;color:var(--dark);margin-bottom:12px;">
                    Estado del Slide
                </label>
                <label class="toggle-switch" style="display:flex;align-items:center;gap:12px;margin-top:4px;">
                    <input type="checkbox" name="activo" id="activo" <?php echo e(old('activo', $slide->activo) ? 'checked' : ''); ?>>
                    <span class="toggle-slider"></span>
                </label>
                <small style="color:var(--medium-gray);font-size:12px;display:block;margin-top:8px;">
                    💡 Solo los slides activos se muestran en el carrusel
                </small>
            </div>
        </div>
    </div>

    
    <div style="display:flex;gap:12px;justify-content:flex-end;padding:20px;background:white;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
        <a href="<?php echo e(route('admin.inicio.slides.index')); ?>" class="secondary-btn" style="padding:12px 24px;">
            <i class="fas fa-times"></i> Cancelar
        </a>
        <button type="submit" class="primary-btn" style="padding:12px 32px;">
            <i class="fas fa-save"></i> Guardar Cambios
        </button>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function insertarSaltoLineaSlide(fieldId) {
    const input = document.getElementById(fieldId);
    if (!input) return;
    
    const cursorPos = input.selectionStart;
    const textBefore = input.value.substring(0, cursorPos);
    const textAfter = input.value.substring(cursorPos);
    
    input.value = textBefore + '<br>' + textAfter;
    input.selectionStart = input.selectionEnd = cursorPos + 4;
    input.focus();
}

function cambiarTipo(tipo) {
    document.getElementById('campo_noticia').style.display = 'none';
    document.getElementById('campo_evento').style.display = 'none';
    
    const botonUrlInput = document.getElementById('boton_url');
    const urlHelper = document.getElementById('url_helper');
    const urlBloqueado = document.getElementById('url_bloqueado');
    
    if (tipo === 'noticia') {
        document.getElementById('campo_noticia').style.display = 'block';
        // Bloquear URL y mostrar mensaje
        botonUrlInput.readOnly = true;
        botonUrlInput.style.backgroundColor = '#f5f5f5';
        botonUrlInput.style.cursor = 'not-allowed';
        urlHelper.style.display = 'none';
        urlBloqueado.style.display = 'block';
        actualizarUrlSegunVinculacion();
    } else if (tipo === 'evento') {
        document.getElementById('campo_evento').style.display = 'block';
        // Bloquear URL y mostrar mensaje
        botonUrlInput.readOnly = true;
        botonUrlInput.style.backgroundColor = '#f5f5f5';
        botonUrlInput.style.cursor = 'not-allowed';
        urlHelper.style.display = 'none';
        urlBloqueado.style.display = 'block';
        actualizarUrlSegunVinculacion();
    } else {
        // Modo personalizado: desbloquear URL
        botonUrlInput.readOnly = false;
        botonUrlInput.style.backgroundColor = '';
        botonUrlInput.style.cursor = '';
        urlHelper.style.display = 'block';
        urlBloqueado.style.display = 'none';
    }
}

function actualizarUrlSegunVinculacion() {
    const tipo = document.querySelector('input[name="tipo"]:checked').value;
    const botonUrlInput = document.getElementById('boton_url');
    
    if (tipo === 'noticia') {
        const noticiaSelect = document.getElementById('noticia_id');
        const selectedOption = noticiaSelect.options[noticiaSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            botonUrlInput.value = selectedOption.getAttribute('data-url') || '';
        } else {
            botonUrlInput.value = '';
        }
    } else if (tipo === 'evento') {
        const eventoSelect = document.getElementById('evento_id');
        const selectedOption = eventoSelect.options[eventoSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            botonUrlInput.value = selectedOption.getAttribute('data-url') || '';
        } else {
            botonUrlInput.value = '';
        }
    }
}

function actualizarSeleccion(elemento) {
    document.querySelectorAll('.tipo-card').forEach(card => {
        card.style.borderColor = 'var(--light-gray)';
        card.style.background = 'white';
        card.classList.remove('selected');
    });
    elemento.style.borderColor = 'var(--primary)';
    elemento.style.background = 'rgba(139,21,56,0.05)';
    elemento.classList.add('selected');
}

document.addEventListener('DOMContentLoaded', function() {
    const tipoSeleccionado = document.querySelector('input[name="tipo"]:checked');
    if (tipoSeleccionado) {
        cambiarTipo(tipoSeleccionado.value);
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/admin/inicio/slides/edit.blade.php ENDPATH**/ ?>