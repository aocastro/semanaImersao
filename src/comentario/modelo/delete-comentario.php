<?php

    include('../../conexao/conexao.php');

    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao banco de dados.'
    );

    if($conexao){

        $idComentario = $_REQUEST['idComentario'];

        $sql = "DELETE FROM COMENTARIOS WHERE idcomentario=$idComentario";

        $resultado = mysqli_query($conexao, $sql);

        if($resultado){
            $dados = array(
                'tipo' => 'success',
                'mensagem' => 'Comentário deletado com sucesso.'
            );
        } else{
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível deletar o comentário.'
            );
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);