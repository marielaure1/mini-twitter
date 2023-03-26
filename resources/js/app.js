import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.querySelectorAll(".options-btn").forEach((element) => {
    element.addEventListener("click", () => {
        document.querySelectorAll(".options-btn").forEach(e => {
            if(e != element){
                document.querySelector(e.getAttribute("data-target")).classList.remove("active")
            }
        });
        document.querySelector(element.getAttribute("data-target")).classList.toggle("active")
    })
})