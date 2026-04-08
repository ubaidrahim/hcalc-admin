function pageLoader() {
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
            url: baseurl + '/site-script/listAll',
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
            data: 'name',
            name: 'name',
            className: 'text-start'
        },
        // department
        {
            data: 'type',
            name: 'type',
            className: 'text-start'
        },
        {
            data: 'placement',
            name: 'placement',
            className: 'text-start'
        },
        {
            data: 'config_json',
            name: 'config_json',
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

$('form').on('submit', function (e) {
    e.preventDefault();
    var form = $(this)[0];
    var submit_btn = $(this).find('button[type="submit"]');
    submit_btn.prop('disabled', true);
    if (!form.checkValidity()) {
        form.reportValidity();
        submit_btn.prop('disabled', false);
        return false;
    } else {
        // submit_btn.prop('disabled', true);
        let url = $(this).attr('action');
        let type = $(this).attr('method');
        let data = new FormData(form);
        SendAjaxRequestToServer(type, url, data, '', formSaved, submit_btn, submit_btn);
        // form.submit();
    }
});
function formSaved(response) {
    if (response.success) {
        toastr.success('Operation Successful', 'Success');
        $('.modal.show').modal('hide');
        $('.offcanvas.show').hideOffcanvas();
        pageLoader();
    } else {
        toastr.error(response.message, 'Error');
    }
}

function resetForm() {
    $('#scriptName').val('');
    $('#scriptType').val('');
    $('#scriptPlace').val('');
    $('#gtagId').val('');
    $('#gmtId').val('');
    $('#adsenseClientId').val('');
    $('#metaTagName').val('');
    $('#metaTagValue').val('');
    $('#externalUrlSrc').val('');
    $('.typeinput').addClass('d-none');
    $('.typeinput').find('input').prop('disabled',true);
    $('#scriptMsg').html('');
}

$('.addBtn').on('click', function () {
    let type = $(this).attr('data-type');
    resetForm();
    if(type == 'gtag' || type == 'gtm' || type == 'adsense')
    {
        var url = baseurl + '/site-script/search/' + type;
        var data = '';
        SendAjaxRequestToServer('get', url, data, '', function (response) {
            if (response.success) {
                $('#scriptName').val(response.data.name);
                $('#scriptType').val(response.data.type);
                $('#scriptPlace').val(response.data.placement);
                $(`.typeinput[data-type="${response.data.type}"]`).removeClass('d-none');
                $(`.typeinput[data-type="${response.data.type}"]`).find('input').prop('disabled', false);
                $('#scriptForm').attr('action',`${baseurl}/sitescripts/${response.data.id}`);
                let scriptMsg = `<span class="alert alert-primary" role="alert">The <em>"${response.data.type}"</em> script is already found on website. You can edit it from below form.</span>`;
                $('#scriptMsg').html(scriptMsg);
                $('#scriptModalLabel').text(`Edit ${type} Script`);
                switch (response.data.type) {
                    case 'gtag':
                        $('#gtagId').val(response.data.config_json.measurement_id);
                        break;
                    case 'gmt':
                        $('#gmtId').val(response.data.config_json.measurement_id);
                        break;
                    case 'adsense':
                        $('#adsenseClientId').val(response.data.config_json.client_id);
                        break;
                    case 'meta_tag':
                        $('#metaTagName').val(response.data.config_json.meta_name);
                        $('#metaTagValue').val(response.data.config_json.meta_value);
                        break;
                    case 'external_src':
                        $('#externalUrlSrc').val(response.data.config_json.url_source);
                        break;
                
                    default:
                        break;
                }
            } else {
                resetForm()
                $('#scriptType').val(type);
                $('#scriptForm').attr('action', `${baseurl}/sitescripts`);
                $(`.typeinput[data-type="${type}"]`).removeClass('d-none');
                $(`.typeinput[data-type="${type}"]`).find('input').prop('disabled', false);
                $('#scriptModalLabel').text(`Add ${type} Script`);
            }
        }, '', '');
    }else{
        resetForm()
        $('#scriptType').val(type);
        $('#scriptForm').attr('action', `${baseurl}/sitescripts`);
        $(`.typeinput[data-type="${type}"]`).removeClass('d-none');
        $(`.typeinput[data-type="${type}"]`).find('input').prop('disabled', false);
        $('#scriptModalLabel').text(`Add ${type} Script`);
    }
    $('#scriptModal').modal('show');
});
$(document).on('click', '.editBtn', function () {
    var id = $(this).attr('data-id');
    var type = 'get';
    var url = baseurl + '/sitescripts/' + id;
    var data = '';
    SendAjaxRequestToServer(type, url, data, '', function (response) {
            if (response.success) {
                $('#scriptName').val(response.data.name);
                $('#scriptType').val(response.data.type);
                $('#scriptPlace').val(response.data.placement);
                $(`.typeinput[data-type="${response.data.type}"]`).removeClass('d-none');
                $(`.typeinput[data-type="${response.data.type}"]`).find('input').prop('disabled', false);
                $('#scriptForm').attr('action',`${baseurl}/sitescripts/${response.data.id}`);
                let scriptMsg = `<span class="alert alert-primary" role="alert">The <em>"${response.data.type}"</em> script is already found on website. You can edit it from below form.</span>`;
                $('#scriptMsg').html(scriptMsg);
                $('#scriptModalLabel').text(`Edit ${response.data.type} Script`);
                config = JSON.parse(response.data.config_json);
                switch (response.data.type) {
                    case 'gtag':
                        $('#c').val(config.measurement_id);
                        break;
                    case 'gmt':
                        $('#c').val(config.measurement_id);
                        break;
                    case 'adsense':
                        $('#c').val(config.client_id);
                        break;
                    case 'meta_tag':
                        $('#c').val(config.meta_name);
                        $('#c').val(config.meta_value);
                        break;
                    case 'external_src':
                        $('#c').val(config.url_source);
                        break;
                
                    default:
                        break;
                }
                $('#scriptMsg').html('');
                $('#scriptModal').modal('show');
            } else {
                toastr.error('Not Found!','Error');
            }
        }, '', '');
});

$(document).on('click', '.iconMenu > i', function () {
    let selectClass = $(this).attr('class');
    $('#selectedIcon i').attr('class', selectClass);
    $('#iconInput').val(selectClass);
});

