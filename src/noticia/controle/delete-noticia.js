$(document).ready(function() {

    $('#table-noticia').on('click', 'button.btn-delete', function(e) {

        e.preventDefault()

        let idnoticia = `idnoticia=${$(this).attr('id')}`

        Swal.fire({
            title: 'SysBlog',
            text: 'Deseja realmente excluir esse registro?',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    data: idnoticia,
                    url: 'src/noticia/modelo/delete-noticia.php',
                    success: function(dados) {
                        Swal.fire({ // Inicialização do SweetAlert
                            title: 'SysBlog', // Título da janela SweetAlert
                            text: dados.mensagem, // Mensagem retornada do microserviço
                            type: dados.tipo, // Tipo de retorno [success, info ou error]
                            confirmButtonText: 'OK'
                        })

                        $('#table-noticia').DataTable().ajax.reload()
                    }
                })
            }
        })

    })

})