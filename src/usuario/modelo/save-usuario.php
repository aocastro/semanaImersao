<?php

    //Obtém uma conexão com o banco de dados
    include('../../conexao/conexao.php');

    //Verifica se tem uma conexão
    if($conexao){

        //Obtém os dados do formulário via request
        $requestData = $_REQUEST;

        //Verifica se existe(m) campo(s) obrigatório(s) vazio(s)
        if(empty($requestData['nome']) || empty($requestData['email']) || empty($requestData['senha']) || empty($requestData['idtipo_usuario'])){

            //Caso exista, definir um objeto array para retorno
            $dados = array(
                "tipo" => 'error',
                "mensagem" => 'Existe(m) campo(s) obrigatório(s) não preenchido(s).'
            );
        } else{

            //Caso não exista(m) campo(s) vazio(s), criar variáveis para
            //manipular os dados da request

            //isset() testa se existe idtipo_usuario dentro da request
            $idUsuario = isset($requestData['idusuario']) ? $requestData['idusuario'] : ''; 
            //utf8_decode() - decodifica string, assumido ser codificada em UTF-8, para ISO-8859-1.
            $nome = utf8_decode($requestData['nome']);
            $email = $requestData['email'];
            $senha = $requestData['senha'];
            $idTipoUsuario = $requestData['idtipo_usuario'];
            $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

            //Verifica se a operação é 'insert'
            if($operacao == 'insert'){

                //Prepara o comando sql para executar o INSERT
                $sql = "INSERT INTO USUARIOS(nome, email, senha, idtipo_usuario) VALUES ('$nome', '$email', '$senha', '$idTipoUsuario')";
            } else { //Caso contrário, ou qualquer valor diferente de 'insert'

                //Prepara o comando sql para executar o UPDATE
                $sql = "UPDATE USUARIOS SET nome='$nome', email='$email', senha='$senha', idtipo_usuario='$idTipoUsuario' WHERE idusuario = $idUsuario";
            }

            //Executa a operação em questão
            $resultado = mysqli_query($conexao, $sql);

            //Verifica se obteve sucesso com a operação em questão
            if($resultado){

                //Define um objeto array para retorno de sucesso
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'Usuário salvo com sucesso.'
                );
            } else { //Caso houve algum erro na execução do comando

                //Define um objeto array para retorno de erro
                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Não foi possível salvar o usuário'
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