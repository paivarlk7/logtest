<?php
session_start();
error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
        $arquivotxt = $_FILES['arquivo']['tmp_name'];
        $palavrachave = isset($_POST['palavra']) ? $_POST['palavra'] : '';
        $abrirarquivo = fopen($arquivotxt, 'r');

        if ($abrirarquivo) {
            $lertxt = fread($abrirarquivo, filesize($arquivotxt));
            preg_match_all('/^(.*' . preg_quote($palavrachave, '/') . '.*)$/m', $lertxt, $matches);

            if (!empty($matches[0])) {
                $resultado = 'logs.txt';
                $destino = fopen($resultado, 'a');
                
         foreach ($matches[0] as $linha) {
        $linha = preg_replace('/^https?:\/\//', '', $linha);
       list($url, $user, $pass) = array_pad(explode(':', $linha), 3, null);
           $url = $url ?? 'NULL';
            $user = $user ?? 'NULL';
           $pass = $pass ?? 'NULL';
        $linhaF = "- Url: http://$url\n- User: $user\n- Pass: $pass\n- Channel: @HarpyOfc\n\n";
       fwrite($destino, $linhaF);
     }

                fclose($destino);
                fclose($abrirarquivo);

                // HTML com tema escuro
                echo '
                <html lang="pt-br">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>Resultado do Processamento</title>
                      <link rel="stylesheet" href="css/sucess/style.css">
                 </head>
                <body>
                    <div class="container">
                        <h1>✅ ➺ 𝘾𝙊𝙉𝙏𝙀𝙐𝘿𝙊 𝙎𝘼𝙇𝙑𝙊 𝘾𝙊𝙈 𝙎𝙐𝘾𝙀𝙎𝙎𝙊 𝙉𝙊 𝘼𝙍𝙌𝙐𝙄𝙑𝙊: 𝙇𝙊𝙂𝙎.𝙏𝙓𝙏<br> <br>
                                - 𝘿𝙀𝙑: @PERRYZIN <br> <br>
                                - 𝘾𝙃𝘼𝙉𝙉𝙀𝙇: @HARPYOFC
                        </h1>
                    </div>
                </body>
                </html>';
            } else {
                echo 'Nenhuma ocorrência encontrada no arquivo de origem.';
            }
        } else {
            echo 'Não foi possível abrir o arquivo de origem.';
        }
    } else {
        echo 'Erro no upload do arquivo.';
    }
} else {
    echo 'Requisição inválida.';
}
?>
