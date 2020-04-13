$(document).ready(function() {
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
})