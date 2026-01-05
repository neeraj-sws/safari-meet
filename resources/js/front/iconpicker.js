export function initIconPicker() {

    document.querySelectorAll('.iconPicker').forEach(picker => {
        const $picker = $(picker);
        $picker.iconpicker('destroy');

        $picker.iconpicker().on('iconpickerSelected', function (e) {
            const selectedIcon = e.iconpickerValue;
            const wrapper = picker.closest('.icon-picker-wrapper');
            const iconPreview = wrapper.querySelector('#iconPreview');
            const fieldName = picker.getAttribute('data-field');
            const pageId = picker.getAttribute('data-pageId');

            if (iconPreview && fieldName) {
                iconPreview.innerHTML = `<i class="${selectedIcon}"></i>`;
                const componentElement = document.getElementById(pageId);
                const componentId = componentElement?.getAttribute('wire:id');

                if (componentId) {
                    Livewire.find(componentId).dispatch('icon-selected', {
                        data: {
                            field: fieldName,
                            value: `<i class="${selectedIcon}" aria-hidden="true"></i>`
                        }
                    });
                }
            }
        });

        const iconValue = picker.closest('.icon-picker-wrapper')?.querySelector('#iconInput')?.value;
        if (iconValue) {
            $picker.iconpicker('setIcon', iconValue);
        }
    });

    window.addEventListener('iconPicker:reset', () => {
        document.querySelectorAll('.iconPicker').forEach(picker => {
            const $picker = $(picker);
            $picker.iconpicker('setIcon', '');
            picker.value = '';
            const wrapper = picker.closest('.icon-picker-wrapper');
            const iconPreview = wrapper.querySelector('#iconPreview');
            if (iconPreview) iconPreview.innerHTML = '';
        });
    });

    window.addEventListener('iconPicker:update', (e) => {
        let newIcon = e.detail.value;
        const match = newIcon.match(/class="([^"]+)"/);
        if (match) newIcon = match[1];

        document.querySelectorAll('.iconPicker').forEach(picker => {
            const $picker = $(picker);
            $picker.iconpicker('setIcon', newIcon);
            picker.value = newIcon;

            const wrapper = picker.closest('.icon-picker-wrapper');
            const iconPreview = wrapper.querySelector('#iconPreview');
            if (iconPreview) iconPreview.innerHTML = `<i class="${newIcon}"></i>`;
        });
    });
}
