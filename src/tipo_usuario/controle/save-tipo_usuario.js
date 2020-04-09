// Inicialiando o arquivo JavaScript com a leitura dos elementos do documento HTML
$(document).ready(function() {
    // Na linha abaixo selecionamos o elemnto do nosso HTML que tem a classe 'btn-save' e monitoramos o clique do mouse sobre ele
    $('.btn-save').click(function(e) {
        // A função preventDefault() trabalha atuando em cima de limpar as funcionalidades do elemento que está sendo monitorado o click
        e.preventDefault()

        // Nesta linha será criado uma variável local "let" para armazenar os dados que serão coletados do formulário do modal
        // Vale resaltar que a função serialize() do JavaScript tem com objetivo rastear todo o formulário e criar um array de transição de dados
        let dados = $('#form-tipo_usuario').serialize()

        // Agora iremos incluir no array criado acima o tipo de operação que desejamos realizar com os dados colhidos no formulário
        dados += `&operacao=${$('.btn-save').attr('data-operation')}`

        // Aqui será executado o AJAX que é o meio de transição de dados em segundo plano, sendo que é graças a ele que podemos
        // transitar dados entre o HTML e PHP sem estar explícito em primeiro plano, para ser a transição dos dados será
        // necessário abrir o DEBUG do navegar o acompanhar tudo na aba Network
        $.ajax({
            type: 'POST', // A primeira informação que dados ao Ajax é como o dados será transmitidos/recebidos [POST / GET]
            dataType: 'json', // Depois demonstramos como desejamos que os dados transitem sendo que pode ser por Json ou XML, porém XML caiu em desuso
            assync: true, // Demonstramos para o AJAX como queremos que tudo isso ocorra ==> Assincrono executado em paralelo com o front-end e outro serviços
            data: dados, // Aqui informamos onde estão os dados que seráo transmitidos
            url: 'src/tipo_usuario/modelo/save-tipo_usuario.php', //Aqui informamos para onde será transmitido os dados
            success: function(dados) { // Aqui criamos a função que receberá o retorno dos dados e os tratamos
                Swal.fire({ // Inicialização do SweetAlert
                    title: 'SysBlog', // Título da janela SweetAler
                    text: dados.mensagem, // Mensagem retornada do microserviço
                    type: dados.tipo, // Tipo de retorno [success, info ou error]
                    confirmButtonText: 'OK'
                })

                // Fechamento do modal
                $('#modal-tipo-usuario').modal('hide')
                $('#table-tipo_usuario').DataTable().ajax.reload()
            }
        })

    })

})