function pageLoader() {
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
        toastr.success(response.message || 'Operation Successful', 'Success');
        $('.modal.show').modal('hide');
        $('.offcanvas.show').hideOffcanvas();
        if (response.goto) {
            window.location = response.goto;
        } else {

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

// Trigger file input when button clicked
document.getElementById('uploadBtn').addEventListener('click', function () {
    document.getElementById('logoInput').click();
});
document.getElementById('uploadFaviconBtn').addEventListener('click', function () {
    document.getElementById('faviconInput').click();
});
document.getElementById('logoInput').addEventListener('change', function (event) {
    if (event.target.files && event.target.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('previewLogo').src = e.target.result;
        }
        reader.readAsDataURL(event.target.files[0]);
        $('#imagesForm').submit();
    }
});
document.getElementById('faviconInput').addEventListener('change', function (event) {
    if (event.target.files && event.target.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('previewFavicon').src = e.target.result;
        }
        reader.readAsDataURL(event.target.files[0]);
        $('#imagesForm').submit();
    }
});

// Remove button reset
document.getElementById('removeBtn').addEventListener('click', function () {
    document.getElementById('previewLogo').src = baseurl + "/assets/img/illustrations/blank.png";
    document.getElementById('logoInput').value = "";
    removeSetting('header_logo');
});
document.getElementById('removeFaviconBtn').addEventListener('click', function () {
    document.getElementById('previewFavicon').src = baseurl + "/assets/img/illustrations/blank.png";
    document.getElementById('faviconInput').value = "";
    removeSetting('favicon');
});

function removeSetting(name) {
    let url = baseurl + '/settings/website/remove-setting';
    let type = 'POST';
    let data = new FormData();
    data.append('name', name);
    SendAjaxRequestToServer(type, url, data, '', function (response) {
        if (response.success) {
            toastr.success('Setting Removed', 'Success');
            // pageLoader();
        } else {
            toastr.error(response.msg, 'Error');
        }
    }, '', '');
}