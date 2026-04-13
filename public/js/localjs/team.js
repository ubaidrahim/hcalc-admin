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
            url: baseurl + '/teams/listAll',
            // data: {
            //   filterAgentId: filterAgentId,
            //   filterAgentName: filterAgentName,
            //   filterType: filterType,
            //   daterange: daterange
            // },
            // pages: 5 // number of pages to cache
            dataSrc: function (json) {
                // You can access the totalRecords here
                var totalRecords = json.recordsTotal;
                console.log(json);
                $('#countTotal').text(
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
            data: 'image',
            name: 'image',
            className: 'text-start'
        },
        {
            data: 'name',
            name: 'name',
            className: 'text-start'
        },
        {
            data: 'designation',
            name: 'designation',
            className: 'text-start'
        },
        {
            data: 'brief',
            name: 'brief',
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
    formUrl = baseurl + '/team'
    $('#memberName').val('');
    $('#memberDesignation').val('');
    $('#upload').val('');
    $('#uploadedAvatar').attr('src', baseurl + '/' + 'assets/img/avatars/1.png');
    resetImage = baseurl + '/' + 'assets/img/avatars/1.png';
    $('#removeImg').attr('data-id','0');
    $('#memberBrief').val('');
    $('#memberfacebook').val('');
    $('#memberlinkedin').val('');
    $('#membergithub').val('');
    $('#memberwhatsapp').val('');
    $('#memberinstagram').val('');
    $('#memberbehance').val('');
    $('#memberyoutube').val('');
    $('#memberupwork').val('');
    $('#memberfiverr').val('');
    $('#membertiktok').val('');
    $('#memberportfolio').val('');
    $('#removeImg').addClass('d-none');
    $('#categoryForm').attr('action', formUrl);
}

$('#btnAddCategory').on('click', function () {
    resetForm();
    $('#categoryModal').modal('show');
});
$(document).on('click', '.editBtn', function () {
    var id = $(this).attr('data-id');
    var type = 'get';
    var url = baseurl + '/team/' + id;
    var data = '';
    SendAjaxRequestToServer(type, url, data, '', function (response) {
        if (response.success) {
            $('#removeImg').removeClass('d-none');
            var formUrl = baseurl + '/team/' + id;
            $('#memberName').val(response.data.name);
            $('#memberDesignation').val(response.data.designation);
            $('#upload').val('');
            $('#uploadedAvatar').attr('src',baseurl + '/' + response.data.image);
            resetImage = baseurl + '/' + response.data.image;
            $('#removeImg').attr('data-id',id);
            $('#memberBrief').val(response.data.brief);
            $('#memberfacebook').val(response.data.facebook);
            $('#memberlinkedin').val(response.data.linkedin);
            $('#membergithub').val(response.data.github);
            $('#memberwhatsapp').val(response.data.whatsapp);
            $('#memberinstagram').val(response.data.instagram);
            $('#memberbehance').val(response.data.behance);
            $('#memberyoutube').val(response.data.youtube);
            $('#memberupwork').val(response.data.upwork);
            $('#memberfiverr').val(response.data.fiverr);
            $('#membertiktok').val(response.data.tiktok);
            $('#memberportfolio').val(response.data.portfolio);
            $('#categoryForm').attr('action', formUrl);
            $('#categoryModal').modal('show');

        } else {
            toastr.error('Not Found!', 'Error');
        }
    }, '', '');
});

$(document).on('click', '.iconMenu > i', function () {
    let selectClass = $(this).attr('class');
    $('#selectedIcon i').attr('class', selectClass);
    $('#iconInput').val(selectClass);
});

$(document).on('click', '#removeImg',function(){
    let id = $(this).attr('data-id');
    if(id > 0)
    {
        var type = 'post';
        var url = baseurl + '/teams/remove-image/' + id;
        var data = '';
        SendAjaxRequestToServer(type, url, data, '', function (response) {
            if (response.success) {
                toastr.success('Image removed successfuly','Success');
                $('.account-image-reset').trigger('click');

            } else {
                toastr.error(response.message, 'Error');
            }
        }, '', '');
    }
    else
    {
        toastr.error('Data not saved.','Error');
    }
});

