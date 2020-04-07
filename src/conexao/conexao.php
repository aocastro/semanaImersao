<?php

    date_default_timezone_set('America/Sao_Paulo');

    $conexao = @mysqli_connect('localhost', 'root', '', 'db_blog')
    or die('Erro ao conectar o banco de dados...');