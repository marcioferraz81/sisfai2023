$(document).ready(function () {
    $('a[perguntar]').click(function (ev) {
        var href = $(this).attr('href');
        if (!$('#confirm-perguntar').length) {
            $('body').append('<div class="modal fade" id="confirm-perguntar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header">CONFIRMAÇÃO<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Deseja prosseguir?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button><a class="btn btn-primary text-white" id="dataConfirmOK">Verificar</a></div></div></div></div>');
        }
        $('#dataConfirmOK').attr('href', href);
        $('#confirm-perguntar').modal({show: true});
        return false;

    });
});