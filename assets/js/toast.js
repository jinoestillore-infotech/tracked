function showToast(message, type = "success") {
    const container = document.getElementById("toast-container");
    const toast = document.createElement("div");
    toast.classList.add("custom-toast");
    if (type === "success") {
        toast.classList.add("toast-success");
    } else {
        toast.classList.add("toast-error");
    }
    toast.innerText = message;
    container.appendChild(toast);
    setTimeout(() => {
        toast.classList.add("show");
    }, 100);
    setTimeout(() => {
        toast.classList.remove("show");
        setTimeout(() => {
            toast.remove();
        }, 400);
    }, 3000);
}