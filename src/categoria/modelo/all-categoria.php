<?php

    //Realizar a conexão com o banco de dados
    include('../../conexao/conexao.php');

    //Prepara o objeto de retorno vazio
    $dados = array();

    //Verifica se existem uma conexão
    if($conexao){

        //Prepara o comando select
        $sql = "SELECT idcategoria, nome FROM CATEGORIAS ORDER BY nome";

        //Executa o comando
        $resultado = mysqli_query($conexao, $sql);

        //Caso tenha um resultado satisfatório
        if($resultado){
            
            //Obtém os dados da categoria
            while($row = mysqli_fetch_assoc($resultado)){
                $dados[] = array_map('utf8_encode', $row);
            }
        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);