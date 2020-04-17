<?php

    include('../../conexao/conexao.php');

    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao bancoo de dados.',
        'dados' => array()
    );

    if($conexao){

        $idComentario = $_REQUEST['idcomentario'];

        $sql = "SELECT c.idcomentario, date_format(c.data_comentario,'%d/%m/%Y %H:%i:%s') as data_comentario, c.comentario, c.idnoticia, c.idusuario, u.nome as usuario
        FROM COMENTARIOS c
        INNER JOIN USUARIOS u ON u.idusuario = c.idusuario
        WHERE idcomentario=$idComentario";
        
        $resultado = mysqli_query($conexao,$sql);

        if($resultado){

            $dadosComentario = array();
            while($row = mysqli_fetch_assoc($resultado)){
                $dadosComentario = array_map('utf8_encode', $row);
            }

            $dados = array(
                'tipo' => 'success',
                'mensagem' => '',
                'dados' => $dadosComentario
            );
        } else{
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível obter o comentário.',
                'dados' => array()
            );
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);