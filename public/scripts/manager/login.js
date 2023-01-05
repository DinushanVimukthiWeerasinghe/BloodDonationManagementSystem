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