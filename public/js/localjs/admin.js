let resetImage = baseurl + '/' + 'assets/img/illustrations/blank.png';
function pageLoader() {
    resetForm();
    let url = baseurl + '/settings/admins/listAll';
    SendAjaxRequestToServer('get', url, '', '', function (response) {
        $('#adminList').html(response.body);
        $('#paginationLinks').html(response.links);
    }, '', '');

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
    formUrl = baseurl + '/settings/admin';
    $('.password_field').removeClass('d-none');
    $('#adminName').val('');
    $('#adminEmail').val('');
    $('#adminEmail').prop('disabled',false);
    $('#adminPassword').val('');
    $('#adminConfirmPassword').val('');
    $('#adminPassword').prop('disabled', false);
    $('#adminConfirmPassword').prop('disabled', false);
    $('#adminRole').val('');
    $('#upload').val('');
    $('#changePass').val('');
    $('#changeConfirmPass').val('');
    $('#passId').val('0');
    $('#uploadedAvatar').attr('src', baseurl + '/' + 'assets/img/illustrations/blank.png');
    resetImage = baseurl + '/' + 'assets/img/illustrations/blank.png';
    $('#adminForm').attr('action', formUrl);
}

$('#btnAddAdmin').on('click', function () {
    resetForm();
    $('#adminModal').modal('show');
});

$(document).on('click', '.changepass', function () {
    let id = $(this).data('id');
    $('#passId').val(id);
    $('#changePass').val('');
    $('#changeConfirmPass').val('');
    $('#changePasswordModal').modal('show');
});
$(document).on('click', '.editBtn', function () {
    var id = $(this).attr('data-id');
    var type = 'get';
    var url = baseurl + '/settings/admin/' + id;
    var data = '';
    SendAjaxRequestToServer(type, url, data, '', function (response) {
        if (response.success) {
            var formUrl = baseurl + '/settings/admin/' + id;
            $('.password_field').addClass('d-none');
            $('#adminName').val(response.data.name);
            $('#adminEmail').val(response.data.email);
            $('#adminEmail').prop('disabled',true);
            $('#adminPassword').val('');
            $('#adminConfirmPassword').val('');
            $('#adminPassword').prop('disabled',true);
            $('#adminConfirmPassword').prop('disabled',true);
            $('#adminRole').val(response.data.designation);
            $('#upload').val('');
            $('#uploadedAvatar').attr('src', response.data.image ? baseurl + '/' + response.data.image : baseurl + '/' + 'assets/img/illustrations/blank.png');
            resetImage = response.data.image ? baseurl + '/' + response.data.image : baseurl + '/' + 'assets/img/illustrations/blank.png';
            
            $('#adminForm').attr('action', formUrl);
            $('#adminModal').modal('show');

        } else {
            toastr.error('Not Found!', 'Error');
            resetForm();
        }
    }, '', '');
});

$(document).on('click', '#paginationLinks a[href]', function (e) {
    e.preventDefault();
    var href = $(this).attr('href');
    SendAjaxRequestToServer('get', href, '', '', function (response) {
        $('#adminList').html(response.body);
        $('#paginationLinks').html(response.links);
    }, '', '');
})

/**
 * Account Settings - Account
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        const deactivateAcc = document.querySelector('#formAccountDeactivation');

        // Update/reset user image of account page
        let accountUserImage = document.getElementById('uploadedAvatar');
        const fileInput = document.querySelector('.account-file-input'),
            resetFileInput = document.querySelector('.account-image-reset');

        if (accountUserImage) {
            fileInput.onchange = () => {
                if (fileInput.files[0]) {
                    accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                }
            };
            resetFileInput.onclick = () => {
                fileInput.value = '';
                accountUserImage.src = resetImage;
            };
        }
    })();
});
