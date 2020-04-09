<?php

    include('../../conexao/conexao.php');

    $dados = array();

    if($conexao){

        $sql = "SELECT idtipo_usuario, nome FROM TIPOS_USUARIOS ORDER BY nome";
        $resultado = mysqli_query($conexao, $sql);
        if($resultado){
            
            while($row = mysqli_fetch_assoc($resultado)){
                $dados = array_map('utf8_encode', $row);
            }
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);