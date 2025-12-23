function datepickerInitialize() {
    document.querySelectorAll(".datepicker").forEach((el) => {
        if (el.classList.contains("datepicker-initialized")) return;

        const dateFormat = el.dataset.format || "Y-m-d";
        const safariDateAfter = parseInt(el.dataset.start || 0);
        const NoDateAfter = parseInt(el.dataset.nostart || 0);
        const restrictFuture = el.dataset.restrictFuture === "true";

        let maxDate = null;
        let minDate = null;

        if (NoDateAfter == 0) {
            minDate = new Date(new Date().toDateString());
            if (safariDateAfter > 0) {
                minDate.setDate(minDate.getDate() + safariDateAfter);
            }
        } else if (restrictFuture) {
            maxDate = new Date();
            minDate = null;
        }

        const instance = flatpickr(el, {
            dateFormat,
            allowInput: true,
            defaultDate: el.value || null,
            minDate,
            maxDate,
            disableMobile: true,

            onReady(selectedDates, dateStr) {
                if (el.value) {
                    this.setDate(el.value, true);
                }

                setTimeout(() => {
                    applyRangeLogic(el, el.value);
                }, 20);
            },

            onChange(selectedDates, dateStr) {
                applyRangeLogic(el, dateStr);
            },
        });

        el._flatpickr = instance;
        el.classList.add("datepicker-initialized");
    });
}

function applyRangeLogic(el, dateStr) {
    const role = el.dataset.role;
    const group = el.dataset.group;

    if (!role || !group) return;

    const startEl = document.querySelector(
        `.datepicker[data-role="start"][data-group="${group}"]`
    );
    const endEl = document.querySelector(
        `.datepicker[data-role="end"][data-group="${group}"]`
    );

    if (!startEl || !endEl) return;

    const startPicker = startEl._flatpickr;
    const endPicker = endEl._flatpickr;

    if (!startPicker || !endPicker) return;

    if (startEl.value) {
        endPicker.set("minDate", startEl.value);

        if (endEl.value && new Date(endEl.value) < new Date(startEl.value)) {
            endPicker.clear();
        }
    }

    if (role === "start" && dateStr) {
        endPicker.set("minDate", dateStr);
    }
}

window.datepickerInitialize = datepickerInitialize;

document.addEventListener("livewire:init", () => {
    setTimeout(() => datepickerInitialize(), 30);
});

document.addEventListener("livewire:navigated", () => {
    setTimeout(() => datepickerInitialize(), 30);
});

Livewire.hook("morphed", () => {
    setTimeout(() => datepickerInitialize(), 30);
});
