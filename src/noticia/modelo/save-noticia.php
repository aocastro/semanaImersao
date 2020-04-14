<?php

    include('../../conexao/conexao.php');

    if($conexao){

        $requestData = $_REQUEST;
        $imagem = $_FILES['imagem'];

        if(!empty($requestData['data_noticia']) && !empty($requestData['titulo']) && !empty($requestData['corpo']) && !empty($requestData['idcategoria'])){

            $idNoticia = isset($requestData['idnoticia']) ? $requestData['idnoticia'] : '';
            $titulo = utf8_decode($requestData['titulo']);
            $corpo = preg_replace("/(\\r)?\\n/i", "<br/>", $requestData['corpo']);
            $corpo = uft8_decode($corpo);
            $dataNoticia = str_replace('/','-',$requestData['data_noticia']);
            $dataNoticia = date('Y-m-d H:i:s', strtotime($dataNoticia));
            $idCategoria = $requestData['idcategoria'];

            if($requestData['operacao'] == 'insert'){

               //Realizar o INSERT/UPLOAD e INSERT
               if(!empty($imagem['name']) && $imagem['error'] == 0){

                    $pasta = 'img/';
                    if(!file_exists($pasta)) mkdir($pasta, 0755);

                    $arquivoTemporario = $imagem['tmp_name'];
                    $nomeArquivo = $imagem['name'];
                    $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);
                    $extensao = strtolower($extensao);
                    $tipoArquivo = array('jpg', 'jpeg', 'png', 'gif');
                    if(in_array($extensao, $tipoArquivo)){
                        $novoNome = uniqid(time()) . '.' . $extensao;
                        $destino = $pasta . $novoNome;
                        if(move_uploaded_file($arquivoTemporario, $destino)){
                            $sql = "INSERT INTO NOTICIAS(data_noticia, titulo, corpo, imagem, idcategoria) VALUES('$dataNoticia', '$titulo', '$corpo', '$destino', '$idCategoria')";
                            $resultado = mysqli_query($conexao, $sql);
                            if($resultado){
                                $dados = array(
                                    'tipo' => 'success',
                                    'mensagem' => 'Notícia salva com sucesso.'
                                );
                            } else{
                                $dados = array(
                                    'tipo' => 'error',
                                    'mensagem' => 'Não possível salvar a notícia.'
                                );
                                unlink($destino);
                            }
                        } else{
                            $dados = array(
                                'tipo' => 'error',
                                'mensagem' => 'Não possível realizar o upload.'
                            );
                        }
                    }else{
                        $dados = array(
                            'tipo' => 'info',
                            'mensagem' => 'Você somente poderá enviar arquivos "*.jpg; *.jpeg; *.gif; *.png"'
                        );
                    }
               } else{
                    $sql = "INSERT INTO NOTICIAS(data_noticia, titulo, corpo, idcategoria) VALUES('$dataNoticia', '$titulo', '$corpo', '$idCategoria')";
                    $resultado = mysqli_query($conexao, $sql);
                    if($resultado){
                        $dados = array(
                            'tipo' => 'success',
                            'mensagem' => 'Notícia salva com sucesso.'
                        );
                    } else{
                        $dados = array(
                            'tipo' => 'error',
                            'mensagem' => 'Não possível salvar a notícia.'
                        );
                    }
               }

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