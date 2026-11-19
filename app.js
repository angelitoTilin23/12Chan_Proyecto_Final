document.addEventListener("DOMContentLoaded", () => {
    console.log("12 CHAN: JS Simplificado activo.");

    // 1. Auto-ajustar altura de los textareas al escribir
    document.querySelectorAll("textarea").forEach(ta => {
        ta.addEventListener("input", () => {
            ta.style.height = "auto";
            ta.style.height = Math.min(ta.scrollHeight, 320) + "px";
        });
    });

    // 2. Buscador en tiempo real de tablones en la barra lateral
    const search = document.querySelector('.boards-actions input[type="text"]');
    if (search) {
        search.addEventListener("input", () => {
            const term = search.value.trim().toLowerCase();
            document.querySelectorAll(".board-category").forEach(cat => {
                let visible = 0;
                cat.querySelectorAll("li").forEach(li => {
                    const matches = li.textContent.toLowerCase().includes(term);
                    li.style.display = matches ? "" : "none";
                    if (matches) visible++;
                });
                cat.style.display = visible ? "" : "none";
            });
        });
    }

    // 3. Validación rápida de formularios antes de enviar a PHP
    document.querySelectorAll("form").forEach(form => {
        form.addEventListener("submit", e => {
            const required = form.querySelectorAll("[required]");
            for (let field of required) {
                if (!field.value.trim()) {
                    alert("Por favor completa los campos obligatorios.");
                    field.focus();
                    e.preventDefault();
                    return;
                }
            }
        });
    });
});