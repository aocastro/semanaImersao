<?php

    //Realizar a conexão com o banco de dados
    include('../../conexao/conexao.php');

    //Prepara o objeto de retorno vazio
    $dados = array();

    if($conexao){

        $idUsuario = $_REQUEST['idUsuario'];

        $sql = "SELECT c.idcomentario, date_format(c.data_comentario,'%d/%m/%Y %H:%i:%s') as data_comentario, c.comentario, c.idnoticia, c.idusuario, u.nome as usuario
        FROM COMENTARIOS c
        INNER JOIN USUARIOS u ON u.idusuario = c.idusuario
        WHERE c.idusuario=$idUsuario
        ORDER BY c.idusuario";

        $resultado = mysqli_query($conexao, $sql);
        if($resultado){
            
            while($row = mysqli_fetch_assoc($resultado)){
                $dados[] = array_map('utf8_encode', $row);
            }
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);