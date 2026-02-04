/* ============================================
   HISTORIA CPAP – Timeline interactions
   ============================================ */

document.addEventListener("DOMContentLoaded", () => {

    const items = document.querySelectorAll(".tl-item");

    items.forEach(item => {
        item.addEventListener("mouseenter", () => {
            item.classList.add("active");
        });

        item.addEventListener("mouseleave", () => {
            item.classList.remove("active");
        });
    });

});
