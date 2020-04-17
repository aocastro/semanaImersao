<?php

    session_start();

    include('../../conexao/conexao.php');

    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao banco de dados.',
        'dados' => array()
    );

    if($conexao){

        $requestData = $_REQUEST;

        if( !empty($requestData['email']) && !empty($requestData['senha']) ){

            $sql = "SELECT idusuario, nome, email, senha, idtipo_usuario 
                    FROM USUARIOS WHERE email=? AND senha=?";

            if($stmt = mysqli_prepare($conexao, $sql)){

                $requestData['senha'] = md5($requestData['senha']);

                mysqli_stmt_bind_param($stmt, "ss", $requestData['email'], $requestData['senha']);

                mysqli_execute($stmt);

                $resultado = mysqli_stmt_get_result($stmt);
                    
                if($dadosUsuario = mysqli_fetch_assoc($resultado)){

                    $dadosUsuario = array_map('utf8_encode', $dadosUsuario);
                    $dados = array(
                        'tipo' => 'success',
                        'mensagem' => '',
                        'dados' => $dadosUsuario
                    );

                    $_SESSION['idusuario'] = $dadosUsuario['idusuario'];
                    $_SESSION['nome'] = $dadosUsuario['nome'];
                    $_SESSION['email'] = $dadosUsuario['email'];
                    $_SESSION['senha'] = $dadosUsuario['senha'];
                    $_SESSION['idtipo_usuario'] = $dadosUsuario['idtipo_usuario'];

                } else{

                    $dados=array(
                        'tipo' => 'info',
                        'mensagem' => 'Login incorreto.',
                        'dados' => array()
                    );

                    unset($_SESSION['idusuario']);
                    unset($_SESSION['nome']);
                    unset($_SESSION['email']);
                    unset($_SESSION['senha']);
                    unset($_SESSION['idtipo_usuario']);
                }
                
                mysqli_stmt_close($stmt);

            } else {
                $dados=array(
                    'tipo' => 'info',
                    'mensagem' => 'Não foi possível realizar o login.',
                    'dados' => array()
                );
            }

            mysqli_close($conexao);

        } else{
            $dados = array(
                'tipo' => 'info',
                'mensagem' => 'Necessário informar usuário/senha.',
                'dados' => array()
            );
        }
    }

    echo json_encode($dados);

/*
    SQL INJECTION - Injeção de SQL

    $email = 
    $senha = ' OR '1=1 

    "SELECT * FROM USUARIOS WHERE email='$mail' AND senha='$senha'"

    "SELECT * FROM USUARIOS WHERE email='' AND senha ='' OR '1=1'"
*/