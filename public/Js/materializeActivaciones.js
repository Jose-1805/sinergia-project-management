$(function(){
    inicializarMaterializacss();
})

function inicializarMaterializacss(){
    $('.modal-trigger').leanModal();
    $(".dropdown-button").dropdown();
    $('select').material_select();
    $("ul.tabs").tabs();
    $('input#input_text, textarea#textarea1').characterCounter();
    $('.materialboxed').materialbox();
    while($(".material-tooltip").length != 0) {
        $('.material-tooltip').each(function (index) {
            $('.material-tooltip').eq(index).remove();
        })
    }
    $('.tooltipped').tooltip({delay: 50});
}