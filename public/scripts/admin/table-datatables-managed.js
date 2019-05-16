var TableDatatablesManaged = function () {

    var initEventsTable = function () {
        var table = $('#events_table');
        table.dataTable({
            order: [[3, "desc"]],
            responsive: true,
            bStateSave: true,
            columnDefs: [
                {orderable: false, targets: [6]},
                {searchable: false, targets: [6]},
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}

            ]
        });
        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });
    };

    var initEditionsTable = function () {
        var table = $('#editions_table');
        table.dataTable({
            order: [[4, "desc"]],
            responsive: true,
            bStateSave: true,
            columnDefs: [
                {orderable: false, targets: [6]},
                {searchable: false, targets: [6]},
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1},
                {responsivePriority: 4, targets: 4}
            ]
        });
    };

    var initRacesTable = function () {
        var table = $('#races_table');
        table.dataTable({
            order: [[0, "desc"]],
            responsive: true,
            bStateSave: true,
            columnDefs: [
                {orderable: false, targets: [3, 4, -1]},
                {searchable: false, targets: [-1]},
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}
            ]
        });
    };

    var initUsersTable = function () {
        var table = $('#users_table');
        table.dataTable({
            order: [[0, "desc"]],
            responsive: true,
            columnDefs: [
                {orderable: false, targets: [5]},
                {searchable: false, targets: [5]},
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 3}

            ]
        });
    };

    var initClubsTable = function () {
        var table = $('#clubs_table');
        table.dataTable({
            order: [[1, "asc"]],
            responsive: true,
            columnDefs: [
                {orderable: false, targets: [6]},
                {searchable: false, targets: [6]},
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}

            ]
        });
    };

    var initSponsorsTable = function () {
        var table = $('#sponsors_table');
        table.dataTable({
            order: [[1, "asc"]],
            responsive: true,
            columnDefs: [
                {orderable: false, targets: [3]},
                {searchable: false, targets: [3]},
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}
            ]
        });
    };

    var initParkRunsTable = function () {
        var table = $('#parkruns_table');
        table.dataTable({
            order: [[1, "asc"]],
            responsive: true,
            columnDefs: [
                {orderable: false, targets: [6]},
                {searchable: false, targets: [6]},
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}
            ]
        });
    };

    // Search  
    var initSearchTable = function () {
        var table = $('#search_table');
        table.dataTable({
            order: [[3, "desc"]],
            responsive: true,
            columnDefs: [
                {orderable: false, targets: [5]},
                {searchable: false, targets: [5]},
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}

            ],
        });
    };

    // Email Que  
    var initEmailQueTable = function () {
        var table = $('#emailques_table');
        table.dataTable({
            order: [[4, "desc"]],
            responsive: true,
            columnDefs: [
                {orderable: false, targets: [-1]},
                {searchable: false, targets: [-1]},
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1},
                {responsivePriority: 4, targets: 4},
                {responsivePriority: 5, targets: 2}

            ],
        });
    };
    
    // Email Templates  
    var initEmailTemplateTable = function () {
        var table = $('#emailtemplates_table');
        table.dataTable({
            order: [[1, "asc"]],
            responsive: true,
            columnDefs: [
                {orderable: false, targets: [-1]},
                {searchable: false, targets: [-1]},
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},

            ],
        });
    };

    // GENERIC list table
    var initListTable = function () {
        var table = $('#list_table');
        table.dataTable({
            order: [[1, "asc"]],
            responsive: true,
            columnDefs: [
                {orderable: false, targets: [-1]},
                {searchable: false, targets: [-1]},
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 1}
            ],
        });
    };


    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initEventsTable();
            initEditionsTable();
            initRacesTable();
            initUsersTable();
            initClubsTable();
            initSponsorsTable();
            initParkRunsTable();
            initSearchTable();
            initEmailQueTable();
            initEmailTemplateTable();
            initListTable();
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function () {
        TableDatatablesManaged.init();
    });
}