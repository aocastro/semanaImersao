<?php

    include('../../conexao/conexao.php');

    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao bancoo de dados.',
        'dados' => array()
    );

    if($conexao){

        $idUsuario = $_REQUEST['idusuario'];

        $sql = "SELECT u.idusuario, u.nome, u.email, u.senha, u.idtipo_usuario, t.nome as tipo_usuario 
                FROM USUARIOS u
                INNER JOIN TIPOS_USUARIOS t ON t.idtipo_usuario = u.idtipo_usuario 
                WHERE idusuario=$idUsuario";
        
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
                'mensagem' => 'Não foi possível obter o usuário.',
                'dados' => array()
            );
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);