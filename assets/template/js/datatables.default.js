
$.extend( $.fn.dataTable.defaults, {
bProcessing: true,
        bServerSide: true,
        iDisplayStart:0,
        fnServerData: function(sSource, aoData, fnCallback) {
            aoData.push( { "name": "csrf_app_name", "value": $.cookie('csrf_app_cookie_name') } );
            $.ajax ({
                'dataType': 'json',
                'type'    : 'POST',
                'url'     : sSource,
                'data'    : aoData,
                'success' : fnCallback
            });
        },
        language: {
            "oPaginate": {
                "sFirst": "Pierwsza",
                "sLast": "Ostatnia",
                "sNext": "Następna",
                "sPrevious": "Poprzednia"
            },
            "sProcessing": "Pobieranie danych z serwera...",
            "sZeroRecords": "Brak danych",
            "sLengthMenu": "Wyświetl _MENU_ rekordów na stronie",
            "sEmptyTable": "Brak dostępnych rekordów",
            "sInfo": "Wszystkich rekordów: _TOTAL_ (_START_ do _END_)",
            "sInfoEmpty": "Brak dostępnych rekordów",
            "sInfoFiltered": " (odfiltrowane z _MAX_ rekordów)",
            "sSearch": "Szukaj ",
            "sLoadingRecords": "Proszę czekać - ładowanie..."
        },
        "order": [[ 0, "asc" ]],
        "lengthMenu": [[10, 25, 50, 100, 5000], [10, 25, 50, 100, "Wszystko"]],
} );
