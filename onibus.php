<?php
$ponto = isset($_GET['ponto']) ? $_GET['ponto'] : 'Desconhecido';

// Simulação dos ônibus para cada ponto (exemplo fictício)
$onibusPorPonto = [
    "Centro de Rio do Sul" => ["Ônibus 101 - Circular Centro", "Ônibus 102 - Centro Expresso"],
    "Terminal Rodoviário" => ["Ônibus 103 - Rodoviária Direto", "Ônibus 104 - Bairro Novo"],
    "Navegantes" => ["Ônibus 105 - Navegantes Circular", "Ônibus 106 - Navegantes Expresso"],
    "Santana" => ["Ônibus 107 - Santana Direto", "Ônibus 108 - Santana Circular"],
    "Barragem" => ["Ônibus 109 - Barragem Expresso", "Ônibus 110 - Barragem Circular"],
    "Canta Galo" => ["Ônibus 111 - Canta Galo Rápido", "Ônibus 112 - Canta Galo Circular"],
    "Jardim América" => ["Ônibus 113 - Jardim América Circular", "Ônibus 114 - Jardim América Expresso"]
];

// Verifica se há ônibus para o ponto selecionado
$onibusDisponiveis = isset($onibusPorPonto[$ponto]) ? $onibusPorPonto[$ponto] : [];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ônibus no Ponto <?php echo htmlspecialchars($ponto); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('img/onibus.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 600px;
            width: 100%;
            margin-top: 80px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            background-color: #444;
            color: #fff;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Ônibus no Ponto: <?php echo htmlspecialchars($ponto); ?></h2>

        <?php if (!empty($onibusDisponiveis)) : ?>
            <ul>
                <?php foreach ($onibusDisponiveis as $onibus) : ?>
                    <li><?php echo htmlspecialchars($onibus); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Não há ônibus disponíveis para este ponto no momento.</p>
        <?php endif; ?>
        
        <a href="local.php" class="btn btn-black mt-3">Voltar para a Lista de Pontos</a>
    </div>

</body>
</html>
