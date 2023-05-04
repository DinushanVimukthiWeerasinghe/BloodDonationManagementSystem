let id = 0;
const ShowToast = (props) => {

    const { message, type, timeout } = props;
    const AlreadyToast = document.querySelector(".toast");
    let newToastPosition = 0;
    if (AlreadyToast) {
    //     Get the Position of the toast
        const toastPosition = AlreadyToast.getBoundingClientRect();
        console.log(toastPosition.top)
        newToastPosition = toastPosition.top + 30;
    }
    const toast = document.createElement("div");
    toast.id = "toast-"+id;
    id++;
    const toastContainer = document.createElement("div");
    const RemoveIcon = document.createElement("div")
    RemoveIcon.innerHTML=" x "
    RemoveIcon.className = "toast-remove-icon";
    RemoveIcon.onclick = () => {
        CloseToast(toast.id);
    }
    toastContainer.innerHTML = message;
    toastContainer.appendChild(RemoveIcon);
    toast.appendChild(toastContainer)
    toast.className = `toast show ${type}`;
    toastContainer.className = `toast-container show ${type}`;
    const body= document.querySelector("body");
    toast.style.top = AlreadyToast ? newToastPosition + "px" : "40px";
    body.prepend(toast);
    let TimeOut = 3000;
    if (timeout){
        TimeOut = timeout;
    }
    setTimeout(() => {
        CloseToast(toast.id);
    }, TimeOut);
}

const CloseToast = (id = '') => {
    const MoreToast = document.querySelectorAll(".toast");
//     Move the other toast up
    if (MoreToast.length > 1) {
        MoreToast.forEach((toast) => {
            if (toast.id !== id) {
                const toastPosition = toast.getBoundingClientRect();
                const newToastPosition = (toastPosition.top - 56)+"px";
                toast.style.top = newToastPosition + "px";
            }
        });
    }
    const toast = document.getElementById(id);
    toast.remove();
}