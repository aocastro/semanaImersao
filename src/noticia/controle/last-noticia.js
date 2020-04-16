$(document).ready(function() {

    $.ajax({
        type: 'POST',
        dataType: 'json',
        assync: true,
        url: 'src/noticia/modelo/last-noticia.php',
        success: function(dados) {
            for (const dado of dados) {
                $('#last-noticia').append(`
                    <div class="col-md-6 col-12 mt-3">
                        <img class="img-fluid" src="src/noticia/modelo/${dado.imagem}">
                        <h6>${dado.data_noticia}</h6>
                        <h3>${dado.titulo}</h3>
                        <h6>${dado.categoria}</h6>
                        <p>${dado.corpo.substring(0, 200)}...</p>
                        <button id="${dado.idnoticia}" class="btn btn-primary btn-sm btn-view"><i class="mdi mdi-plus-circle"></i> Ler mais...</button>
                    </div>
                `)
            }
        }
    })

})