$(document).ready(function() {
    // Início das funcionalidades do menu - Painel Gerencial

    $('#tipo-usuario').click(function() {
        $('#conteudo').empty()
        $('#conteudo').load('src/tipo_usuario/visao/list-tipo-usuario.html')
    })

    $('#usuario').click(function() {
        $('#conteudo').empty()
        $('#conteudo').load('src/usuario/visao/list-usuario.html')
    })

    $('#categoria').click(function() {
        $('#conteudo').empty()
        $('#conteudo').load('src/categoria/visao/list-categoria.html')
    })

    $('#noticia').click(function() {
        $('#conteudo').empty()
        $('#conteudo').load('src/noticia/visao/list-noticia.html')
    })

    // Fim das funcionalidades do menu - Painel Gerencial


    // Aqui inicia as funcionalidades do menu do BLOG
    $('#content').load('src/noticia/visao/last-noticia.html')

    $('#initial').click(function() {
        $('#content').load('src/noticia/visao/last-noticia.html')
    })

    $('#news').click(function() {
        $('#content').load('src/noticia/visao/all-noticia.html')
    })

    $('#subscript').click(function() {
        $('#content').load('src/usuario/visao/form-usuario.html', function() {
            $('#form-usuario').before(`<h1 class="text-center mt-4">Cadastro de Leitor</h1>`)
            $('#tipo_usuario').after(`<input type="hidden" name="idtipo_usuario" value="2">`)
            $('#tipo_usuario').after(`<button type="button" class="btn btn-primary btn-save"><i class="mdi mdi-content-save"></i> Salvar mudanças</button>`)
            $('#lbTipo').hide()
            $('#tipo_usuario').hide()
            $('.btn-save').attr('data-operation', 'insert')
        })
        $('body').append(`<script src="src/usuario/controle/save-usuario.js"></script>`)
    })
})