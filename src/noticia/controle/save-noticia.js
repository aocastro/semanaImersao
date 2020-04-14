$(document).ready(function() {

    $('.btn-save').click(function(e) {
        e.preventDefault()

        var dados = new FormData(document.getElementById('form-noticia'))

        // dados += `&operacao=${$('.btn-save').attr('data-operation')}`

        dados.append("operacao", $('.btn-save').attr('data-operation'))

        console.log(dados)

        $.ajax({
            type: 'POST', // A primeira informação que dados ao Ajax é como o dados será transmitidos/recebidos [POST / GET]
            dataType: 'json', // Depois demonstramos como desejamos que os dados transitem sendo que pode ser por Json ou XML, porém XML caiu em desuso
            data: dados, // Aqui informamos onde estão os dados que seráo transmitidos
            url: 'src/noticia/modelo/save-noticia.php', //Aqui informamos para onde será transmitido os dados
            nimeType: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            success: function(dados) { // Aqui criamos a função que receberá o retorno dos dados e os tratamos
                Swal.fire({ // Inicialização do SweetAlert
                    title: 'SysBlog', // Título da janela SweetAlert
                    text: dados.mensagem, // Mensagem retornada do microserviço
                    type: dados.tipo, // Tipo de retorno [success, info ou error]
                    confirmButtonText: 'OK'
                })

                // Fechamento do modal
                $('#modal-noticia').modal('hide')
                    // $('#table-usuario').DataTable().ajax.reload()
            }
        })
    })
})