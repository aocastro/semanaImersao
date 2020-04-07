<?php

    include('../../conexao/conexao.php');

    if($conexao){

        $requestData = $_REQUEST;

        if(empty($requestData['nome']) || empty($requestData['tipo'])){

            $dados = array(
                "tipo" => 'error',
                "mensagem" => 'Existe(m) campo(s) obrigatório(s) não preenchido(s).'
            );
        } else{

            $idTipoUsuario = isset($requestData['idtipo_usuario']) ? $requestData['idtipo_usuario'] : 0; 
            $nome = utf8_decode($requestData['nome']);
            $tipo = $requestData['tipo'];

            if($requestData['operacao'] == 'insert'){

                $sql = "INSERT INTO TIPO_USUARIOS(nome, tipo) VALUES ('$nome', '$tipo')";
            } else {

                $sql = "UPDATE TIPO_USUARIOS SET nome='$nome', tipo='$tipo' WHERE idtipo_usuario = $idTipoUsuario";
            }

            $resultado = mysqli_query($conexao, $sql);

            if($resultado){

                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'Tipo Usuário salvo com sucesso.'
                );
            } else {

                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Não foi possível salvar o tipo de usuário'
                );

            }

            mysqli_close($conexao);

        }
    } else{

        $dados = array(
            "tipo" => 'info',
            "mensagem" => 'Não foi possível conectar ao banco.'
        );
    }

    echo json_encode($dados);