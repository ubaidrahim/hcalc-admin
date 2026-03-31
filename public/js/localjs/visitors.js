function pageLoader() {
    dataTableInstance = $('#tableid').DataTable({
        bLengthChange: true,
        // remove search box
        bFilter: false,
        "bDestroy": true,
        "lengthChange": true,
        responsive: true,
        ordering: false,
        dom: 'Blrtip',
        pageLength: 25,
        processing: true,
        serverSide: true,
        buttons: [{
            extend: 'excelHtml5',
            text: 'Export CSV',
            className: 'exportCsv d-none', // Add a custom class to reference in JS
            exportOptions: {
                columns: ':not(.no-export)',
            }
        },
        {
            extend: 'pdfHtml5',
            text: 'Export PDF',
            className: 'exportPdf d-none', // Add a custom class to reference in JS
            exportOptions: {
                columns: ':not(.no-export)',
            }
        },
        ],
        "ajax": {
            url: baseurl + '/visitors/listAll',
            // data: {
            //   filterAgentId: filterAgentId,
            //   filterAgentName: filterAgentName,
            //   filterType: filterType,
            //   daterange: daterange
            // },
            // pages: 5 // number of pages to cache
            dataSrc: function (json) {
                // You can access the totalRecords here
                var totalRecords = json.totalRecords;
                console.log(json);
                $('.count-title').text(
                    totalRecords); // Assuming you have an element with id 'total-records'
                return json.data; // Return the actual data to DataTable
            }
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'id',
            className: 'text-start',
            orderable: true
        },
        {
            data: 'visitorid',
            name: 'visitorid',
            className: 'text-start'
        },
        // department
        {
            data: 'ipaddress',
            name: 'ipaddress',
            className: 'text-start'
        },
        {
            data: 'city',
            name: 'city',
            className: 'text-start'
        },
        {
            data: 'country',
            name: 'country',
            className: 'text-start'
        },
        {
            data: 'pageviews',
            name: 'pageviews',
            className: 'text-start'
        },
        {
            data: 'calculations',
            name: 'calculations',
            className: 'text-start'
        },
        {
            data: 'createdat',
            name: 'createdat',
            className: 'text-start'
        },
        {
            data: 'lastactivity',
            name: 'lastactivity',
            className: 'text-start'
        },
        ],
        lengthMenu: [5, 10, 25, 50, 75, 100]
    });

}