$(document).ready( function () {
        
    $('#tabela_registros').dataTable({
        "paging": false,
        "sort":false,
        "scrollY": 250,
        "bJQueryUI": true,
        "responsive": true,
        "sPaginationType": "full_numbers"
    });

});