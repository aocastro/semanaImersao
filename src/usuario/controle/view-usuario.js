$(document).ready(function() {

    $('#table-usuario').on('click', 'button.btn-view', function(e) {

        e.preventDefault()

        // Nesta próximas duas linhas será limpo os campos das classes selecionadas para posteiormente elas serem preenchidas de acordo com a necessidade
        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-title').append('<h4 class="text-danger">Visualizar Usuário</h4>')

        let idusuario = `idusuario=${$(this).attr('id')}`

        $.ajax({
            type: 'POST',
            dataType: 'json',
            async: true,
            data: idusuario,
            url: 'src/usuario/modelo/view-usuario.php',
            success: function(dado) {
                if (dado.tipo == "success") {
                    $('.modal-body').load('src/usuario/visao/form-usuario.html', function() {
                        $('#nome').val(dado.dados.nome)
                        $('#nome').attr('readonly', 'true')
                        $('#email').val(dado.dados.email)
                        $('#email').attr('readonly', 'true')
                        $('#senha').val(dado.dados.senha)
                        $('#senha').attr('readonly', 'true')
                        $('#tipo_usuario').empty()
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: 'src/tipo_usuario/modelo/all-tipo_usuario.php',
                            success: function(dados) {
                                for (const result of dados) {
                                    if (dado.dados.idtipo_usuario == result.idtipo_usuario)
                                        $('#tipo_usuario').append(`<option value="${result.idtipo_usuario}">${result.nome}</option>`)
                                }
                            }
                        })
                        $('#tipo_usuario').attr('readonly', 'true')
                    })
                    $('.btn-save').hide()
                    $('#modal-usuario').modal('show')
                } else {
                    Swal.fire({ // Inicialização do SweetAlert
                        title: 'SysBlog', // Título da janela SweetAlert
                        text: dado.mensagem, // Mensagem retornada do microserviço
                        type: dado.tipo, // Tipo de retorno [success, info ou error]
                        confirmButtonText: 'OK'
                    })
                }
            }
        })

    })
})