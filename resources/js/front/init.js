import jQuery from "jquery";
window.$ = window.jQuery = jQuery;
import { initCarousels } from "./carousels";
import { initEvents, initScroll } from "./events";
import { initIconPicker } from "./iconpicker";

export function initFrontend() {
    initScroll();
    initEvents();
    initCarousels();
    initIconPicker();
}

$(document).ready(initFrontend);
// document.addEventListener("livewire:navigated", initFrontend);
let initRunning = false;

Livewire.hook('morph.updated', () => {
    if (initRunning) return;
    initRunning = true;

    setTimeout(() => {
        initFrontend();
        initRunning = false;
    }, 100);
});

