
<a href="https://wa.me/51943667317?text=Hola,%20quisiera%20información%20sobre%20el%20CPAP%20Región%20Centro" 
   target="_blank" 
   class="whatsapp-float" 
   title="Escríbenos por WhatsApp"
   aria-label="Contactar por WhatsApp">
    <i class="fab fa-whatsapp" style="color:white;"></i>
    <span class="whatsapp-float-text">¿Necesitas ayuda?</span>
</a>

<style>
/* Botón Flotante de WhatsApp */
.whatsapp-float {
    position: fixed;
    bottom: 100px;
    right: 25px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
    z-index: 9999;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    overflow: visible;
}

.whatsapp-float:hover {
    transform: scale(1.1) translateY(-5px);
    box-shadow: 0 8px 30px rgba(37, 211, 102, 0.6);
    width: auto;
    padding: 0 20px;
    border-radius: 30px;
}

.whatsapp-float i {
    transition: all 0.3s ease;
}

.whatsapp-float:hover i {
    animation: shake 0.5s;
}

.whatsapp-float-text {
    color: white;
    display: none;
    margin-left: 10px;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
}

.whatsapp-float:hover .whatsapp-float-text {
    display: inline;
}

/* Animación de sacudida */
@keyframes shake {
    0%, 100% { transform: rotate(0deg); }
    10%, 30%, 50%, 70%, 90% { transform: rotate(-10deg); }
    20%, 40%, 60%, 80% { transform: rotate(10deg); }
}

/* Pulso animado */
.whatsapp-float::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    background: rgba(37, 211, 102, 0.3);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -50%) scale(1.5);
        opacity: 0;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .whatsapp-float {
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        font-size: 26px;
    }
    
    .whatsapp-float:hover {
        width: 50px;
        padding: 0;
        border-radius: 50%;
    }
    
    .whatsapp-float-text {
        display: none !important;
    }
}
</style>
<?php /**PATH C:\laragon\www\cpap-web\resources\views/components/whatsapp-float.blade.php ENDPATH**/ ?>