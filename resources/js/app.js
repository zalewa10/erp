import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// DaisyUI helpers: theme-controller and collapse fallback for browsers without CSS :has support
document.addEventListener("DOMContentLoaded", () => {
    // Theme controller inputs (checkbox/radio). If checked, set `data-theme` on <html>.
    document.querySelectorAll(".theme-controller").forEach((el) => {
        const setTheme = (input) => {
            const theme = input.value || input.dataset.theme;
            if (!theme) return;
            if (input.type === "checkbox") {
                if (input.checked) {
                    document.documentElement.setAttribute("data-theme", theme);
                } else {
                    document.documentElement.removeAttribute("data-theme");
                }
            } else {
                document.documentElement.setAttribute("data-theme", theme);
            }
        };

        el.addEventListener("change", (e) => setTheme(e.target));
        // initialize on load
        setTheme(el);
    });

    // Collapse fallback: toggle `.collapse-open` on the parent when title clicked
    document.querySelectorAll(".collapse").forEach((collapse) => {
        const title = collapse.querySelector(".collapse-title");
        const input = collapse.querySelector(
            "input[type=checkbox], input[type=radio]"
        );
        if (!title) return;

        title.addEventListener("click", (e) => {
            if (!input) return;
            if (input.type === "radio") {
                // make this radio checked and remove open class from siblings
                input.checked = true;
                // close other collapses in same radio group
                if (input.name) {
                    document
                        .querySelectorAll(`input[name="${input.name}"]`)
                        .forEach((r) => {
                            const parent = r.closest(".collapse");
                            if (parent)
                                parent.classList.toggle(
                                    "collapse-open",
                                    r.checked
                                );
                        });
                } else {
                    collapse.classList.add("collapse-open");
                }
            } else {
                input.checked = !input.checked;
                collapse.classList.toggle("collapse-open", input.checked);
            }
        });
    });
});
