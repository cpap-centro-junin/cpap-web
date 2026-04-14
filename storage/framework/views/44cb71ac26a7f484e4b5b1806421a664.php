<?php $__env->startSection('title','Detalle Mensaje'); ?>
<?php $__env->startSection('page-title','Detalle del Mensaje'); ?>

<?php $__env->startSection('content'); ?>

<div class="msg-detail-wrap">

    
    <div class="msg-detail-card msg-sender-card">
        <div class="msg-detail-avatar">
            <?php echo e(strtoupper(substr($message->nombre,0,2))); ?>

        </div>
        <div class="msg-detail-meta">
            <div class="msg-detail-top">
                <h3><?php echo e($message->asunto); ?></h3>
                <span class="msg-detail-status <?php echo e($message->leido ? 'msg-detail-status--read' : 'msg-detail-status--new'); ?>">
                    <i class="fas <?php echo e($message->leido ? 'fa-check-double' : 'fa-circle'); ?>"></i>
                    <?php echo e($message->leido ? 'Leído' : 'Nuevo'); ?>

                </span>
            </div>
            <div class="msg-detail-info">
                <span><i class="fas fa-user"></i> <?php echo e($message->nombre); ?></span>
                <a href="mailto:<?php echo e($message->email); ?>" class="msg-detail-link">
                    <i class="fas fa-envelope"></i> <?php echo e($message->email); ?>

                </a>
                <?php if($message->telefono): ?>
                <a href="tel:<?php echo e($message->telefono); ?>" class="msg-detail-link">
                    <i class="fas fa-phone"></i> <?php echo e($message->telefono); ?>

                </a>
                <?php else: ?>
                <span class="msg-detail-muted"><i class="fas fa-phone"></i> Sin teléfono</span>
                <?php endif; ?>
                <span><i class="fas fa-calendar-alt"></i> <?php echo e($message->created_at->format('d/m/Y h:i A')); ?></span>
            </div>
        </div>
    </div>

    
    <div class="msg-detail-card">
        <div class="msg-section-label">
            <i class="fas fa-comment-alt"></i> Mensaje recibido
        </div>
        <div class="msg-body-text">
            <?php echo nl2br(e($message->mensaje)); ?>

        </div>
    </div>

    <?php if($message->respuesta): ?>
    
    <div class="msg-detail-card msg-replied-card">
        <div class="msg-section-label msg-section-label--success">
            <i class="fas fa-paper-plane"></i> Respuesta enviada
        </div>
        <div class="msg-body-text">
            <?php echo nl2br(e($message->respuesta)); ?>

        </div>
        <?php if($message->archivo_respuesta): ?>
        <div class="msg-file-actions">
            <a href="<?php echo e($message->archivoRespuestaUrl); ?>" target="_blank" class="msg-file-link">
                <i class="fas fa-eye"></i> Ver archivo adjunto
            </a>
            <a href="<?php echo e(route('admin.mensajes.descargar-respuesta', $message)); ?>" class="msg-file-link msg-file-link--download">
                <i class="fas fa-download"></i> Descargar
            </a>
        </div>
        <?php endif; ?>
    </div>
    <?php else: ?>
    
    <div class="msg-detail-card">
        <div class="msg-section-label">
            <i class="fas fa-reply"></i> Responder mensaje
        </div>

        <form method="POST"
              action="<?php echo e(route('admin.mensajes.responder', $message)); ?>"
              enctype="multipart/form-data"
              class="msg-reply-form">
            <?php echo csrf_field(); ?>

            <div class="msg-reply-field">
                <label>Texto de respuesta <span class="msg-required">*</span></label>
                <textarea name="respuesta"
                          class="msg-reply-textarea"
                          placeholder="Redacta la respuesta institucional aquí..."
                          rows="7"
                          required></textarea>
            </div>

            <div class="msg-upload-area">
                <label class="msg-upload-label" for="archivoInput">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Adjuntar archivo (opcional)</span>
                    <small>PDF, DOC, JPG, PNG — máx. 5 MB</small>
                </label>
                <input type="file" name="archivo" id="archivoInput" class="msg-upload-input">
                <div class="msg-file-preview" id="filePreview" style="display:none;">
                    <i class="fas fa-file-alt"></i>
                    <span id="fileName"></span>
                    <button type="button" class="msg-remove-file" onclick="removeFile()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="msg-reply-btn">
                <i class="fas fa-paper-plane"></i>
                Enviar Respuesta
            </button>
        </form>
    </div>
    <?php endif; ?>

    <div class="msg-back-row">
        <a href="<?php echo e(route('admin.mensajes.index')); ?>" class="msg-back-link">
            <i class="fas fa-arrow-left"></i> Volver a mensajes
        </a>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const fileInput = document.getElementById("archivoInput");
if(fileInput){
    const filePreview = document.getElementById("filePreview");
    const fileName    = document.getElementById("fileName");
    fileInput.addEventListener("change", function(){
        if(this.files.length > 0){
            fileName.textContent = this.files[0].name;
            filePreview.style.display = "flex";
        }
    });
}
function removeFile(){
    document.getElementById("archivoInput").value = "";
    document.getElementById("filePreview").style.display = "none";
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\cpap-web\resources\views/admin/mensajes/show.blade.php ENDPATH**/ ?>