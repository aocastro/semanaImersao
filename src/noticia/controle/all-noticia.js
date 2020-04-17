$(document).ready(function() {

    $.ajax({
        type: 'POST',
        dataType: 'json',
        assync: true,
        url: 'src/noticia/modelo/all-noticia.php',
        success: function(dados) {
            for (const dado of dados) {
                $('#all-noticia').append(`
                    <h5 class="border-top mt-2">
                    ${dado.data_noticia} - ${dado.titulo}
                    </h5>
                    <p class="text-justify">
                        ${dado.corpo.substring(0, 255)} 
                        <button id="${dado.idnoticia}" class="btn btn-primary btn-sm btn-view"><i class="mdi mdi-plus-circle"></i> Ler mais</button>
                    </p>
                `)
            }
            $('body').append(`<script src="src/noticia/controle/view-external-noticia.js"></script>`)
        }
    })
})