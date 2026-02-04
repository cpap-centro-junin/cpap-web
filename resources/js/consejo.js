// Interacciones suaves para Consejo Directivo


document.addEventListener('DOMContentLoaded', () => {
const cards = document.querySelectorAll('.consejo-card');


cards.forEach(card => {
card.addEventListener('mouseenter', () => {
card.style.transition = 'all 0.3s ease';
});


card.addEventListener('mousemove', e => {
const rect = card.getBoundingClientRect();
const x = e.clientX - rect.left;
const y = e.clientY - rect.top;


const centerX = rect.width / 2;
const centerY = rect.height / 2;


const rotateX = ((y - centerY) / 18).toFixed(2);
const rotateY = ((centerX - x) / 18).toFixed(2);


card.style.transform = `translateY(-12px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
});


card.addEventListener('mouseleave', () => {
card.style.transform = 'translateY(0) rotateX(0) rotateY(0)';
});
});


console.log('✅ Consejo Directivo JS cargado correctamente');
});