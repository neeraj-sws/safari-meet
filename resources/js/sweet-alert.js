import Swal from "sweetalert2";

window.Swal = Swal;

// ---------------------
// Toast
// ---------------------
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

// ---------------------
// Livewire Confirm Event
// ---------------------
window.addEventListener("swal:confirm", (event) => {
    const payload = Array.isArray(event.detail)
        ? event.detail[0]
        : event.detail || {};

    Swal.fire({
        title: payload.title || "",
        text: payload.text || "",
        icon: payload.icon || "warning",
        showCancelButton: payload.showCancelButton ?? true,
        confirmButtonText: payload.confirmButtonText || "Yes",
    }).then((result) => {
        if (result.isConfirmed && payload.action) {
            Livewire.dispatch(payload.action);
        }
    });
});

// ---------------------
// Toast Event Listener
// ---------------------
window.addEventListener("swal:toast", (event) => {
    const payload = Array.isArray(event.detail)
        ? event.detail[0]
        : event.detail || {};

    Toast.fire({
        title: payload.title || "",
        text: payload.message || payload.text || "",
        icon: payload.type || payload.icon || "info",
    });
});

// ---------------------
// Bootstrap Modal Events
// ---------------------
window.addEventListener("bs:openmodal", (event) => {
    $("#" + event.detail.modal).modal("show");
});

window.addEventListener("bs:hidemodal", (event) => {
    $("#" + event.detail.modal).modal("hide");
});
