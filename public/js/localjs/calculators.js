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
                        url: baseurl + '/calculator/listAll',
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
                            data: 'category',
                            name: 'category',
                            className: 'text-start'
                        },
                        {
                            data: 'subcategory',
                            name: 'subcategory',
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
    formUrl = baseurl + '/calculators';
  $('#calTitle').val('');
  $('#calSlug').val('');
  $('#calMetaTitle').val('');
  $('#calMetaKeywords').val('');
  $('#calMetaDescription').val('');
  $('#calDesc').val('');
  $('#calContent').val('');
  $('#categoryType').val('');
  $('#subcategoryType').val('');
  $('#subcategoryType').html('');
  editorInstance.calContent.setData('');
  refreshSelect2();
    $('#calculatorForm').attr('action',formUrl);
}

$('#btnAddcalculator').on('click', function()
{
    resetForm();
    populateRelatedCalculators(0);
    $('#calculatorModal').modal('show');
});

$(document).on('keyup blur', '#calTitle', function () {
    const title = $(this).val();
    $('#calSlug').val(slugify(title));
});

$(document).on('click', '.editBtn', function () {
    var id = $(this).attr('data-id');
    var type = 'get';
    var url = baseurl + '/calculators/' + id;
    var data = '';
    SendAjaxRequestToServer(type, url, data, '', function (response) {
        if (response.success) {
            populateSubcategory(response.data.category_id);
            var formUrl = baseurl + '/calculators/' + id;
            $('#calTitle').val(response.data.title);
            $('#calSlug').val(response.data.slug);
            $('#calMetaTitle').val(response.data.meta_title);
            $('#calMetaKeywords').val(response.data.meta_keywords);
            $('#calMetaDescription').val(response.data.meta_description);
            $('#calDesc').val(response.data.description);
            $('#calContent').val(response.data.content);
            $('#categoryType').val(response.data.category_id);
            $('#subcategoryType').val(response.data.subcategory_id);
            editorInstance.calContent.setData(response.data.content);
            refreshSelect2();
            populateRelatedCalculators(id);
            $('#calculatorForm').attr('action', formUrl);
            $('#calculatorModal').modal('show');

        } else {
            toastr.error('Not Found!', 'Error');
        }
    }, '', '');
});

$(document).on('change', '#categoryType', function() {
    var categoryId = $(this).val();
    populateSubcategory(categoryId);
});

function populateRelatedCalculators(calculatorId)
{
    var url = baseurl + '/calculators/' + calculatorId + '/edit';
    var data = '';
    SendAjaxRequestToServer('get', url, data, '', function(response){
        console.log(response);
        if(response.success)
        {
            $('#relatedCalculators').html('');
            if(response.data.length > 0)
            {
                response.data.forEach(function(item){
                    $('#relatedCalculators').append(`<label class="list-group-item">
                            <span class="form-check mb-0">
                              <input class="form-check-input me-4" type="checkbox" name="related_calcs[]" value="${item.id}" />
                              ${item.title}
                            </span>
                          </label>`);
                });

            }else
            {
                $('#relatedCalculators').html(`<div class="list-group-item"><small>Nothing Found!</small></div>`);
            }
        }
    }, '', '');
}

function populateSubcategory(categoryId)
{
    var url = baseurl + '/subcategories/getByCategory/' + categoryId;
    var data = '';
    SendAjaxRequestToServer('get', url, data, '', function(response){
        if(response.success)
        {
            $('#subcategoryType').html('<option value="">Select Subcategory</option>');
            response.data.forEach(function(item){
                $('#subcategoryType').append('<option value="' + item.id + '">' + item.title + '</option>');
            });
        }
    }, '', '');
}