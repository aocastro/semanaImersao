$(document).ready(function() {

    $('.btn-save').click(function(e) {

        e.preventDefault()

        let dados = $('#form-tipo_usuario').serialize()

        dados += `&operacao=${$('.btn-save').attr('data-operation')}`

        $.ajax({
            type: 'POST',
            dataType: 'json',
            assync: true,
            data: dados,
            url: 'src/tipo_usuario/modelo/save-tipo_usuario.php',
            success: function(dados) {
                Swal.fire({
                    title: 'SysBlog',
                    text: dados.mensagem,
                    type: dados.tipo,
                    confirmButtonText: 'OK'
                })
                $('#modal-tipo-usuario').modal('hide')
            }
        })

    })

})