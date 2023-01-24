const OpenDialogBox= (props) => {
    const {id, title, content, closeDialog,successBtnText,cancelBtnText, closeDialogBtn,successBtnAction,cancelBtnAction}= props;
    const dialogBoxOuter= document.createElement('div');
    dialogBoxOuter.id= id;
    dialogBoxOuter.className= 'dialog-box-outer';
    const dialogBoxInner= document.createElement('div');
    dialogBoxInner.className= 'dialog-box';
    const dialogBoxTitle= document.createElement('div');
    dialogBoxTitle.className= 'dialog-box-title';
    if (title) {
        dialogBoxTitle.innerHTML= title;
    }else{
        dialogBoxTitle.innerHTML= 'Dialog Box';
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
    OKBtn.className= 'btn btn-success';
    OKBtn.innerHTML= successBtnText || 'OK';

    if (successBtnAction) {
        OKBtn.addEventListener('click', successBtnAction);
    }else{
        OKBtn.addEventListener('click', closeDialog || function() {
            dialogBoxOuter.remove();
        });
    }

    const cancelBtnElement= document.createElement('button');
    cancelBtnElement.className= 'btn btn-danger';
    cancelBtnElement.innerHTML= cancelBtnText || 'Cancel';
    if (cancelBtnAction) {
        cancelBtnElement.addEventListener('click', cancelBtnAction);
    }else{
        cancelBtnElement.addEventListener('click', closeDialog || function() {
            dialogBoxOuter.remove();
        });
    }
    dialogBoxActionBtn.appendChild(OKBtn);
    dialogBoxActionBtn.appendChild(cancelBtnElement);
    dialogBoxInner.appendChild(dialogBoxTitle);
    dialogBoxInner.appendChild(dialogBoxContent);
    if (dialogBoxCloseBtn) {
        dialogBoxInner.appendChild(dialogBoxCloseBtn);
    }
    dialogBoxInner.appendChild(dialogBoxActionBtn);
    dialogBoxOuter.appendChild(dialogBoxInner);
    const body= document.querySelector("body");
    body.prepend(dialogBoxOuter);
};
const CloseDialogBox= (id='') => {
    if (id.trim() !== '') {
        const dialogBox= document.getElementById(id);
        dialogBox.remove();
    }else{
        const dialogBox= document.querySelector('.dialog-box-outer');
        dialogBox.remove();
    }
}