$(function () {
    $(document).ready(function () {

        if (typeof pageLoader === "function") {
            pageLoader();
        }

        $('.preloader').fadeOut('slow');
    });
});

let baseurl = $('#baseUrl').val();
//Setup AJAX requests to include CSRF
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

//Record Deletion Confirmation modal
$(document).on('click', '.delete_record', function () {
    let url = $(this).attr('data-url');
    $('#confirm_delete_form').attr('action', url);
    $('#confirm_popup').modal('show');
});

$('.close_confirm').on('click', function () {
    $('#confirm_popup').modal('hide');
});
 
//Method to handle AJAX Request
function SendAjaxRequestToServer(
    requestType = "GET",
    url,
    data,
    dataType = "json",
    callBack = "",
    spinner_button = '',
    submit_button = ''
) {
    // console.log(data, url, dataType);
    $.ajax({
        type: requestType,
        url: url,
        data: data,
        dataType: dataType,
        contentType: 'application/json',
        processData: false,
        contentType: false,
        beforeSend: function (response) {
            $('.preloader').show();
            if (spinner_button != '') {
                $(spinner_button).toggle();
            }
            if (submit_button != '') {
                $(submit_button).attr('disabled', true);
            }
            // $(submit_button).toggle();
        },
        success: function (response) {
            $('.preloader').hide();
            if (typeof callBack === "function") {
                callBack(response);
            } else {
                console.log("error");
            }
        },
        complete: function (data) {
            $('.preloader').hide();
            if (spinner_button != '') {
                $(spinner_button).toggle();
            }
            if (submit_button != '') {
                $(submit_button).attr('disabled', false);
            }
        },
        error: function (xhr) {
            $('.preloader').hide();
            if (submit_button != '') {
                $(submit_button).attr('disabled', false);
            }
            if (xhr.status === 422) {

                let responseJSON = JSON.parse(xhr.responseText);
                $.each(responseJSON.errors, function (key, val) {
                    toastr.error(val[0], 'Error');
                    $("#" + key).addClass('is-invalid');

                });
            }
            else if (xhr.status === 419) {

                toastr.error('Your session has expired. Please refresh the page and login again');
            } else {
                console.log(xhr);
            }
        },
    });
}

//Status Change
$(document).on("change", ".status_enable_disable",function () {
    let t = $(this).is(":checked") ? 1 : 0;
    let e = $(this).val(),
        i = { id: e, table: $("#table_name").val(), status: t };
    $('.preloader').show();
    $.ajax({
        type: "GET",
        data: i,
        dataType: "json",
        url: baseurl + "/status-enable-disable",
        success: function (A) {
            if (A.warning) {
                toastr.warning(A.warning, "Warning");
            } else if (A.success) {
                toastr.success(A.success, "Success");
            } else if (A.error) {
                toastr.error(A.error, "Error");
            }
            $('.preloader').hide();
        },
        error: function (A, t, e) {
            $('.preloader').hide();
            console.error(A);
        },
    });
});

//Datable caching & Setup for AJAX source
$.fn.dataTable.pipeline = function (opts) {
    // Configuration options
    var conf = $.extend({
        pages: 5, // number of pages to cache
        url: '', // script url
        data: null, // function or object with parameters to send to the server
        // matching how `ajax.data` works in DataTables
        method: 'GET' // Ajax HTTP method
    }, opts);
    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;
    return function (request, drawCallback, settings) {
        var ajax = false;
        var requestStart = request.start;
        var drawStart = request.start;
        var requestLength = request.length;
        var requestEnd = requestStart + requestLength;

        if (settings.clearCache) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
            // outside cached data - need to make a request
            ajax = true;
        } else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
            JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
            JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }

        // Store the request for checking next time around
        cacheLastRequest = $.extend(true, {}, request);

        if (ajax) {
            // Need data from the server
            if (requestStart < cacheLower) {
                requestStart = requestStart - (requestLength * (conf.pages - 1));

                if (requestStart < 0) {
                    requestStart = 0;
                }
            }
            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);

            request.start = requestStart;
            request.length = requestLength * conf.pages;

            // Provide the same `data` options as DataTables.
            if (typeof conf.data === 'function') {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data(request);
                if (d) {
                    $.extend(request, d);
                }
            } else if ($.isPlainObject(conf.data)) {
                // As an object, the data given extends the default
                $.extend(request, conf.data);
            }

            return $.ajax({
                "type": conf.method,
                "url": conf.url,
                "data": request,
                "dataType": "json",
                "cache": false,
                "success": function (json) {
                    cacheLastJson = $.extend(true, {}, json);

                    if (cacheLower != drawStart) {
                        json.data.splice(0, drawStart - cacheLower);
                    }
                    if (requestLength >= -1) {
                        json.data.splice(requestLength, json.data.length);
                    }

                    drawCallback(json);
                }
            });
        } else {
            var json = $.extend(true, {}, cacheLastJson);
            json.draw = request.draw; // Update the echo for each response
            json.data.splice(0, requestStart - cacheLower);
            json.data.splice(requestLength, json.data.length);

            drawCallback(json);
        }
    }
};

//CKEditor 5 Instance Initialize
let editorInstance = {};
function initializeCkEditor() {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    $('.custom-ckeditor').each(function () {
        var elId = $(this).attr('id');
        var url = $("#url").val();
        var customFontFam = ['Arial', 'Helvetica', 'Cavolini', 'Jost', 'Impact', 'Tahoma', 'Verdana',
            'Garamond', 'Georgia', 'monospace', 'fantasy', 'Papyrus', 'Poppins'
        ];
        if (!editorInstance.hasOwnProperty(elId)) {
            ClassicEditor
                .create(document.getElementById(elId), {
                    ckfinder: {
                        uploadUrl: url + "/ckeditor/upload?_token=" + csrfToken
                    },
                    mediaEmbed: {
                        previewsInData: true,
                        removeProviders: ['instagram', 'twitter', 'googleMaps', 'flickr', 'facebook'],
                    },
                    fontSize: {
                        options: [
                            9,
                            11,
                            13,
                            'default',
                            17,
                            19,
                            21
                        ]
                    },
                    fontFamily: {
                        options: customFontFam
                    },
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'link',
                            'bulletedList',
                            'numberedList',
                            '|',
                            'blockQuote',
                            'fontFamily',
                            'fontSize',
                            'fontColor',
                            'alignment',
                            'outdent',
                            'indent',
                            '|',
                            'insertTable',
                            // 'imageInsert',
                            'imageUpload',
                            'mediaEmbed',
                            //	'CKFinder',
                            //	'codeBlock',
                            '|',
                            'undo',
                            'redo'
                        ]
                    },
                    language: 'en',
                    image: {
                        toolbar: [
                            'imageTextAlternative',
                            'imageStyle:inline',
                            'imageStyle:block',
                            'imageStyle:side'
                        ],
                        insert: {
                            // This is the default configuration, you do not need to provide
                            // this configuration key if the list content and order reflects your needs.
                            integrations: ['upload', 'url']
                        }
                    },
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells'
                        ]
                    }
                })
                .then(editor => {
                    // Save the editor instance to use it later
                    let base_url = $('#url').val();
                    window.editor = editor;
                    editorInstance[elId] = editor;
                    // Listen to the change:data event
                    editor.model.document.on('change:data', () => {
                        const editorData = editor.getData();

                        // Update the textarea with the editor content
                        $(this).val(editorData);
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });
}

initializeCkEditor();

function openCanvas() {
    document.getElementById('addCanvas').classList.add('show');
    document.getElementById('canvasBackdrop').classList.add('show');
}

function closeCanvas() {
    $('.canvas-panel.show').each(function(){
        $(this).removeClass('show');
    });
    document.getElementById('canvasBackdrop').classList.remove('show');
}

//Offcanvas show hide
$.fn.showOffcanvas = function () {
    const offcanvas = new bootstrap.Offcanvas(this[0]);
    offcanvas.show();
    return this;
};

$.fn.hideOffcanvas = function () {
    // Loop through each matched element
    this.each(function () {
        // Get the existing Bootstrap Offcanvas instance for each element
        const offcanvasInstance = bootstrap.Offcanvas.getInstance(this);

        // If an instance exists, hide it
        if (offcanvasInstance) {
            offcanvasInstance.hide();
        }
    });
    return this; // Maintain jQuery chaining
};

$('.select2').each(function () {
    let $el = $(this);
    let parentSelector = $el.data('parent');
    let options = {
        placeholder: $el.data('placeholder'),
        width: '100%'
    };

    // If data-parent exists and element is found
    if (parentSelector && $(parentSelector).length) {
        options.dropdownParent = $(parentSelector);
    }
    // Else if inside a modal, auto-detect
    else if ($el.closest('.modal').length) {
        options.dropdownParent = $el.closest('.modal');
    }

    $el.select2(options);
});

function refreshSelect2(){
    $('.select2').trigger('change');
}

// $('.nice-select').niceSelect();

$(document).on('click','.logoutUser',function(){
    // let base_url = $('#baseUrl').val();
    let url = baseurl + '/logout';
    let type = 'POST';
    let submit_btn = '';
    let data = new FormData();
    SendAjaxRequestToServer(type, url, data, '', function(response){
        if(response.status == 1){
            toastr.success('Logout Successful!','Success');
            window.location = response.goto;
        }
    }, submit_btn, submit_btn);
});

function formatDate(dateString) {
    const months = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];

    const date = new Date(dateString);
    const day = date.getDate().toString().padStart(2, '0');
    const monthNo = date.getMonth().padStart(2, '0');
    const month = months[date.getMonth()];
    const year = date.getFullYear();

    return `${day}/${monthNo}/${year}`;
}
function formatTime(timeString) {
    // Split the time string into components
    var timeParts = timeString.split(':');
    
    // Extract hours and minutes
    var hours = timeParts[0];
    var minutes = timeParts[1];
    
    // Return the formatted time
    return hours + ':' + minutes;
}

function formatTime1(timeString) {
    // Parse the time part from the given string
    var timePart = timeString.split('T')[1].split(':');
    
    // Extract hours and minutes
    var hours = parseInt(timePart[0], 10);
    var minutes = timePart[1];
    
    // Determine AM/PM
    var period = hours >= 12 ? 'pm' : 'am';
    
    // Convert to 12-hour format
    hours = hours % 12 || 12; // Converts 0 to 12 for midnight
    
    // Return the formatted time
    return hours + ':' + minutes + ' ' + period;
}

// Export all fields from server side for datatable
function exportAllAction(e, dt, button, config, actionFn) {
    var oldStart = dt.page.info().start;
    var oldLength = dt.page.len();
    var spinner = $('.export-dropdown').find('.export-spinner');
    var exporttext = $('.export-dropdown').find('.export-text');
    var btns = $('.export-dropdown').find('button');
    spinner.removeClass('d-none');
    exporttext.addClass('d-none');
    dt.one('preDraw', function (e, settings) {
        // Run the built-in export action (Excel or PDF)
        actionFn.call(self, e, dt, button, config);

        // Hide spinner + show success
        spinner.addClass('d-none');
        exporttext.removeClass('d-none');
        toastr.success("Export completed successfully!");

        // Restore page length
        dt.one('preDraw', function (e, settings) {
            settings._iDisplayStart = oldStart;
            dt.page.len(oldLength);
        });

        // Reload original page without resetting pagination
        setTimeout(function () {
            dt.ajax.reload(null, false);
        }, 0);

        // 🚫 Cancel rendering of the "all records" page (prevents distortion)
        return false;
    });

    // Ask server for all records (length = -1 must be supported by server-side script)
    dt.page.len(-1).draw();
}

$('#daterange').daterangepicker({
    startDate: moment().subtract(12, 'months').startOf('day'),
    endDate: moment().endOf('day'),
    opens: 'left',
    locale: {
        format: $('#momentDateFormat').val()
    },
    ranges: {
        'Today': [moment().startOf('day'), moment().endOf('day')],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'Last 12 Months': [moment().subtract(12, 'months').startOf('day'), moment().endOf('day')],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
});