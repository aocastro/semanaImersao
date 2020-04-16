<?php

    include('../../conexao/conexao.php');

    $idCategoria = isset($_REQUEST['idcategoria']) ? $_REQUEST['idcategoria'] : '';

    $dados = array();

    if($conexao){

        $sql = "SELECT n.idnoticia, date_format(n.data_noticia,'%d/%m/%Y %H:%i:%s') as data_noticia, 
        n.titulo, n.corpo, n.imagem, n.idcategoria, c.nome as categoria
        FROM NOTICIAS n
        INNER JOIN CATEGORIAS c ON c.idcategoria = n.idcategoria ";

        if(!empty($idCategoria)){
            $sql .= " WHERE n.idcategoria='$idCategoria' ";
        }

        $sql .= " ORDER BY n.data_noticia desc LIMIT 6";
        
        $resultado = mysqli_query($conexao, $sql);
        if($resultado){
            
            while($row = mysqli_fetch_assoc($resultado)){
                $dados[] = array_map('utf8_encode', $row);
            }
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);