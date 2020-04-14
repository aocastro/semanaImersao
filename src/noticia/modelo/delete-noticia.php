<?php

    include('../../conexao/conexao.php');

    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao banco de dados.'
    );

    if($conexao){

        $idNoticia = $_REQUEST['idnoticia'];

        $sql = "DELETE FROM NOTICIAS WHERE idnoticia=$idNoticia";

        $resultado = mysqli_query($conexao, $sql);

        if($resultado){
            $dados = array(
                'tipo' => 'success',
                'mensagem' => 'Notiícia deletada com sucesso.'
            );
        } else{
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível deletar a notícia.'
            );
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);