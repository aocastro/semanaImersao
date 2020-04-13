<?php

    include('../../conexao/conexao.php');

    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao bancoo de dados.',
        'dados' => array()
    );

    if($conexao){

        $idTipoUsuario = $_REQUEST['idtipo_usuario'];

        $sql = "SELECT idtipo_usuario, nome, tipo FROM TIPOS_USUARIOS 
                WHERE idtipo_usuario=$idTipoUsuario";
        
        $resultado = mysqli_query($conexao,$sql);

        if($resultado){

            $dadosTipo = array();
            while($row = mysqli_fetch_assoc($resultado)){
                $dadosTipo = array_map('utf8_encode', $row);
            }

            $dados = array(
                'tipo' => 'success',
                'mensagem' => '',
                'dados' => $dadosTipo
            );
        } else{
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível obter o tipo de usuário.',
                'dados' => array()
            );
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);