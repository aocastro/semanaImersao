<?php

    include('../../conexao/conexao.php');

    $dados = array();

    if($conexao){

        $sql = "SELECT idnoticia, data_noticia, titulo, corpo, imagem, idcategoria
        FROM NOTICIAS ORDER BY data_noticia desc LIMIT 6";
        
        $resultado = mysqli_query($conexao, $sql);
        if($resultado){
            
            while($row = mysqli_fetch_assoc($resultado)){
                $dados[] = array_map('utf8_encode', $row);
            }
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);