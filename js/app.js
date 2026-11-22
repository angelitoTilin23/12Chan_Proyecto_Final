document.addEventListener("DOMContentLoaded", () => {
    console.log("12 CHAN: JS completo activo.");

    // ==========================================
    // 1. MOSTRAR / OCULTAR FORMULARIO DE PUBLICACIÓN
    // ==========================================
    const btnToggleForm = document.getElementById("btnToggleForm");
    const formPublicarContainer = document.getElementById("formPublicarContainer");

    if (btnToggleForm && formPublicarContainer) {
        btnToggleForm.addEventListener("click", () => {
            const estaOculto =
                window.getComputedStyle(formPublicarContainer).display === "none";
            formPublicarContainer.style.display = estaOculto ? "block" : "none";
            btnToggleForm.textContent = estaOculto
                ? "✕ Cerrar formulario"
                : "+ Crear publicación";
        });
    }

    // ==========================================
    // 2. AUTO-AJUSTAR ALTURA DE TEXTAREAS
    // ==========================================
    document.querySelectorAll("textarea").forEach((ta) => {
        const ajustarAltura = () => {
            ta.style.height = "auto";
            ta.style.height = Math.min(ta.scrollHeight, 320) + "px";
        };
        ta.addEventListener("input", ajustarAltura);
        ajustarAltura();
    });

    // ==========================================
    // 3. BUSCADOR EN TIEMPO REAL DE TABLEROS
    // ==========================================
    const buscadorTableros = document.getElementById("buscadorTableros");

    if (buscadorTableros) {
        buscadorTableros.addEventListener("input", () => {
            const termino = buscadorTableros.value.trim().toLowerCase();

            document.querySelectorAll(".board-category").forEach((categoria) => {
                const items = categoria.querySelectorAll("li");
                if (!items.length) return;

                let visibles = 0;
                items.forEach((li) => {
                    const coincide = li.textContent.toLowerCase().includes(termino);
                    li.style.display = coincide ? "" : "none";
                    if (coincide) visibles++;
                });

                categoria.style.display = visibles > 0 ? "" : "none";
            });
        });
    }

    // ==========================================
    // 4. VALIDACIÓN Y NOMBRE DE ARCHIVO DE IMAGEN
    // ==========================================
    const inputImagen = document.getElementById("imagen");
    const labelArchivo = document.querySelector('label[for="imagen"].archivo-btn');

    if (inputImagen) {
        const htmlOriginal = labelArchivo ? labelArchivo.innerHTML : "";

        inputImagen.addEventListener("change", () => {
            const archivo = inputImagen.files[0];

            if (!archivo) {
                if (labelArchivo) labelArchivo.innerHTML = htmlOriginal;
                return;
            }

            if (!archivo.type.startsWith("image/")) {
                alert("Por favor selecciona un archivo de imagen válido.");
                inputImagen.value = "";
                if (labelArchivo) labelArchivo.innerHTML = htmlOriginal;
                return;
            }

            if (archivo.size > 5 * 1024 * 1024) {
                alert("La imagen no puede superar los 5 MB.");
                inputImagen.value = "";
                if (labelArchivo) labelArchivo.innerHTML = htmlOriginal;
                return;
            }

            if (labelArchivo) {
                labelArchivo.innerHTML = `${htmlOriginal} <span>${archivo.name}</span>`;
            }
        });
    }

    // ==========================================
    // 5. CREAR NUEVO TABLERO EN MYSQL VIA FETCH
    // ==========================================
    const inputNuevoTablero = document.getElementById("nuevoTableroInput");
    const btnCrearTablero = document.querySelector(".boards-actions button");
    const listaComunidades = document.getElementById("listaComunidades");

    if (inputNuevoTablero && btnCrearTablero && listaComunidades) {
        const agregarEnlaceComunidad = ({ Nombre, Slug }) => {
            const li = document.createElement("li");
            const a = document.createElement("a");
            a.href = `board.php?tablero=${encodeURIComponent(Slug)}`;
            a.textContent = Nombre;
            li.appendChild(a);
            listaComunidades.appendChild(li);
        };

        btnCrearTablero.addEventListener("click", async () => {
            const nombre = inputNuevoTablero.value.trim();

            if (!nombre) {
                alert("Escribe un nombre para el nuevo tablero.");
                inputNuevoTablero.focus();
                return;
            }

            btnCrearTablero.disabled = true;

            try {
                const resp = await fetch("crear_tablero.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ nombre })
                });

                const data = await resp.json();

                if (!resp.ok || !data.ok) {
                    alert(data.error || "No se pudo crear el tablero.");
                    return;
                }

                if (!data.existente) {
                    agregarEnlaceComunidad(data.tablero);
                }

                inputNuevoTablero.value = "";
                window.location.href = `board.php?tablero=${encodeURIComponent(data.tablero.Slug)}`;
            } catch (err) {
                alert("Error de comunicación con el servidor.");
            } finally {
                btnCrearTablero.disabled = false;
            }
        });
    }

    // ==========================================
    // 6. VALIDACIÓN DE CAMPOS OBLIGATORIOS EN FORMS
    // ==========================================
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", (e) => {
            const requeridos = form.querySelectorAll("[required]");
            for (const campo of requeridos) {
                if (!campo.value.trim()) {
                    alert("Por favor completa todos los campos obligatorios.");
                    campo.focus();
                    e.preventDefault();
                    return;
                }
            }
        });
    });
});