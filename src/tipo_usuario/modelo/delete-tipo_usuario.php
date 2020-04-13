<?php

    //Obtém uma conexão com o banco de dados
    include('../../conexao/conexao.php');

    //Define um objeto array para retorno informando que não foi possível conectar ao banco de dados
    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao banco de dados.'
    );

    //Verifica se existem uma conexão
    if($conexao){
        //Obtém o idtipo_usuario via request
        $idTipoUsuario = $_REQUEST['idtipo_usuario'];

        //Uma possível solução para validar a referência cruzada (chave estrangeira)
        //entre as tabelas tipos_usuarios e usuarios

        //Prepara o comando sql para verificar se exite(m) linha(s) relacionada(s)
        //na tabela usuarios
        $sql = "SELECT * FROM USUARIOS WHERE idtipo_usuario=$idTipoUsuario";
        $resultado = mysqli_query($conexao, $sql);

        //Verifica a quantidade de linhas existentes no resultado
        //Caso a quantidade de linha seha igual a 0 (zero) pode deletar
        //o tipo usuario
        if(mysqli_num_rows($resultado) == 0){

            //Prepara o comando sql em questão
            $sql = "DELETE FROM TIPOS_USUARIOS WHERE idtipo_usuario=$idTipoUsuario";

            //Executa o comando em questão
            $resultado = mysqli_query($conexao, $sql);

            //Verifica se obteve sucesso com a operação em questão
            if($resultado){
                //Define um objeto array para retorno de sucesso
                $dados = array(
                    'tipo' => 'success',
                    'mensagem' => 'Tipo de usuário deletado com sucesso.'
                );
            } else{ //Caso houve algum erro na execução do comando
                //Define um objeto array para retorno de erro
                $dados = array(
                    'tipo' => 'error',
                    'mensagem' => 'Não foi possível deletar o tipo de usuário.'
                );
            }
        } else{ //Caso encontrou algum usuario com o tipo de usuario em questão
            $dados = array(
                //Define um objeto array para retorno de informação
                'tipo' => 'info',
                'mensagem' => 'Não foi possível deletar, o tipo de usuário alocado em usuário.'
            );
        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);