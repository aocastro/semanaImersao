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

        //Verifica se está vindo o idusuario, caso não esteja o idUsuario será '' vazio
        $idUsuario = isset($requestData['idusuario']) ? $requestData['idusuario'] : '';

        //Prepara o comando select
        $sql = "SELECT u.idusuario, u.nome, u.email, u.senha, u.idtipo_usuario, t.nome as tipo_usuario 
                FROM USUARIOS u
                INNER JOIN TIPOS_USUARIOS t ON t.idtipo_usuario = u.idtipo_usuario 
                WHERE idusuario=$idUsuario";
        
        //Executa o comando
        $resultado = mysqli_query($conexao,$sql);

        //Caso tenha um resultado satisfatório
        if($resultado){

            //Obtém os dados do usuário
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
                'mensagem' => 'Não foi possível obter o usuário.',
                'dados' => array()
            );
        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);