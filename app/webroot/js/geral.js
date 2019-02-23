//Redirecionar ajax caso não esteja autenticado
 
 
//Duplicar 
function duplicar(url) {
    
    var url = url.replace("*", "");
    bootbox.dialog({
        message: "Deseja realmente duplicar?",
        title: "Atenção!",
        buttons: {
            success: {
                label: "Cancelar",
                className: "btn-info",
                callback: function() {

                }
            },
            danger: {
                label: "Duplicar",
                className: "btn-danger",
                callback: function() {
                    location.href = url;
                }
            }
        }
    });

} 
//Excluir 
function excluir(url) {
    
    var url = url.replace("*", "");
    bootbox.dialog({
        message: "Deseja realmente excluir?",
        title: "Atenção!",
        buttons: {
            success: {
                label: "Cancelar",
                className: "btn-info",
                callback: function() {

                }
            },
            danger: {
                label: "Excluir",
                className: "btn-danger",
                callback: function() {
                    location.href = url;
                }
            }
        }
    });

}
//enviar
function enviar(url) {
    bootbox.dialog({
        message: "Deseja reenviar link de senha por e-mail?",
        title: "Atenção!",
        buttons: {
            success: {
                label: "Cancelar",
                className: "btn-info",
                callback: function() {

                }
            },
            danger: {
                label: "Enviar Senha",
                className: "btn-success",

                callback: function() {
                    location.href = url;
                }
            }
        }
    });

}
function desbloquear( id, url, name) {
    bootbox.dialog({
        message: "Esta análise está sendo utilizada por: " + name + ". Deseja realmente desbloquear?",
        title: "Atenção!",
        buttons: {
            success: {
                label: "Cancelar",
                className: "btn-info",
                callback: function() {

                }
            },
            danger: {
                label: "Desbloquear",
                className: "btn-danger",
                callback: function() {
                    $.get(url, function(data, status){
                            if(status == 'success'){
                                var desbl = '#desblock' + id;
                                $(desbl).attr("src", "/img/icons/desbloqueado.png");
                                $(desbl).parent().removeAttr( "onclick" );
                                $(desbl).removeAttr( "title" );
                                bootbox.alert("Análise desbloqueada com sucesso!");
                            }else{
                                 bootbox.alert("Não foi possível desbloquear!");
                            }
                    });
                   
                }
            }
        }
    });
}
$(document).ready(function() {
    
    $("#adminhide").addClass('glyphicon-chevron-right').removeClass('glyphicon-chevron-down');
            $("#adminmenu").hide();
    $("#adminhide").on('click', function(event) {
        if ($("#adminhide").hasClass('glyphicon-chevron-down')) {
            $("#adminhide").addClass('glyphicon-chevron-right').removeClass('glyphicon-chevron-down');
            $("#adminmenu").hide('slow');
        } else {
            $("#adminhide").addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-right');
            $("#adminmenu").show('slow');
        }
    });
    $("#analisehide").on('click', function(event) {
        if ($("#analisehide").hasClass('glyphicon-chevron-down')) {
            $("#analisehide").addClass('glyphicon-chevron-right').removeClass('glyphicon-chevron-down');
            $("#analisemenu").hide('slow');
        } else {
            $("#analisehide").addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-right');
            $("#analisemenu").show('slow');
        }
    });
    $("#sistemahide").on('click', function(event) {
        if ($("#sistemahide").hasClass('glyphicon-chevron-down')) {
            $("#sistemahide").addClass('glyphicon-chevron-right').removeClass('glyphicon-chevron-down');
            $("#sistemamenu").hide('slow');
        } else {
            $("#sistemahide").addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-right');
            $("#sistemamenu").show('slow');
        }
    });
    $("#relatoriohide").addClass('glyphicon-chevron-right').removeClass('glyphicon-chevron-down');
            $("#relatoriomenu").hide();
    $("#relatoriohide").on('click', function(event) {
        if ($("#relatoriohide").hasClass('glyphicon-chevron-down')) {
            $("#relatoriohide").addClass('glyphicon-chevron-right').removeClass('glyphicon-chevron-down');
            $("#relatoriomenu").hide('slow');
        } else {
            $("#relatoriohide").addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-right');
            $("#relatoriomenu").show('slow');
        }
    });
    $("#loghide").on('click', function(event) {
        if ($("#loghide").hasClass('glyphicon-chevron-down')) {
            $("#loghide").addClass('glyphicon-chevron-right').removeClass('glyphicon-chevron-down');
            $("#logmenu").hide('slow');
        } else {
            $("#loghide").addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-right');
            $("#logmenu").show('slow');
        }
    });

    if ($('#action').val() == 'funcionalidades') {
        if ($('#tipo').val() == '1') {
            $('#dadosmenuanalises').addClass('active');
            $('#assistente').show();
        } else if ($('#tipo').val() == '2') {
            $('#transacaomenuanalises').addClass('active');
            $('#assistente').show();
        }
    } else if ($('#action').val() == 'analises') {
        $('#assistente').hide();
        $('#geralmenuanalises').addClass('active');
    }
    if ($('#action').val() == 'itens') {
        $('#assistente').hide();
        $('#itensmenuanalises').addClass('active');
    }
    if ($('#action').val() == 'documentos') {
        $('#assistente').hide();
        $('#documentos').addClass('active');
    }
    if ($('#action').val() == 'usts') {
        $('#assistente').hide();
        $('#usts').addClass('active');
    }


    $("#checkFuncao").click(function() {
        if ($("#checkFuncao").is(':checked')) {
            $('#functionPesq').fadeIn();
        } else {
            $('#functionPesq').fadeOut();
        }

    });


    $("#messenger").show().delay(3000).fadeOut();

//Desabilitando campos 

    if ($("#metodo_contagem").val() === '2') {

        $("#td_dados").hide();
        $("#tr_dados").hide();
        $("#tr_transacoes").hide();
        $("#ar_transacoes").hide();
    }
    if ($("#AnaliseMetodoContagem3").is(':checked')) {

        $("#transacao").hide();
    } else {
        $("#transacao").show();
    }
    $("#metodo").click(function() {

        if ($("#AnaliseMetodoContagem3").is(':checked')) {

            $("#transacao").hide();
        } else {
            $("#transacao").show();
        }
    }
    );
});