let resetImage = baseurl + '/' + 'assets/img/illustrations/blank.png';
function pageLoader()
{
    resetForm();
    let url = baseurl + '/calculator/listAll';
    SendAjaxRequestToServer('get', url, '', '', function (response) {
        $('#calculatorList').html(response.body);
        $('#paginationLinks').html(response.links);
    }, '', '');

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
    $('#uploadedAvatar').attr('src', baseurl + '/' + 'assets/img/illustrations/blank.png');
    resetImage = baseurl + '/' + 'assets/img/illustrations/blank.png';
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
            $('#uploadedAvatar').attr('src', response.data.image ? baseurl + '/' + response.data.image : baseurl + '/' + 'assets/img/illustrations/blank.png');
            resetImage = response.data.image ? baseurl + '/' + response.data.image : baseurl + '/' + 'assets/img/illustrations/blank.png';
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

$(document).on('click', '#paginationLinks a[href]', function (e) {
    e.preventDefault();
    var href = $(this).attr('href');
    SendAjaxRequestToServer('get', href, '', '', function (response) {
        $('#calculatorList').html(response.body);
        $('#paginationLinks').html(response.links);
    }, '', '');
})

$(document).on('change', '#categoryType', function() {
    var categoryId = $(this).val();
    populateSubcategory(categoryId);
});

function populateRelatedCalculators(calculatorId)
{
    var url = baseurl + '/calculators/' + calculatorId + '/edit';
    var data = '';
    SendAjaxRequestToServer('get', url, data, '', function(response){
        if(response.success)
        {
            let relatedArr = response.related;
            $('#relatedCalculators').html('');
            if(response.data.length > 0)
            {
                response.data.forEach(function(item){
                    var checked = relatedArr.some(function(rel) {
                        return rel == item.id;
                    }) ? 'checked' : '';
                    $('#relatedCalculators').append(`<label class="list-group-item">
                            <span class="form-check mb-0">
                              <input class="form-check-input me-4" type="checkbox" ${checked} name="related_calcs[]" value="${item.id}" />
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
