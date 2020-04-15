$(document).ready(function() {
    // Aqui iremos efetuar a seleção da nossa tabela do HTML para receber as propriedades DataTable
    // Vale resaltar que as bibliotecas do DataTable foram inportadas na página principal adm.html
    $('#table-noticia').DataTable({
        "processing": true, // Aqui é onde demonstramos para o serviço do DataTable que iremos processar as informações em 2º plano
        "serverSide": true, // Nesta linha demonstramos em que tudo será processado no servidor e o fornt-end somente apresentará os resultados
        "ajax": { // Aqui é realizado a requisição em AJAX de uma forma mais simplificada, já que o dataTable trabalha com objetos
            "url": "src/noticia/modelo/list-noticia.php",
            "type": "POST"
        },
        "language": { // Para que as legendas do DataTable esteja em nossa lingua é necessário baixar o pacote e instância-lo aqui, já que o padrão é o inglês
            "url": "dataTables.brazil.json"
        },
        // Agora aqui iremos iniciar a construção da nossa tabela, onde basicamente somente devemos informar qual dado devemos procurar dentro do objeto
        // e também podemos habilitar e desabilitar a ordenação e mecanismo de busca, bem como podemos adicionar alguma propriedade CSS na tabela
        "columns": [{
                "data": 'idnoticia',
                "className": 'text-center' // Aqui é a inclusão da classe de alinhamento de texto do bootstrap, porém pode ser usado qualquer CSS
            },
            {
                "data": 'data_noticia',
                "className": 'text-center'
            },
            {
                "data": 'titulo',
                "className": 'text-center'
            },
            {
                // O último elemento a ser instânciado em nossa DataTable são os nossos botões de ações, ou seja, devemos criar os elementos em tela para
                // podermos executar as funções do CRUD.
                "data": 'idnoticia',
                "orderable": false, // Aqui iremos desabilitar a opção de ordenamento por essa coluna
                "searchable": false, // Aqui também iremos desabilitar a possibilidade de busca por essa coluna
                "className": 'text-center',
                // Nesta linha iremos chamar a função render que pega os nossos elementos HTML e renderiza juntamente com as informações carregadas do objeto
                "render": function(data, type, row, meta) {
                    return `
                    <button id="${data}" class="btn btn-info btn-sm btn-view"><i class="mdi mdi-eye"></i></button>
                    <button id="${data}" class="btn btn-primary btn-sm btn-edit"><i class="mdi mdi-pencil"></i></button>
                    <button id="${data}" class="btn btn-danger btn-sm btn-delete"><i class="mdi mdi-trash-can"></i></button>
                    `
                }
            }
        ]
    })
})