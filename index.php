<?php
session_start();

// --- CONFIGURAÇÃO DE ACESSO ---
$usuario_correto = "shirlei";
$senha_correta = "123456"; 

if (!isset($_SESSION['cashback'])) {
    $_SESSION['cashback'] = 0.00;
}

$mensagem = "";

// --- PROCESSAMENTO DO LOGIN ---
if (isset($_POST['logar'])) {
    $usuario = strtolower(htmlspecialchars(trim($_POST['usuario']), ENT_QUOTES, 'UTF-8')); 
    $senha = trim($_POST['senha']);

    if ($usuario === $usuario_correto && $senha === $senha_correta) {
        $_SESSION['logado'] = true;
    } else {
        $mensagem = "Usuário ou senha inválidos.";
    }
}

// --- PROCESSAMENTO DA COMPRA ---
if (isset($_POST['comprar']) && isset($_SESSION['logado'])) {
    $valor_gasto = (float)$_POST['valor_item']; 
    $retorno = $valor_gasto * 0.10; 
    
    $_SESSION['cashback'] += $retorno;
    $mensagem = "Sucesso! Você ganhou R$ " . number_format($retorno, 2, ',', '.') . " de cashback.";
}

// --- PROCESSAMENTO DO LOGOUT (SAIR) ---
if (isset($_POST['sair'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Galactic Games | Loja Oficial</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #0b0e14; color: #e2e8f0; margin: 0; padding-bottom: 60px;">

    <!-- TOPO DO SITE -->
    <div id="alerta-gigante" style="background-color: #1e293b; padding: 10px; text-align: center; border-bottom: 3px solid #3b82f6;">
        <div class="conteudo-alerta">
            <h1 style="margin: 0; font-size: 20px; color: #3b82f6;">ZONA DE DIVERSÃO</h1>
        </div>
    </div>

    <section id="title" style="text-align: center; padding: 20px 0;">  
        <h1 style="color: #6366f1; margin: 0;">GAMES GALACTIC PLANET</h1>
    </section>

    <div class="jornal-container" style="text-align: center; margin-bottom: 30px;">
        <img src="https://www.oficinadanet.com.br/media/post/47055/1200/todos-os-jogos-que-viraram-filmes-1.jpg" alt="Banner" style="max-width: 100%; height: auto; border-radius: 8px;">
    </div>

    <!-- SEÇÃO DO SISTEMA DE CASHBACK DINÂMICO -->
    <div style="max-width: 500px; margin: 0 auto 40px auto; background: #1e293b; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); border: 1px solid #334155; color: #ffffff;">
        
        <?php if (!empty($mensagem)): ?>
            <div style="background-color: #fef08a; color: #854d0e; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-weight: bold; text-align: center;">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <?php if (!isset($_SESSION['logado'])): ?>
            <!-- FORMULÁRIO DE LOGIN INTEGRADO -->
            <h2 style="color: #3b82f6; margin-top: 0; text-align: center;">Área do Cliente: Cashback</h2>
            <form method="POST">
                <label style="font-weight: bold; color: #94a3b8;">Usuário:</label><br>
                <input type="text" name="usuario" required style="padding: 10px; width: 100%; margin: 5px 0 15px 0; border: 1px solid #475569; background-color: #0f172a; color: white; border-radius: 4px; box-sizing: border-box;"><br>
                
                <label style="font-weight: bold; color: #94a3b8;">Senha:</label><br>
                <input type="password" name="senha" required style="padding: 10px; width: 100%; margin: 5px 0 20px 0; border: 1px solid #475569; background-color: #0f172a; color: white; border-radius: 4px; box-sizing: border-box;"><br>
                
                <button type="submit" name="logar" style="padding: 12px; background-color: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; width: 100%;">Entrar na Conta</button>
            </form>
        <?php else: ?>
            <!-- PAINEL DO JOGADOR INTEGRADO -->
            <h2 style="color: #22c55e; margin-top: 0; text-align: center;">Painel do Jogador</h2>
            <p style="text-align: center; color: #94a3b8;">Bem-vindo de volta, <strong>shirlei</strong>!</p>
            
            <div style="background: #0f172a; padding: 15px; border-left: 5px solid #06b6d4; border-radius: 4px; margin-bottom: 25px; text-align: center;">
                Seu Saldo Acumulado: <br>
                <strong style="font-size: 24px; color: #22c55e;">R$ <?php echo number_format($_SESSION['cashback'], 2, ',', '.'); ?></strong>
            </div>
            
            <h3 style="color: #e2e8f0; border-bottom: 1px solid #334155; padding-bottom: 8px;">Resgatar Recompensa do Jogo:</h3>
            <form method="POST">
                <label style="font-weight: bold; color: #94a3b8;">Escolha o pacote comprado:</label><br>
                <select name="valor_item" style="padding: 10px; width: 100%; margin: 8px 0 20px 0; border: 1px solid #475569; background-color: #0f172a; color: white; border-radius: 4px; box-sizing: border-box;">
                    <option value="50.00">Pacote Bronze - R$ 50,00 (Ganha R$ 5,00)</option>
                    <option value="100.00">Pacote Prata - R$ 100,00 (Ganha R$ 10,00)</option>
                    <option value="200.00">Pacote Ouro - R$ 200,00 (Ganha R$ 20,00)</option>
                </select><br>
                
                <button type="submit" name="comprar" style="padding: 12px; background-color: #22c55e; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; width: 100%;">Confirmar e Gerar Cashback</button>
            </form>

            <hr style="border: 0; border-top: 1px solid #334155; margin: 25px 0;">
            <form method="POST">
                <button type="submit" name="sair" style="padding: 8px; background-color: #ef4444; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; width: 100%;">Sair do Painel</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- CARROSEL E CARDS ORIGINAIS DA SUA LOJA -->
    <div class="fundo" style="text-align: center; margin-bottom: 40px;">
        <div class="slider">
            <img onclick="alert('Desculpa, site em construção')" style="cursor: pointer; max-width: 150px; margin: 5px;" src="https://m.media-amazon.com/images/I/81S7FUrjOHL._SL500_.jpg" alt="Jogo 1">
            <img onclick="alert('Desculpa, site em construção')" style="cursor: pointer; max-width: 150px; margin: 5px;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJjt6Sh8LpYzP_fkxCYKtxUJ-fVRBtMUd-fiXYmyRh&s" alt="Jogo 2">
            <img onclick="alert('Desculpa, site em construção')" style="cursor: pointer; max-width: 150px; margin: 5px;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT24YtsnauBTlOcmy1C8hXuUiGEGXXX847-RA&s" alt="Jogo 3">
        </div>
    </div>

    <section class="grid-cards" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; padding: 20px;">
        <div class="card" style="background: #1e293b; padding: 15px; border-radius: 8px; width: 220px; text-align: center;">
            <h2>THE LAST OF US</h2>
            <img src="https://cinepop.com.br/wp-content/uploads/2023/01/thelast-1-696x392.jpg" alt="Jogo 1" style="max-width: 100%; border-radius: 4px;">
            <h3>MODO SURVIVAL</h3>
            <button class="btn-venda" style="width: 100%; padding: 10px; background: #6366f1; border: none; border-radius: 4px;"><a href="#alerta-gigante" style="color: white; text-decoration: none; font-weight: bold;">Oferta de Hoje</a></button>
        </div>

        <div class="card" style="background: #1e293b; padding: 15px; border-radius: 8px; width: 220px; text-align: center;">
            <h2>DRAGON YAKUZA</h2>
            <img src="https://s.zst.com.br/cms-assets/2024/08/yakuza-like-a-dragon-02-zoom.webp" alt="Jogo 2" style="max-width: 100%; border-radius: 4px;">
            <h3>SKY WARS PVP</h3>
            <button class="btn-venda" style="width: 100%; padding: 10px; background: #6366f1; border: none; border-radius: 4px;"><a href="#alerta-gigante" style="color: white; text-decoration: none; font-weight: bold;">Oferta de Hoje</a></button>
        </div>
    </section>

    <div class="layout-principal" style="max-width: 1000px; margin: 40px auto; display: flex; justify-content: space-between; padding: 0 20px;">
        <aside class="secao-propaganda">
            <div class="box-anuncio">
                <a href="https://meli.la/2RUDbND">
                    <img src="https://http2.mlstatic.com/D_NQ_NP_2X_690159-MLA99542831560_122025-F.webp" alt="Propaganda Mercado Livre" style="max-width: 200px;">
                </a>
            </div>
        </aside>

        <footer class="secao-curiosidades" style="max-width: 500px;">
            <h6>Curiosidades da tecnologia</h6>         
            <div class="card-curiosidade" style="display: flex; align-items: center; margin-bottom: 15px; background: #1e293b; padding: 10px; border-radius: 4px;">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTqBKWOGQSyzZL3UB4ubWxDqMGn7zKU_J9cVA&s" alt="Maze War" style="max-width: 80px; margin-right: 15px;">
                <p style="margin: 0;"><strong>Maze War (1973)</strong> O pioneiro dos jogos em primeira pessoa via rede ARPANET.</p>
            </div>
        </footer>
    </div>

</body>
</html>
