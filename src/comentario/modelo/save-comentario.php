<?php

    //Obtém uma conexão com o banco de dados
    include('../../conexao/conexao.php');

    //Verifica se tem uma conexão
    if($conexao){

        //Obtém os dados do formulário via request
        $requestData = $_REQUEST;

        //Verifica se existe(m) campo(s) obrigatório(s) vazio(s)
        if(empty($requestData['comentario']) && empty($requestData['data_comentario']) ){

            //Caso exista, definir um objeto array para retorno
            $dados = array(
                "tipo" => 'error',
                "mensagem" => 'Existe(m) campo(s) obrigatório(s) não preenchido(s).'
            );
        } else{

            //Caso não exista(m) campo(s) vazio(s), criar variáveis para
            //manipular os dados da request

            //isset() testa se existe idtipo_usuario dentro da request
            $idComentario = isset($requestData['idcomentario']) ? $requestData['idcomentario'] : ''; 
            //utf8_decode() - decodifica string, assumido ser codificada em UTF-8, para ISO-8859-1.
            $comentario = preg_replace("/(\\r)?\\n/i", "<br/>", $requestData['comentario']);
            $comentario = utf8_decode($comentario);
            $dataComentario = str_replace('/','-',$requestData['data_comentario']);
            $dataComentario = date('Y-m-d H:i:s', strtotime($dataComentario));
            $idNoticia = $requestData['idnoticia'];
            $idUsuario = $requestData['idusuario'];

            $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

            //Verifica se a operação é 'insert'
            if($operacao == 'insert'){

                //Prepara o comando sql para executar o INSERT
                $sql = "INSERT INTO COMENTARIOS(data_comentario, comentario, idnoticia, idusuario) VALUES ('$dataComentario', '$comentario', '$idNoticia', '$idUsuario')";
            } else { //Caso contrário, ou qualquer valor diferente de 'insert'

                //Prepara o comando sql para executar o UPDATE
                $sql = "UPDATE COMENTARIOS SET data_comentario='$dataComentario', comentario='$comentario', idnoticia='$idNoticia', idusuario='$idUsuario' WHERE idcomentario='$idComentario'";
            }

            //Executa a operação em questão
            $resultado = mysqli_query($conexao, $sql);

            //Verifica se obteve sucesso com a operação em questão
            if($resultado){

                //Define um objeto array para retorno de sucesso
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'Comentário salvo com sucesso.'
                );
            } else { //Caso houve algum erro na execução do comando

                //Define um objeto array para retorno de erro
                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Não foi possível salvar o comentário.'
                );

            }

        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);

    } else{ //Caso não tenha uma conexão

        //Define um objeto array para retorno informando que não foi possível conectar ao banco de dados
        $dados = array(
            "tipo" => 'info',
            "mensagem" => 'Não foi possível conectar ao banco.'
        );
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);