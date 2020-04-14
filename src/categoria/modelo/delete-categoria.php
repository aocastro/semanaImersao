<?php

    include('../../conexao/conexao.php');

    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao banco de dados.'
    );

    if($conexao){

        $idCategoria = $_REQUEST['idcategoria'];

        $sql = "DELETE FROM CATEGORIAS WHERE idcategoria=$idCategoria";

        $resultado = mysqli_query($conexao, $sql);

        if($resultado){
            $dados = array(
                'tipo' => 'success',
                'mensagem' => 'Categoria deletada com sucesso.'
            );
        } else{
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível deletar a categoria.'
            );
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);