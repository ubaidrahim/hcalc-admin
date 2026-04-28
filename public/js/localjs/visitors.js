function pageLoader() {
    let url = baseurl + '/visitors/listAll';
    SendAjaxRequestToServer('get', url, '', '', function(response){
        $('#visitorList').html(response.body);
        $('#paginationLinks').html(response.links);
    }, '', '');

}

$(document).on('click', '#paginationLinks a[href]',function(e){
    e.preventDefault();
    var href = $(this).attr('href');
    SendAjaxRequestToServer('get', href, '', '', function (response) {
        $('#visitorList').html(response.body);
        $('#paginationLinks').html(response.links);
        $('html, body').animate({
            scrollTop: $('#visitorList').parent('table').offset().top
        }, 600);
    }, '', '');
});