<?php

    include('../../conexao/conexao.php');

    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao banco de dados.'
    );

    if($conexao){

        $idTipoUsuario = $_REQUEST['idtipo_usuario'];

        $sql = "DELETE FROM TIPOS_USUARIOS WHERE idtipo_usuario=$idTipoUsuario";

        $resultado = mysqli_query($conexao, $sql);

        if($resultado){
            $dados = array(
                'tipo' => 'success',
                'mensagem' => 'Tipo de usuário deletado com sucesso.'
            );
        } else{
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível deletar o tipo de usuário.'
            );
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);