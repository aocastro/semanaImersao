<?php

    include('../../conexao/conexao.php');

    if($conexao){

        $requestData = $_REQUEST;
        $imagem = $_FILES['imagem'];

        if(!empty($requestData['data_noticia']) && !empty($requestData['titulo']) && !empty($requestData['corpo']) && !empty($requestData['idcategoria'])){

            $idNoticia = isset($requestData['idnoticia']) ? $requestData['idnoticia'] : '';
            $titulo = utf8_decode($requestData['titulo']);
            $corpo = utf8_decode($requestData['corpo']);
            $dataNoticia = str_replace('/','-',$requestData['data_noticia']);
            $dataNoticia = date('Y-m-d H:i:s', strtotime($dataNoticia));
            $idCategoria = $requestData['idcategoria'];

            if($requestData['operacao'] == 'insert'){

               

            } else {

                $sql = "UPDATE NOTICIAS SET data_noticia='$dataNoticia', titulo='$titulo', corpo='$corpo', idcategoria='$idCategoria' WHERE idnoticia=$idNoticia";
                $resultado = mysqli_query($conexao, $sql);
                if($resultado){
                    $dados = array(
                        'tipo' => 'success',
                        'mensagem' => 'Notícia alterada com sucesso.'
                    );
                } else{
                    $dados = array(
                        'tipo' => 'error',
                        'mensagem' => 'Não foi possível alterar a notícia.'
                    );
                }
            }

        } else{
            $dados = array(
                'tipo' => 'info',
                'mensagem' => 'Existe(m) campo(s) obrigatório(s) vazio(s).'
            );
        }

        mysqli_close($conexao);

    } else {

        $dados = array(
            'tipo' => 'info',
            'mensagem' => 'Não foi possível conectar ao banco de dados.'
        );
    }

    echo json_encode($dados);