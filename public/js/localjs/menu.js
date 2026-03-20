function pageLoader()
{
    // $('#menuSelect').val('');
    // $('#menuItems').html('');
    appendMenu = $('#menuItems');
    // appendMenu = $('#menuItems > .accordion-item .nested-menu');
    initNestedSortable(appendMenu);
    updateNestedFields(appendMenu);
    $('#menuItems > .accordion-item .nested-menu').each(function(){
        let list = $(this);
        initNestedSortable(list);
        updateNestedFields(list);
    });
}

$('form').on('submit', function (e) {
    e.preventDefault();
    var form = $(this)[0];
    var submit_btn = $(this).find('button[type="submit"]');
    let menu = $('#menuSelect').val();
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
    console.log(response);
    if (response.success) {
        toastr.success('Operation Successful', 'Success');
        window.location.href = response.goto;
    } else {
        toastr.error(response.message, 'Error');
    }
}
$(document).on('click','.addType',function(){
    let type = $(this).attr('data-type');
    let menu = $('#menuSelect').val();
    if(!menu)
    {
        toastr.error('No menu selected. Please choose menu first.','Error');
        return;
    }
    let appendMenu = $('#menuItems');
    let countItems = $('#menuItems .menuitem').length;
    let parent = 0;
    if ($('#menuItems .accordion-item.active .nested-menu').length) {
        appendMenu = $('#menuItems > .accordion-item.active .nested-menu');
        parent = $('#menuItems > .accordion-item.active').attr('data-index');
    }
    var url = baseurl + '/settings/menu/add-item';
    let formData = new FormData();
    formData.append('type',type);
    formData.append('count',countItems);
    formData.append('parent',parent);
    SendAjaxRequestToServer('post', url, formData, '', function (response) {
        if(response.success)
        {
            
            appendMenu.append(response.data);
            refreshSelect2();

            if (appendMenu.data('ui-sortable')) {
                appendMenu.sortable('destroy');
            }
            initNestedSortable(appendMenu);

            updateNestedFields(appendMenu);
        }
    }, '', '');
});

$(document).on('change','#menuSelect',function(){
    let val = $(this).val();
    let url = baseurl + '/settings/menu';
    $('#saveMenuBtn').addClass('d-none');
    if(val && val != '')
    {
        url = url + '/' + val;

        $('#saveMenuBtn').removeClass('d-none');
    }
    window.location.href = url;
});

$(document).on('change','.itemTitle',function(){
    let text = $(this).val();
    let btn = $(this).closest('.menuitem').find('.menubtn');
    btn.text(text);
});

function initNestedSortable(appendMenu) {
    appendMenu.sortable({
        handle: '.item-wrap',          // was '.accordion-header
        update: function (event, ui) {
            updateNestedFields($(this));
        }
    });
}
function updateNestedFields(root) {
    // let root = $('#menuItems');
    // if ($('#menuItems > .accordion-item.active .nested-menu').length)
    // {
    //     root = $('#menuItems > .accordion-item.active .nested-menu');
    // }
        root.children('li.menuitem').each(function (index) {
            let $item = $(this);

            $item.find('.item-order').first().val(index + 1);
        });
    
}

$(document).on('click','.remove-menuitem',function(){
    let menuitem = $(this).closest('.menuitem');
    menuitem.addClass('d-none');
    menuitem.find('input.item-remove').val(1);
});