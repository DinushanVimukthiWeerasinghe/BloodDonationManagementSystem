const OpenDialogBox= (props) => {
    const {
        id,
        title,
        content,
        closeDialog,
        successBtnText,
        cancelBtnText,
        closeDialogBtn,
        successBtnAction,
        secondaryBtnText,
        secondaryBtnAction,
        cancelBtnAction,
        popupOrder,
        showCancelButton,
        footer,
        contentSize
    } = props;
    const dialogBoxOuter = document.createElement('div');
    dialogBoxOuter.id = id;
    if (popupOrder) {
        dialogBoxOuter.style.zIndex = 1000 + popupOrder;
    } else {
        dialogBoxOuter.style.zIndex = '1000';
    }
    dialogBoxOuter.className = 'dialog-box-outer';
    const dialogBoxInner = document.createElement('div');
    dialogBoxInner.className = 'dialog-box';
    if (contentSize){
        dialogBoxInner.style.minWidth=contentSize+'%';
    }
    const dialogBoxTitle = document.createElement('div');
    dialogBoxTitle.className = 'dialog-box-title';
    if (title) {
        dialogBoxTitle.innerHTML = title;
    } else {
        dialogBoxTitle.innerHTML = 'Dialog Box';
    }
    const dialogBoxContent= document.createElement('div');
    dialogBoxContent.className= 'dialog-box-content';
    if (content) {
        dialogBoxContent.innerHTML= content;
    }else {
        dialogBoxContent.innerHTML= 'Dialog Box Content';
    }
    let dialogBoxCloseBtn;
    if (closeDialogBtn) {
        dialogBoxCloseBtn= document.createElement('div');
        dialogBoxCloseBtn.className= 'dialog-box-close-btn';
        dialogBoxCloseBtn.innerHTML= closeDialogBtn;
        dialogBoxCloseBtn.addEventListener('click', closeDialog);
    }
    const dialogBoxActionBtn= document.createElement('div');
    dialogBoxActionBtn.className= 'dialog-box-action';
    const OKBtn= document.createElement('button');
    OKBtn.className= 'btn btn-outline-success';
    OKBtn.innerHTML= successBtnText || 'OK';

    if (successBtnAction) {
        OKBtn.addEventListener('click', successBtnAction);
    }else{
        OKBtn.addEventListener('click', closeDialog || function() {
            dialogBoxOuter.remove();
        });
    }
    dialogBoxActionBtn.appendChild(OKBtn);
    if (secondaryBtnText) {
        const secondaryBtnElement= document.createElement('button');
        secondaryBtnElement.className= 'btn btn-outline-secondary';
        secondaryBtnElement.innerHTML= secondaryBtnText;
        if (secondaryBtnAction) {
            secondaryBtnElement.addEventListener('click', secondaryBtnAction);
        }else{
            secondaryBtnElement.addEventListener('click', closeDialog || function() {
                dialogBoxOuter.remove();
            });
        }
        dialogBoxActionBtn.appendChild(secondaryBtnElement);
    }


    if (showCancelButton === false) {
        // OKBtn.style.width= '50%';
    }else{
        const cancelBtnElement= document.createElement('button');
        cancelBtnElement.className= 'btn btn-outline-danger';
        cancelBtnElement.innerHTML= cancelBtnText || 'Cancel';
        if (cancelBtnAction) {
            cancelBtnElement.addEventListener('click', cancelBtnAction);
        }else{
            cancelBtnElement.addEventListener('click', closeDialog || function() {
                dialogBoxOuter.remove();
            });
        }
        dialogBoxActionBtn.appendChild(cancelBtnElement);
    }




    dialogBoxInner.appendChild(dialogBoxTitle);
    dialogBoxInner.appendChild(dialogBoxContent);
    if (dialogBoxCloseBtn) {
        dialogBoxInner.appendChild(dialogBoxCloseBtn);
    }
    if (footer) {
        const footerElement= document.createElement('div');
        footerElement.className= 'dialog-box-footer';
        footerElement.innerHTML= footer;
        dialogBoxInner.appendChild(footerElement);
    }
    dialogBoxInner.appendChild(dialogBoxActionBtn);
    dialogBoxOuter.appendChild(dialogBoxInner);
    const body= document.querySelector("body");
    body.prepend(dialogBoxOuter);
};
const CloseDialogBox = (id = '') => {
    if (id.trim() !== '') {
        const dialogBox = document.getElementById(id);
        dialogBox.remove();
    } else {
        const dialogBox = document.querySelector('.dialog-box-outer');
        dialogBox.remove();
    }
}

const HideDialogBox = (id = '') => {
    if (id.trim() !== '') {
        const dialogBox = document.getElementById(id);
        dialogBox.style.display = 'none';
    } else {
        const dialogBox = document.querySelector('.dialog-box-outer');
        dialogBox.style.display = 'none';
    }
}

const ShowDialogBox = (id = '') => {
    if (id.trim() !== '') {
        const dialogBox = document.getElementById(id);
        dialogBox.style.display = 'block';
    } else {
        const dialogBox = document.querySelector('.dialog-box-outer');
        dialogBox.style.display = 'block';
    }
}

