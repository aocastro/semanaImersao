<?php

    include('../../conexao/conexao.php');

    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao bancoo de dados.',
        'dados' => array()
    );

    if($conexao){

        $idNoticia = $_REQUEST['idnoticia'];

        $sql = "SELECT n.idnoticia, date_format(n.data_noticia,'%d/%m/%Y %H:%i:%s') as data_noticia, n.titulo, n.corpo, n.imagem, n.idcategoria, c.nome as categoria FROM NOTICIAS n
        INNER JOIN CATEGORIAS c ON c.idcategoria = n.idcategoria
        WHERE idnoticia=$idNoticia";
        
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
                'mensagem' => 'Não foi possível obter a notícia.',
                'dados' => array()
            );
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);