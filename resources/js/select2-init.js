
import select2 from 'select2';
select2();

function select2Initialize() {

    const $ = window.$;

    if (typeof $ === 'undefined') {
        console.error('jQuery is not defined');
        return;
    }

    $("select.select2").each(function() {
        const $this = $(this);
        const selectId = $this.attr("id");
        const placeholder = $this.attr("placeholder") || "Select an option";

        if ($this.hasClass("select2-initialized")) return;

        $this.select2({
            placeholder
        }).on("change", function() {
            const value = $(this).val();
            const compId = $(this).closest("[wire\\:id]").attr("wire:id");
            const component = Livewire.find(compId);
            if (component) component.set(selectId, value);
        });

        if ($this.hasClass("is-invalid")) {
            $this.next(".select2-container")
                .find(".select2-selection")
                .addClass("is-invalid");
        }

        $this.addClass("select2-initialized");
    });
}

window.select2Initialize = select2Initialize;


document.addEventListener("livewire:init", () => select2Initialize());
document.addEventListener("livewire:navigated", () => select2Initialize());

if (window.Livewire) {
    window.Livewire.hook("morphed", () => select2Initialize());
}
