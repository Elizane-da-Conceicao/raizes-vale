// Função para alternar a visibilidade da senha
function togglePassword() {
    const senhaInput = document.getElementById('senha');
    const showPasswordBtn = document.querySelector('.show-password');

    if (senhaInput.type === 'password') {
        senhaInput.type = 'text';
        showPasswordBtn.textContent = '👁️';
    } else {
        senhaInput.type = 'password';
        showPasswordBtn.textContent = '🔒';
    }
}


