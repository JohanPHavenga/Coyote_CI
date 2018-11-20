var TableDatatablesManaged = function () {

    var initEventsTable = function () {

        var table = $('#events_table');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,            
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [6]
                }, 
                {
                    "searchable": false,
                    "targets": [6]
                },
            ],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#events_table_wrapper');

        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });
    }
    
    
    var initEditionsTable = function () {

        var table = $('#editions_table');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },
            
            "responsive": true,

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [5, 10, 20, 50, -1],
                [5, 10, 20, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,            
            "columnDefs": [
                { orderable: false, targets: [6] }, 
                { searchable: false, targets: [6] },
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 },
                { responsivePriority: 3, targets: 1 },
                { responsivePriority: 4, targets: 4 }
                
            ],
//            "order": [
//                [2, "asc"]
//            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#editions_table_wrapper');

    }
    
    
    var initRacesTable = function () {

        var table = $('#races_table');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,            
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [3,5,7]
                }, 
                {
                    "searchable": false,
                    "targets": [7]
                },
            ],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#races_table_wrapper');

    }
    
    
    var initUsersTable = function () {

        var table = $('#users_table');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 20,            
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [5]
                }, 
                {
                    "searchable": false,
                    "targets": [5]
                },
            ],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#users_table_wrapper');

    }
    
    var initClubsTable = function () {

        var table = $('#clubs_table');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,            
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [6]
                }, 
                {
                    "searchable": false,
                    "targets": [0]
                },
            ],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#clubs_table_wrapper');

    }
    
    var initSponsorsTable = function () {

        var table = $('#sponsors_table');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,            
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [3]
                }, 
                {
                    "searchable": false,
                    "targets": [3]
                },
            ],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#sponsors_table_wrapper');

    }
    
    // ASA Members TYPES    
    var initAsaMembersTable = function () {
        var table = $('#asamember_table');
        table.dataTable({
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"] 
            ],
            "pageLength": 10
        });
    }
    
    // Parkruns  
    var initParkRunsTable = function () {
        var table = $('#parkruns_table');
        table.dataTable({
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"] 
            ],
            "pageLength": 10
        });
    }
    
    // Towns  
    var initTownsTable = function () {
        var table = $('#towns_table');
        table.dataTable({
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"] 
            ],
            "pageLength": 10
        });
    }
    
    
    // GENERIC list table
    var initListTable = function () {
        var table = $('#list_table');
        table.dataTable({
            "lengthMenu": [
                [5, 10, 25, -1],
                [5, 10, 25, "All"] 
            ],
            "pageLength": 10
        });
    }    
    

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
            initAsaMembersTable();
            initParkRunsTable();
            initTownsTable();
            initListTable();
        }

    };

}();

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {
        TableDatatablesManaged.init();
    });
}