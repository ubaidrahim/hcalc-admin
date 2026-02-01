function pageLoader()
{
    resetForm();
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
                        url: baseurl + '/category/listAll',
                        // data: {
                        //   filterAgentId: filterAgentId,
                        //   filterAgentName: filterAgentName,
                        //   filterType: filterType,
                        //   daterange: daterange
                        // },
                        // pages: 5 // number of pages to cache
                        dataSrc: function(json) {
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
                            data: 'title',
                            name: 'title',
                            className: 'text-start'
                        },
                        // department
                        {
                            data: 'description',
                            name: 'description',
                            className: 'text-start'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            className: 'text-start'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            className: 'text-start'
                        },
                    ],
                    lengthMenu: [5, 10, 25, 50, 75, 100]
                });

}

$('form').on('submit',function(e){
        e.preventDefault();
        var form = $(this)[0];
        var submit_btn = $(this).find('button[type="submit"]');
        submit_btn.prop('disabled', true);
        if(!form.checkValidity()){
            form.reportValidity();
            submit_btn.prop('disabled',false);
            return false;
        }else{
            // submit_btn.prop('disabled', true);
            let url = $(this).attr('action');
            let type = $(this).attr('method');
            let data = new FormData(form);
            SendAjaxRequestToServer(type, url, data, '', formSaved, submit_btn, submit_btn);
            // form.submit();
        }
    });
    function formSaved(response){
        if(response.success){
            toastr.success('Operation Successful','Success');
            $('.modal.show').modal('hide');
            $('.offcanvas.show').hideOffcanvas();
            pageLoader();
        }else{
            toastr.error(response.message,'Error');
        }
    }

function resetForm()
{
  formUrl = baseurl + '/categories'
    $('#cattitle').val('');
    $('#catDesc').val('');
    $('#catContent').val('');
    $('#catslug').val('');
    $('#metatitle').val('');
    $('#metakeywords').val('');
    $('#metadescription').val('');
    editorInstance.catContent.setData('');
    $('#categoryForm').attr('action',formUrl);
}

$('#btnAddCategory').on('click', function()
{
    resetForm();
    $('#categoryModal').modal('show');
});

function slugify(text) {
    return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/\s+/g, '-')        // spaces → -
        .replace(/[^\w\-]+/g, '')    // remove non-word chars
        .replace(/\-\-+/g, '-')      // multiple - → single -
        .replace(/^-+/, '')          // trim - from start
        .replace(/-+$/, '');         // trim - from end
}

$(document).on('keyup blur', '#cattitle', function () {
    const title = $(this).val();
    $('#catslug').val(slugify(title));
});
$(document).on('click','.editBtn',function(){
    var id = $(this).attr('data-id');
    var type = 'get';
    var url = baseurl + '/categories/'+id;
    var data = '';
    SendAjaxRequestToServer(type, url, data, '', function(response){
        if(response.success)
        {
            var formUrl = baseurl + '/categories/' + id ;
            $('#cattitle').val(response.data.title);
            $('#catDesc').val(response.data.description);
            $('#catslug').val(response.data.slug);
            $('#metatitle').val(response.data.meta_title);
            $('#metakeywords').val(response.data.meta_keywords);
            $('#metadescription').val(response.data.meta_description);
            editorInstance.catContent.setData(response.data.content);
            $('#categoryForm').attr('action', formUrl);
            $('#categoryModal').modal('show');
            
        }else
        {
            toastr.error('Not Found!','Error');
        }
    }, '', '');
});

