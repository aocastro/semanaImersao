$(document).ready(function() {

    $('.btn-new').click(function(e) {

        e.preventDefault()

        $('.modal-title').empty()
        $('.modal-body').empty()

        $('.modal-title').append('<h4 class="text-danger">Novo Tipo de Usuário</h4>')

        $('.modal-body').load('src/tipo_usuario/visao/form-tipo-usuario.html')

        $('.btn-save').attr('data-operation', 'insert')

        $('#modal-tipo-usuario').modal('show')

        $('body').append('<script src="src/tipo_usuario/controle/save-tipo_usuario.js"></script>')

    })
})