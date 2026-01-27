function pageLoader()
{
    resetForm();
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
        if(response.goto)
        {
            window.location = response.goto;
        }else{

            pageLoader();
        }
    } else {
        toastr.error(response.message, 'Error');
    }
}
function resetForm() {
    $('form').each(function () {
        this.reset();
    });
}