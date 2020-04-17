$(document).ready(function() {

    $('.btn-view').click(function(e) {

        e.preventDefault()

        var idnoticia = `idnoticia=${$('.btn-view').attr('id')}`

        console.log(idnoticia)

        $('#content').load('src/noticia/visao/view-noticia.html', function() {

            $.ajax({
                type: 'POST',
                dataType: 'json',
                async: true,
                data: idnoticia,
                url: 'src/noticia/modelo/view-noticia.php',
                success: function(dado) {
                    if (dado.tipo == "success") {
                        $('#view-noticia').append(`
                            <h1 class="text-center text-primary">${dado.dados.titulo}</h1>
                            <img class="img-fluid" src="src/noticia/modelo/${dado.dados.imagem}" alt="">
                            <p class="text-justify mt-3">${dado.dados.corpo}</p>
                            <h6>Postado em: ${dado.dados.data_noticia}</h6>
                        `)
                    } else {
                        Swal.fire({ // Inicialização do SweetAlert
                            title: 'SysBlog', // Título da janela SweetAler
                            text: dado.mensagem, // Mensagem retornada do microserviço
                            type: dado.tipo, // Tipo de retorno [success, info ou error]
                            confirmButtonText: 'OK'
                        })
                    }
                }
            })

        })
    })
})