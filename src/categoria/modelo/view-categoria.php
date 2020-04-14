<?php

    include('../../conexao/conexao.php');

    $dados = array(
        'tipo' => 'info',
        'mensagem' => 'Não foi possível conectar ao bancoo de dados.',
        'dados' => array()
    );

    if($conexao){

        $idCategoria = $_REQUEST['idcategoria'];

        $sql = "SELECT idcategoria, nome FROM CATEGORIAS 
                WHERE idcategoria=$idCategoria";
        
        $resultado = mysqli_query($conexao,$sql);

        if($resultado){

            $dadosTipo = array();
            while($row = mysqli_fetch_assoc($resultado)){
                $dadosTipo = array_map('utf8_encode', $row);
            }

            $dados = array(
                'tipo' => 'success',
                'mensagem' => '',
                'dados' => $dadosTipo
            );
        } else{
            $dados = array(
                'tipo' => 'error',
                'mensagem' => 'Não foi possível obter a categoria.',
                'dados' => array()
            );
        }

        mysqli_close($conexao);
    }

    echo json_encode($dados);