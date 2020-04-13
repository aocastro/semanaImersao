<?php

    //Obtém uma conexão com o banco de dados
    include('../../conexao/conexao.php');

    //Define um objeto array para retorno informando que não foi possível conectar ao banco de dados
    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao bancoo de dados.',
        'dados' => array()
    );

    //Verifica se existem uma conexão
    if($conexao){

        //Obtém o idtipo_usuario via request
        $idTipoUsuario = $_REQUEST['idtipo_usuario'];

        //Prepara o comando sql para executar a consulta
        //trazendo os dados do tipo de usuário onde 
        //idtipo_usuario é igual que está vindo via post
        $sql = "SELECT idtipo_usuario, nome, tipo FROM TIPOS_USUARIOS 
                WHERE idtipo_usuario=$idTipoUsuario";
        
        //Executa a operação em questão
        $resultado = mysqli_query($conexao,$sql);

        //Verifica se obteve sucesso com a operação em questão
        if($resultado){

            //Inicializa um array que será o dados em retorno
            $dadosTipo = array();
            //Enquanto houver linhas do resultado, executa o fetch_assoc
            while($row = mysqli_fetch_assoc($resultado)){
                //Aplica a função utf8_encode para todos os elementos de row
                //e adiciona o resultado no array de dados
                $dadosTipo = array_map('utf8_encode', $row);
            }
            //Define um objeto array para retorno de sucesso
            $dados = array(
                'tipo' => 'success',
                'mensagem' => '',
                'dados' => $dadosTipo
            );
        } else{ //Caso houve algum erro na execução do comando
            //Define um objeto array para retorno de erro
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível obter o tipo de usuário.',
                'dados' => array()
            );
        }

        //Fecha a conexão com o banco de dados
        mysqli_close($conexao);
    }

    //Converte um array de dados para a represetação JSON
    echo json_encode($dados);