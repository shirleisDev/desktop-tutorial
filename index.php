<?php
// Inicia a sessão para o sistema de login
session_start();

// Configuração simples de Usuário e Senha
$usuario_correto = "admin";
$senha_correta = "1234";
$erro_login = "";

// Processa o formulário de login quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $usuario_digitado = $_POST['usuario'];
    $senha_digitada = $_POST['senha'];

    if ($usuario_digitado === $usuario_correto && $senha_digitada === $senha_correta) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = $usuario_digitado;
    } else {
        $erro_login = "Acesso negado! Operador inválido.";
    }
}

// Processa o logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galactic Games | Loja Oficial</title>
    <style>
        /* --- ANIMAÇÕES ORIGINAIS MANTIDAS --- */
        @keyframes andarCarrossel {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @keyframes mudarESumir {
            0% { color: rgba(141, 6, 42, 0.519); opacity: 1; }
            100% { color: rgb(225, 57, 130); opacity: 0; visibility: hidden; }
        }
        @keyframes jornal-container {
            0% { color: white; text-shadow: none; }
            50% { color: rgb(255, 0, 247); text-shadow: 0 0 20px rgb(247, 0, 255); }
            100% { color: white; text-shadow: none; }
        }
        @keyframes sumir {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }
        @keyframes surgirESumir {
            0% { opacity: 0; color: black; transform: translateY(10px); }
            10% { opacity: 1; color: rgb(229, 255, 0); transform: translateY(0); }
            90% { opacity: 1; color: red; }
            100% { opacity: 0; visibility: hidden; }
        }

        /* --- CONFIGURAÇÃO GERAL DO CORPO --- */
        body {
            margin: 0;
            padding: 0;
            background-color: #030b18ce;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* --- PAINEL DE LOGIN GALÁCTICO COM NEON AZUL E VERMELHO --- */
        .container-login {
            background: rgba(5, 10, 25, 0.95);
            width: 90%;
            max-width: 450px;
            margin: 30px auto 10px auto;
            padding: 25px;
            border-radius: 16px;
            text-align: center;
            box-sizing: border-box;
            position: relative;
            z-index: 10; 
            border: 3px solid #ff0055;
            box-shadow: 0 0 25px #00d2ff, inset 0 0 15px #ff0055;
        }
        .container-login h2 {
            margin-top: 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #ff0055;
            text-shadow: 0 0 10px #ff0055, 0 0 20px #00d2ff;
        }
        .container-login p {
            color: #00d2ff;
            text-shadow: 0 0 8px #00d2ff;
            font-weight: bold;
            font-size: 16px;
        }
        .form-grupo {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-grupo label {
            display: block;
            color: #00d2ff;
            font-size: 14px;
            margin-bottom: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .form-grupo input {
            width: 100%;
            padding: 12px;
            background: #020612;
            border: 2px solid #00d2ff;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            box-sizing: border-box;
            outline: none;
            transition: all 0.3s ease;
        }
        .form-grupo input:focus {
            border-color: #ff0055;
            box-shadow: 0 0 15px #ff0055;
        }
        .btn-login {
            background: #ff0055;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 0 15px #ff0055;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: #00d2ff;
            box-shadow: 0 0 20px #00d2ff;
            color: #020612;
        }
        .btn-logout {
            color: #ff0055;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 15px;
            text-shadow: 0 0 5px #ff0055;
            transition: 0.2s;
        }
        .btn-logout:hover {
            color: #00d2ff;
            text-shadow: 0 0 5px #00d2ff;
        }
        .erro-msg {
            color: #ff3333;
            font-size: 15px;
            margin-bottom: 15px;
            font-weight: bold;
            text-shadow: 0 0 5px rgba(255,0,0,0.5);
        }

        /* --- ALERTA DO TOPO --- */
        .conteudo-alerta h1 {
            color: white;
            font-size: 74px;
            font-family: sans-serif;
            font-weight: bold;
            text-align: center;
            -webkit-text-stroke: 2px #050133d0; 
        }

        /* --- POSICIONAMENTO DO TÍTULO --- */
        #title {
            margin-top: 10px; 
            background: linear-gradient(135deg, #88a5d4a3 10%, #a1b6df93 22%,#106a976e 18%,#2871e6 12%,#24324870 5%, #162447 35%,#2871e6 22%,#162447 35%,#164897 22%);
            border-radius: 30px;
            text-align: center;
            width: 50%;
            margin-bottom: 20px; 
        }

        /* --- BANNER PRINCIPAL --- */
        .jornal-container {
            perspective: 100px;
            height: auto;
            position: relative;
            width: 98%;
            margin: 20px auto;
        }
        .jornal-container img {
            width: 70vw; 
            height: auto;
            max-height: 350px;
            object-fit: cover;
            border-radius: 32px;
            display: block;
            margin: 0 auto; 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .jornal-container img:hover {
            transform: scale(1.02) translateY(-5px);
            box-shadow: 0 8px 20px rgba(17, 135, 220, 0.799), 0 0 25px rgba(100, 50, 255, 0.3); 
        }

        /* --- CARROSSEL / SLIDER --- */
        .fundo {
            padding: 20px 0;
            width: 100%;
            background-color: #0095ff48;
            overflow: hidden; 
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }
        .slider {
            display: flex;
            gap: 20px;
            width: max-content; 
            animation: andarCarrossel 12s linear infinite;
        }
        .slider:hover {
            animation-play-state: paused; 
        }
        .slider img {
            height: 150px;
            width: auto;
            border-radius: 22px;
            cursor: pointer;
            transition: transform 0.2s ease, opacity 0.3s ease;
        }
        .slider img:hover {
            transform: scale(1.05); 
        }

        /* --- CORREÇÃO COMPLETA: CARDS CENTRALIZADOS EXIBINDO AS IMAGENS --- */
        .grid-cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; 
            gap: 20px;
            margin: 30px auto 50px auto;
            width: 90%;
            max-width: 1200px;
        }
        .card {
            background: #1a1d23;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            flex: 1 1 calc(25% - 20px); 
            min-width: 240px; 
            max-width: 280px; 
            box-sizing: border-box; 
        }
        .card h2 {
             font-size: 19px; 
             font-weight: bold;
             color: #00ff88; 
             margin-top: 0;
             margin-bottom: 15px;
             font-family: 'Lucida Sans Unicode', sans-serif;
        }
        .card:hover {
            transform: scale(1.05) translateY(-10px);
            box-shadow: 0 25px 40px rgba(17, 135, 220, 0.799), 0 0 25px rgba(100, 50, 255, 0.3); 
        }
        
        /* Força a imagem a renderizar com tamanho correto e visível */
        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            display: block;
        }

        .btn-venda { 
            display: inline-block;
            box-sizing: border-box;
            font-size: 18px;
            font-weight: bold;
            background-color: #243248;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            margin-top: 15px;
            cursor: pointer;
            width: 100%;
            text-align: center;
            transition: background-color 0.2s ease;
        }
        .btn-venda:hover {
            background-color: #2871e6;
        }

        /* --- LAYOUT INFERIOR --- */
        .layout-principal {
            display: flex;
            width: 90%;
            max-width: 1200px;
            gap: 30px;
            justify-content: center;
            margin-bottom: 50px;
        }
        .secao-propaganda, .secao-curiosidades {
            flex: 1;
        }
        .box-anuncio img {
            width: 100%;
            border-radius: 8px;
        }
        .card-curiosidade {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            background: #111419;
            padding: 15px;
            border-radius: 8px;
        }
        .card-curiosidade img {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <!-- Sistema de Login Neon -->
    <div class="container-login">
        <?php if (isset($_SESSION['logado']) && $_SESSION['logado'] === true): ?>
            <h2>Acesso Concedido</h2>
            <p>Bem-vindo, Piloto <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</p>
            <a href="?logout=1" class="btn-logout">Desconectar da Órbita</a>
        <?php else: ?>
            <h2>Acesso Galáctico</h2>
            <?php if (!empty($erro_login)): ?>
                <div class="erro-msg"><?php echo $erro_login; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-grupo">
                    <label for="usuario">Operador:</label>
                    <input type="text" id="usuario" name="usuario" required placeholder="Ex: admin">
                </div>
                <div class="form-grupo">
                    <label for="senha">Código Protetor:</label>
                    <input type="password" id="senha" name="senha" required placeholder="Ex: 1234">
                </div>
                <button type="submit" name="login" class="btn-login">Autenticar Sistema</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- Alerta de Topo -->
    <div id="alerta-gigante">
        <div class="conteudo-alerta">
            <h1>ZONA DE DIVERSÃO</h1>
        </div>
    </div>

    <!-- Título Principal -->
    <section id="title">  
        <h1>GAMES GALACTIC PLANET</h1>
    </section>
     
    <!-- Banner Principal -->
    <div class="jornal-container">
        <img src="https://forbes.com.br" alt="Banner Street Fighter">
    </div>
         
    <!-- Carrossel / Slider de Imagens -->
    <div class="fundo">
        <div class="slider">
            <img src="data:image/jpeg;base64,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" alt="Jogo em breve">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIm5Vt_EG6ipC_XMj550QL7EOVTffmHi8LqA&s" alt="Jogo em breve">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTD1M_0CoN7gHqzO4ItmHwHOdRkCW0lEDENqA&s" alt="Jogo em breve">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRY3L3J68hQtx-UrAYoOH_sG-Z16UqGBB8t8A&s" alt="Jogo em breve">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQePtow_GJiArS-GNRgZISsXP02gb2uZQ6Y9Q&s" alt="Jogo em breve">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQwZLUMAH_aHQ1zu_XFoGP6ryjx7RlG42HGcw&s" alt="Jogo em breve">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7TXrcrkXCbxKpn56JV68KTxsQmOgjkdAG6Q&s" alt="Jogo em breve">
        </div>
    </div>

    <!-- 4 Cards de Produtos com URLs e Imagens Corrigidas -->
    <section class="grid-cards">
        <!-- Card 1 -->
        <div class="card">
            <h2>THE LAST OF US</h2>
            <div class="card-img-wrapper">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkI_bmxsSIWgfFWpUX2gMM0ljilA1qtGSMhg&s" alt="Jogo The Last of Us">          
		    </div>
            <div class="card-info">
                <h3>MODO SURVIVAL</h3>
                <a href="contato.html" class="btn-venda">Oferta de Hoje</a>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card">
            <h2>LIKE A DRAGON: YAKUZA</h2>
            <div class="card-img-wrapper">
                <img src="data:image/jpeg;base64,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" alt="Jogo Like a Dragon Yakuza">            
			</div>
            <div class="card-info">
                <h3>SKY WARS PVP</h3>
                <a href="contato.html" class="btn-venda">Oferta de Hoje</a>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="card">
            <h2>SILENT HILL</h2>
            <div class="card-img-wrapper">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRX99IeEnARjql0GXO8J9nptnSJ92xHNWtRMA&s" alt="Jogo Silent Hill">
            </div>
            <div class="card-info">
                <h3>TERROR</h3>
                <a href="contato.html" class="btn-venda">Oferta de Hoje</a>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="card">
            <h2>VIP LENDÁRIO</h2>
            <div class="card-img-wrapper">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQovT0XRUvO3M9Ce6bIZtA707cofZDlRaqZvfCLkXfu&s" alt="Jogo Dragon City">
           </div>
            <div class="card-info">
                <h3>INFANTIL</h3>
                <a href="contato.html" class="btn-venda">Oferta de Hoje</a>
            </div>
        </div>
    </section>

    <!-- Layout Inferior -->
    <div class="layout-principal">
        <!-- Propaganda Lateral -->
        <aside class="secao-propaganda">
            <div class="box-anuncio">
                <a href="data:image/jpeg;base64,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" target="_blank" rel="noopener noreferrer">
                    <img src="data:image/jpeg;base64,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" alt="Propaganda Mercado Livre">
                </a>
            </div>
        </aside>

        <!-- As 4 Curiosidades Tecnológicas completas com Imagens -->
        <footer class="secao-curiosidades">
            <h6>Curiosidades da tecnologia</h6>         
            
            <!-- Curiosidade 1 -->
            <div class="card-curiosidade">
                <img src="data:image/jpeg;base64,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" alt="Maze War 1973">
                <p><strong>Maze War (1973):</strong> O pioneiro dos jogos em primeira pessoa via rede ARPANET.</p>
            </div>

            <!-- Curiosidade 2 -->
            <div class="card-curiosidade">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShTiRCitq1rF7KCIPEobf9Z1xJ3gbzGafOrg&s" alt="Spacewar!">
                <p><strong>GRAFIC :</strong> Um dos primeiros jogos digitais para computador criados na história do MIT.</p>
            </div>

            <!-- Curiosidade 3 -->
            <div class="card-curiosidade">
                <img src="https://cdn1.epicgames.com/spt-assets/f39371235a0f429d9d33b76a9bfa8916/rimworld-1hhrb.png?resize=1&w=480&h=270&quality=medium" alt="Magnavox Odyssey">
                <p><strong>Odyssey (1972):</strong> O primeiríssimo console de videogame doméstico lançado no mundo.</p>
            </div>

            <!-- Curiosidade 4 -->
            <div class="card-curiosidade">
                <img src="https://static.wikia.nocookie.net/legendarygame/images/f/f3/VIP_Rewards.png/revision/latest?cb=20171130074739" alt="Pac-Man">
                <p><strong>Vip-lendario :</strong> Criado para atrair o público feminino aos fliperamas focado em labirinto.</p>
            </div>
        </footer>
    </div>

    <!-- JavaScript Integrado Original -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Esconde a barra do topo após 3 segundos
            const alerta = document.getElementById('alerta-gigante');
            if (alerta) {
                setTimeout(function() {
                    alerta.style.display = 'none'; 
                }, 3000);
            }

            // 2. Controle de cliques no Slider com bloqueio e opacidade
            const imagensCarrossel = document.querySelectorAll('.slider img');
            imagensCarrossel.forEach(function(imagem) {
                imagem.addEventListener('click', function() {
                    alert('Desculpa, site em construção, em breve garantia de diversão!');
                    imagem.style.opacity = '0.5';
                    imagem.style.pointerEvents = 'none'; 
                });
            });
        });
    </script>
</body>
</html>
