
const imagem = document.querySelector('#minhaImagem');


imagem.addEventListener('click', function() {

    alert('Desculpa, site em construção, em breve garantia de diverssão');
    

    this.style.opacity = '0.5';
    
    this.style.pointerEvents = 'none'; 
});

  // Espera 3 segundos (3000 milisegundos) e remove o alerta
  setTimeout(function() {
    const alerta = document.getElementById('alerta-gigante');
    alerta.style.display = 'none';
  }, 3000);

