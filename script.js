// Espera todo o HTML da página carregar antes de rodar o JS
document.addEventListener('DOMContentLoaded', function() {

    // 1. ANIMAÇÃO DE SUMIR O ALERTA DO TOPO
    // Seleciona a barra azul do topo e a remove após 3 segundos
    const alerta = document.getElementById('alerta-gigante');
    if (alerta) {
        setTimeout(function() {
            alerta.style.display = '';
        }, 3000);
    }

    // 2. CONTROLE DO CARROSSEL DE IMAGENS
    // Seleciona todas as imagens que estão dentro do seu slider de jogos
    const imagensCarrossel = document.querySelectorAll('.slider img');

    imagensCarrossel.forEach(function(imagem) {
        imagem.addEventListener('click', function() {
            // Exibe a mensagem de aviso na tela
            alert('Desculpa, site em construção, em breve garantia de diversão!');
            
            // Aplica o efeito visual de desativado (metade da opacidade)
            this.style.opacity = '0.5';
            
            // Bloqueia novos cliques na imagem para o usuário não clicar de novo
            this.style.pointerEvents = 'none'; 
        });
    });

});
