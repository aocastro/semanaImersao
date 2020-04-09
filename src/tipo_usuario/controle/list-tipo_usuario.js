$(document).ready(function() {
    // Aqui iremos efetuar a seleção da nossa tabela do HTML para receber as propriedades DataTable
    // Vale resaltar que as bibliotecas do DataTable foram inportadas na página principal adm.html
    $('#table-tipo_usuario').DataTable({
        "processing": true, // Aqui é onde demonstramos para o serviço do DataTable que iremos processar as informações em 2º plano
        "serverSide": true, // Nesta linha demonstramos em que tudo será processado no servidor e o fornt-end somente apresentará os resultados
        "ajax": { // Aqui é realizado a requisição em AJAX de uma forma mais simplificada, já que o dataTable trabalha com objetos
            "url": "src/tipo_usuario/modelo/list-tipo_usuario.php",
            "type": "POST"
        },
        "language": { // Para que as legendas do DataTable esteja em nossa lingua é necessário baixar o pacote e instância-lo aqui, já que o padrão é o inglês
            "url": "dataTables.brazil.json"
        },
        // Agora aqui iremos iniciar a construção da nossa tabela, onde basicamente somente devemos informar qual dado devemos procurar dentro do objeto
        // e também podemos habilitar e desabilitar a ordenação e mecanismo de busca, bem como podemos adicionar alguma propriedade CSS na tabela
        "columns": [{
                "data": 'idtipo_usuario',
                "className": 'text-center'
            },
            {
                "data": 'nome',
                "className": 'text-center'
            },
            {
                "data": 'tipo',
                "className": 'text-center'
            },
            {
                // O último elemento a ser instânciado em nossa DataTable são os nossos botões de ações, ou seja, devemos criar os elementos em tela para
                // podermos executar as funções do CRUD.
                "data": 'idtipo_usuario',
                "orderable": false, // Aqui iremos desabilitar a opção de ordenamento por essa coluna
                "searchable": false, // Aqui também iremos desabilitar a possibilidade de busca por essa coluna
                "className": 'text-center',
                // Nesta linha iremos chamar a função render que pega os nossos elementos HTML e renderiza juntamente com as informações carregadas do objeto
                "render": function(data, type, row, meta) {
                    return `
                            <button id="${data}" class="btn btn-info btn-sm">R</button>
                            <button id="${data}" class="btn btn-primary btn-sm">U</button>
                            <button id="${data}" class="btn btn-danger btn-sm">D</button>
                    `
                }
            }
        ]
    })
})