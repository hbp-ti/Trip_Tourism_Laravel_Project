// Trata a cor de fundo do método de pagamento escolhido
const methods = document.querySelectorAll('.method');

methods.forEach(method => {
    method.addEventListener('click', () => {
        methods.forEach(m => m.classList.remove('active'));
        
        method.classList.add('active');
    });
});