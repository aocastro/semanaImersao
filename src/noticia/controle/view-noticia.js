$(document).ready(function() {

    $('#table-noticia').on('click', 'button.btn-view', function(e) {

        e.preventDefault()

        // Nesta próximas duas linhas será limpo os campos das classes selecionadas para posteiormente elas serem preenchidas de acordo com a necessidade
        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-title').append('<h4 class="text-danger">Visualizar Notícia</h4>')

        let idnoticia = `idnoticia=${$(this).attr('id')}`

        $.ajax({
            type: 'POST',
            dataType: 'json',
            async: true,
            data: idnoticia,
            url: 'src/noticia/modelo/view-noticia.php',
            success: function(dado) {
                if (dado.tipo == "success") {
                    $('.modal-body').load('src/noticia/visao/form-noticia.html', function() {
                        $('#data_noticia').val(dado.dados.data_noticia)
                        $('#data_noticia').attr('readonly', 'true')
                        $('#titulo').val(dado.dados.titulo)
                        $('#titulo').attr('readonly', 'true')
                        $('#corpo').append(dado.dados.corpo)
                        $('#corpo').attr('readonly', 'true')
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: 'src/categoria/modelo/all-categoria.php',
                            success: function(dados) {
                                for (const result of dados) {
                                    if (dado.dados.idcategoria == result.idcategoria)
                                        $('#idcategoria').append(`<option value="${result.idcategoria}">${result.nome}</option>`)
                                }
                            }
                        })
                        $('#idcategoria').attr('readonly', 'true')
                        $('#imagem').after(`<img src="src/noticia/modelo/${dado.dados.imagem}" class="img-thumbnail">`)
                        $('#imagem').hide()
                        $('.btn-save').hide()
                    })

                    $('#modal-noticia').modal('show')
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