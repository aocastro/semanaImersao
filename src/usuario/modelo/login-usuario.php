<?php

    //Inicia uma sessão para armazenar o login
    session_start();

    //Obtém uma conexão com o banco de dados
    include('../../conexao/conexao.php');

    //Prepara o array de retorno caso não tenha uma conexão
    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao banco de dados.',
        'dados' => array()
    );

    //Verifica se existem uma conexão
    if($conexao){

        //Obtém os dados via post
        $requestData = $_REQUEST;

        //Verifica se o e-mail ou a senha estão vazios
        if( !empty($requestData['email']) && !empty($requestData['senha']) ){

            //Prepara o comando para buscar o usuário
            //Notém que a declaração SQL possui duas ?
            //São parâmetros iremos usar no statement(declaração)
            $sql = "SELECT idusuario, nome, email, senha, idtipo_usuario 
                    FROM USUARIOS WHERE email=? AND senha=?";

            //A função mysqli_prepare cria um statement a partir de uma conexão
            //e um comando SQL. Ao preparar um statement já verifica se existe
            //algo de errado na declaração SQL
            //Então estamos verificando se conseguimos um statement correto
            if($stmt = mysqli_prepare($conexao, $sql)){

                //Criptograia a senha vinda do formulário para que possa ser
                //comparada com a senha salva no banco de dados
                $requestData['senha'] = md5($requestData['senha']);

                //A função mysqli_stmt_bind_param especifica os valores que as ?
                //(parâmetros) irão receber, onde ela irá verificar se nos valores
                //possuiem códigos de SQL INJECTION, e caso exista, elimina-os
                //O primeiro parâmetro deve ser o statament conseguido acima
                //O segundo parâmetro é uma string que contém as iniciais dos tipos
                //dos valores de cada parâmetro(?). Cada parâmentro deverá ter a sua
                //inicial na sequência.
                //Tipos podem ser s - para string; i - para inteiros; d - para double
                // b - para blob (binário)
                //O terceiro parâmetro é um conjunto de variáveis que irão substituir
                //as ?
                mysqli_stmt_bind_param($stmt, "ss", $requestData['email'], $requestData['senha']);

                //Executa o statement (declaração)
                mysqli_execute($stmt);

                //Obtém o resultado da execução do statement
                $resultado = mysqli_stmt_get_result($stmt);
                
                //Realiza o fetch dos dados do usuário
                if($dadosUsuario = mysqli_fetch_assoc($resultado)){

                    //Aplica a função utf8_encode para todos os elemementos
                    //do array $dadosUsuario retornando um novo array com o
                    //mesmo tamanho e especificação
                    $dadosUsuario = array_map('utf8_encode', $dadosUsuario);

                    //Prepara o array de retorno
                    $dados = array(
                        'tipo' => 'success',
                        'mensagem' => '',
                        'dados' => $dadosUsuario
                    );

                    //Cria as variáveis de sessão
                    $_SESSION['idusuario'] = $dadosUsuario['idusuario'];
                    $_SESSION['nome'] = $dadosUsuario['nome'];
                    $_SESSION['email'] = $dadosUsuario['email'];
                    $_SESSION['senha'] = $dadosUsuario['senha'];
                    $_SESSION['idtipo_usuario'] = $dadosUsuario['idtipo_usuario'];

                } else{ //Caso o login esteja incorreto

                    //Prepara o array de retorno
                    $dados=array(
                        'tipo' => 'info',
                        'mensagem' => 'Login incorreto.',
                        'dados' => array()
                    );

                    //Exclui as variáveis de sessão
                    unset($_SESSION['idusuario']);
                    unset($_SESSION['nome']);
                    unset($_SESSION['email']);
                    unset($_SESSION['senha']);
                    unset($_SESSION['idtipo_usuario']);
                }
                
                //Fecha o statement(declaração)
                mysqli_stmt_close($stmt);

            } else { //Caso não tenhamos um statement correto

                //Exclui as variáveis de sessão
                $dados=array(
                    'tipo' => 'info',
                    'mensagem' => 'Não foi possível realizar o login.',
                    'dados' => array()
                );
            }

            //Fecha a conexão com o banco de dados
            mysqli_close($conexao);

        } else{ //Caso o e-mail e senha estejam vazios retorna um objeto com a mensagem
            $dados = array(
                'tipo' => 'info',
                'mensagem' => 'Necessário informar usuário/senha.',
                'dados' => array()
            );
        }
    }

    //retona o array transformado em objeto json
    echo json_encode($dados);

/*
    SQL INJECTION - Injeção de SQL

    $email = 
    $senha = ' OR '1=1 

    "SELECT * FROM USUARIOS WHERE email='$mail' AND senha='$senha'"

    "SELECT * FROM USUARIOS WHERE email='' AND senha ='' OR '1=1'"
*/