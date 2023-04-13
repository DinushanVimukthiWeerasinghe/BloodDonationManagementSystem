const showPassword = () => {
    const password = document.getElementById('password');
    const icon = document.getElementById('pass_icon');
    if (password.type === 'password') {
        password.type = 'text';
        icon.className = 'hide-password';
    } else {
        password.type = 'password';
        icon.className = 'show-password';
    }
}

const ForgotPassword=()=>{
    OpenDialogBox({
        id: 'forgot_password',
        title: 'Forgot Password',
        content: `
            <div class="d-flex column flex-center">
                <label for="email">Email</label>
                <input type="email" id="email" style="border-radius: 0;border: 1px solid black" placeholder="Enter your email" />
            </div>
        `,
        successBtnText: 'Forgot Password',
        cancelBtnText: 'Cancel',
        successBtnAction: () => {
            const email = document.getElementById('email').value;
            if (email === '') {
                ShowToast({
                    type: 'error',
                    message: 'Email is required'
                })
            }else{
                const formData = new FormData();
                formData.append('email', email);
                HideDialogBox('forgot_password');
                fetch('/forgot-password', {
                    method: 'POST',
                    body: formData
                }).then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            ShowToast({
                                type: 'success',
                                message: data.message
                            })
                            CloseDialogBox('forgot_password');
                        } else {
                            ShowToast({
                                type: 'error',
                                message: data.message
                            })
                            CloseDialogBox('forgot_password');
                        }
                    })
            }
        }
    })
}