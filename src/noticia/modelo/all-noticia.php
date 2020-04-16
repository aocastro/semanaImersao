<?php

    include('../../conexao/conexao.php');

    $dados = array();

    if($conexao){

        $sql = "SELECT idnoticia, date_format(data_noticia,'%d/%m/%Y %H:%i:%s') as data_noticia, 
        titulo, corpo
        FROM NOTICIAS ORDER BY data_noticia desc ";
        
        $resultado = mysqli_query($conexao, $sql);
        if($resultado){
            
            while($row = mysqli_fetch_assoc($resultado)){
                $dados[] = array_map('utf8_encode', $row);
            }
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);