<?php

    //obtém uma conexão com o banco de dados
    include('../../conexao/conexao.php');

    //Prepara o array de retorno caso não tenha uma conexão com o banco
    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao bancoo de dados.',
        'dados' => array()
    );

    //Verifica se existem uma conexão
    if($conexao){

        //Obtém os dados via post
        $requestData = $_REQUEST;

        //Verifica se está vindo o idcategoria, caso não esteja o idCategoria será '' vazio
        $idCategoria = isset($requestData['idcategoria']) ? $requestData['idcategoria'] : '';

        //Prepara o comando select
        $sql = "SELECT idcategoria, nome FROM CATEGORIAS 
                WHERE idcategoria=$idCategoria";
        
        //Executa o comando
        $resultado = mysqli_query($conexao,$sql);

        //Caso tenha um resultado satisfatório
        if($resultado){

             //Obtém os dados da categoria
            $dadosTipo = array();
            while($row = mysqli_fetch_assoc($resultado)){
                $dadosTipo = array_map('utf8_encode', $row);
            }

            //Prepara o array de retorno com sucesso
            $dados = array(
                'tipo' => 'success',
                'mensagem' => '',
                'dados' => $dadosTipo
            );
        } else{ //Caso não tenha um resultado satisfatório

            //Prepara o array de retorno com erro
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível obter a categoria.',
                'dados' => array()
            );
        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);