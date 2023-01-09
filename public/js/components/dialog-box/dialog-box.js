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

// OpenDialogBox({
//     id: "dialog-box",
//     title: "Dialog Box",
//     content: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium, reprehenderit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium, reprehenderit.",
//     successBtn: "Close",
//     cancelBtn: "Cancel",
//     successBtnAction: function() {
//         console.log('OK button clicked right now')
//         CloseDialogBox();
//     },
//     cancelBtnAction: function() {
//         console.log('Cancel button clicked right now');
//     }
// })

// export default RenderDialogBox;


// const dialogAction= document.querySelector('.dialog-action');
// const dialogBoxes= document.getElementsByClassName('dialog-box');
// const dialogClose= document.querySelector('.dialog-close');
// const dialogContent= document.querySelector('.dialog-content');
// const dialogTitle= document.querySelector('.dialog-title');
// const closeBtn= document.querySelector('.close-dialog');
// for (let i= 0; i < dialogBoxes.length; i++) {
//     const parent= dialogBoxes[i].parentNode;
//     const wrapper= document.createElement('div');
//     wrapper.classList.add('dialog-box-outer');
//     wrapper.id= dialogBoxes[i].id + '-outer';
//     parent.replaceChild(wrapper, dialogBoxes[i]);
//     wrapper.appendChild(dialogBoxes[i]);
//     wrapper.classList.add('hidden');
// }
//
// const dialogBoxOuter= document.querySelector('.dialog-box-outer');
// const OpenDialog= (id='')=>{
//     if (id.trim() !== ''){
//         const dialog= document.getElementById(id);
//         if (dialog){
//             dialog.parentElement.classList.remove('hidden');
//             dialog.parentElement.classList.add('flex');
//         }
//     }
//     dialogBoxOuter.classList.remove('hidden');
//     dialogBoxOuter.classList.add('flex');
// }
// const closeDialog= () => {
//     dialogBoxOuter.classList.add('hidden');
//     dialogBoxOuter.classList.remove('flex');
// }
//
//
// const dialogActionBtn=dialogAction.children;
// for (let i = 0; i < dialogActionBtn.length; i++) {
//     if (!dialogActionBtn[i].hasAttribute('onclick') && dialogActionBtn[i].hasAttribute('data-close')) {
//             dialogActionBtn[i].addEventListener('click', closeDialog);
//     }
// }
