

function initializeIconPicker() {
    const $ = window.$;

    if (typeof $ === 'undefined') {
        console.error('jQuery is not defined for icon picker');
        return;
    }

    document.querySelectorAll(".iconPicker").forEach((picker) => {
        const $picker = $(picker);

        $picker.iconpicker("destroy");

        $picker.iconpicker().on("iconpickerSelected", function (e) {
            const selectedIcon = e.iconpickerValue;
            const wrapper = picker.closest(".icon-picker-wrapper");
            const iconPreview = wrapper.querySelector("#iconPreview");
            const fieldName = picker.getAttribute("data-field");
            const pageId = picker.getAttribute("data-pageId");
            if (iconPreview && fieldName) {
                iconPreview.innerHTML = `<i class="${selectedIcon}"></i>`;
                const componentElement = document.getElementById(pageId);
                const componentId = componentElement?.getAttribute("wire:id");
                // console.log(componentId);
                if (componentId) {
                    // Livewire.find(componentId).set(fieldName,
                    //     `<i class="${selectedIcon}" aria-hidden="true"></i>`);
                    Livewire.find(componentId).dispatch("icon-selected", {
                        data: {
                            field: fieldName,
                            value: `<i class="${selectedIcon}" aria-hidden="true"></i>`,
                        },
                    });
                }
            }
        });

        const iconValue = picker
            .closest(".icon-picker-wrapper")
            ?.querySelector("#iconInput")?.value;
        if (iconValue) {
            $picker.iconpicker("setIcon", iconValue);
        }
    });
}

// Wait for jQuery to be available
setTimeout(() => {
    window.addEventListener("initializeIconPicker", () => {
        setTimeout(() => initializeIconPicker(), 100);
    });

    window.addEventListener("iconPicker:reset", () => {
        const $ = window.$;
        document.querySelectorAll(".iconPicker").forEach((picker) => {
            const $picker = $(picker);
            $picker.iconpicker("setIcon", "");
            picker.value = "";
            const wrapper = picker.closest(".icon-picker-wrapper");
            const iconPreview = wrapper.querySelector("#iconPreview");
            if (iconPreview) {
                iconPreview.innerHTML = "";
            }
        });
    });

    window.addEventListener("iconPicker:update", (e) => {
        const $ = window.$;
        let newIcon = e.detail.value;
        const match = newIcon.match(/class="([^"]+)"/);
        if (match) {
            newIcon = match[1];
        }

        document.querySelectorAll(".iconPicker").forEach((picker) => {
            const $picker = $(picker);
            const pageId = picker.getAttribute("data-pageId");
            $picker.iconpicker("setIcon", newIcon);
            picker.value = newIcon;

            const wrapper = picker.closest(".icon-picker-wrapper");
            const iconPreview = wrapper.querySelector("#iconPreview");
            if (iconPreview) {
                iconPreview.innerHTML = `<i class="${newIcon}"></i>`;
            }
        });
    });
}, 100);
