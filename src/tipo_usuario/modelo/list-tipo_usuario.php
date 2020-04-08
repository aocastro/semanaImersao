<?php

    //Realizar o include da conexão
    include('../../conexao/conexao.php');

    //Verificar se tem um conexão
    if($conexao){

        //Obter o request vindo do datatable
        $requestData = $_REQUEST;

        //Obter as colunas vindas do resquest
        $colunas = $requestData['columns'];

        //Preparar o comando sql para obter os dados do tipo_usuario
        $sql = "SELECT idtipo_usuario, nome, tipo FROM TIPOS_USUARIOS WHERE 1=1 ";

        //Obter o total de registros cadastrados
        $resultado = mysqli_query($conexao, $sql);
        $qtdeLinhas = mysqli_num_rows($resultado);

        //Verificando se há filtro determinado
        $filtro = $requestData['search']['value'];
        if( !empty( $filtro ) ){
            //Montar a expressão lógica que irá compor os filtros
            //Aqui você deverá determinar quais colunas farão parte do filtro
            $sql .= " AND (idtipo_usuario LIKE '$filtro%' ";
            $sql .= " OR nome LIKE '$filtro%' ";
            $sql .= " OR tipo LIKE '$filtro%') ";
        }
        //Obter o total dos dados filtrados
        $resultado = mysqli_query($conexao, $sql);
        $totalFiltrados = mysqli_num_rows($resultado);

        //Obter valores para ORDER BY      
        $colunaOrdem = $requestData['order'][0]['column']; //Obtém a posição da coluna na ordenação
        $ordem = $colunas[$colunaOrdem]['data']; //Obtém o nome da coluna para a ordenação
        $direcao = $requestData['order'][0]['dir']; //Obtém a direção da ordenação

        //Obter valores para o LIMIT
        $inicio = $requestData['start']; //Obtém o ínicio do limite
        $tamanho = $requestData['length']; //Obtém o tamanho do limite

        //Realizar o ORDER BY com LIMIT
        $sql .= " ORDER BY $ordem $direcao LIMIT $inicio, $tamanho ";
        $resultado = mysqli_query($conexao, $sql);
        $dados = array();
        while($row = mysqli_fetch_assoc($resultado)){
            $dados[] = array_map('utf8_encode', $row);
        }

        //Monta o objeto json para retornar ao DataTable
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($qtdeLinhas),
            "recordsFiltered" => intval($totalFiltrados),
            "data" => $dados
        );

        //Fecha a conexão com o banco
        mysqli_close($conexao);

    } else{
        //Monta um obejto json zerado para retornar ao DataTable
        $json_data = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array()
        );
    }

    //Retorna o objeto json para o DataTable
    echo json_encode($json_data);