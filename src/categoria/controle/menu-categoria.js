$(document).ready(function() {

    $.ajax({
        type: 'POST',
        dataType: 'json',
        assync: true,
        url: 'src/categoria/modelo/all-categoria.php',
        success: function(dados) {
            for (const dado of dados) {
                $('#menu-categoria').append(`<a class="dropdown-item" id="${dado.idcategoria}">${dado.nome}</a>`)
            }
        }
    })

})