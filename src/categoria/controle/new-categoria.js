// Inicialiando o arquivo JavaScript com a leitura dos elementos do documento HTML
$(document).ready(function() {
    // Na linha abaixo selecionamos o elemnto do nosso HTML que tem a classe 'btn-new' e monitoramos o clique do mouse sobre ele
    $('.btn-new').click(function(e) {
        // A função preventDefault() trabalha atuando em cima de limpar as funcionalidades do elemento que está sendo monitorado o click
        e.preventDefault()

        // Nesta próximas duas linhas será limpo os campos das classes selecionadas para posteiormente elas serem preenchidas de acordo com a necessidade
        $('.modal-title').empty()
        $('.modal-body').empty()

        // Aqui iremos deternimar qual será o título que deverá aparecer no nosso modal
        $('.modal-title').append('<h4 class="text-danger">Nova categoria</h4>')

        // Aqui será inserido o formulário do arquivo que criamos anteriomente na pasta visão onde ficam nossos HTML
        $('.modal-body').load('src/categoria/visao/form-categoria.html')

        // Uma vez que nosso Back-end aguarda os dados do formulário porém também qual o tipo de operação, iremos incluir no botão de salvar uma nova propriedade
        // onde será incluído uma nova propiedade chamada data-operation que não tem aplicação prática em função alguma, porém será útil para
        // demontrar qual operação desejamos realizar com os dados do formulário dentro do modal
        $('.btn-save').attr('data-operation', 'insert')

        // Por fim iremos apresentar o modal na tela
        $('#modal-categoria').modal('show')
    })
})