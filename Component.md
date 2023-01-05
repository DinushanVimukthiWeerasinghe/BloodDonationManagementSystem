# Component Guide

## Dialog Box

JS to Open the Dialog Box. 

<mark>Make Sure to import framework css and js library.</mark>

```html
<!-- At the <head> Tag -->
<link rel="stylesheet" href="/public/css/framework/utils.css">
<!-- Below the <body> Tag -->
<script src="/public/js/components/dialog-box/dialog-box.js"></script>
```

### Props

- id - ID of dialog box

- title - Title of the dialog Box

- content - Content of the Dialog box

- successBtnText - Text of success Button

- CancelBtnText - Text of Cancel Button

- successBtnAction - function to perform when click success btn

- cancelBtnAction - function to perform when click cancel button

```js
OpenDialogBox({
    id: "dialog-box",
    title: "Dialog Box",
    content: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium, reprehenderit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium, reprehenderit.",
    successBtn: "Close",
    cancelBtn: "Cancel",
    successBtnAction: function() {
        console.log('OK button clicked right now')
        CloseDialogBox();
    },
    cancelBtnAction: function() {
        console.log('Cancel button clicked right now');
    }
})
```

#### Close Dialog

id is optional when multiple dialog-box have. (Not Tested)

```js
CloseDialogBox(id : Optional)
```
