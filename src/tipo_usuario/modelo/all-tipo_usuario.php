<?php

    //Realizar a conexão com o banco de dados
    include('../../conexao/conexao.php');

    //Prepara um array de retorno vazio
    $dados = array();

    //Verifica se existem uma conexão
    if($conexao){

        //Prepara o comando select
        $sql = "SELECT idtipo_usuario, nome FROM TIPOS_USUARIOS ORDER BY nome";

        //Executa o comando
        $resultado = mysqli_query($conexao, $sql);

        //Caso tenha um resultado satisfatório
        if($resultado){
            
            //Obtém os dados do tipo de usuário
            while($row = mysqli_fetch_assoc($resultado)){
                $dados[] = array_map('utf8_encode', $row);
            }
        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);