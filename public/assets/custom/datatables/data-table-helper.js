var DataTableHelper = function (element, url, options) {

    var self = this, ajaxParams = {}, onBeforeLoad, onSuccess, onLoad, onError, onDraw;

    self.instance = null;
    self.ajax = null;
    self.dataTable = null;
    self.paging = true;
    self.pageLength = 25;
    self.pagingType = 'bootstrap_extended';

    self.info = true;
    self.showFilters = true;
    self.columns = null;

    // var defaultOptions = {
    // }
    // options = $.extend(true, defaultOptions, options);


    var hiddenField = element + '_TEMP_FIELD';
    var sortColumn = [];

    var orderableColumnList = [];

    this.onBeforeLoad = function (callback) {
        //console.log('onBeforeLoad');
        onBeforeLoad = callback;
    }

    this.onLoad = function (callback) {
        //console.log('onLoad');
        onLoad = callback;
    }

    this.onSuccess = function (callback) {
        //console.log('onSuccess');
        onSuccess = callback;
    }

    this.onError = function (callback) {
        //console.log('onError');
        onError = callback;
    }

    this.showErrorMessage = function( message ) {
        app.alert({
            type: 'danger',
            icon: 'warning',
            message: message,
            container: self.instance.getTableWrapper(),
            place: 'prepend'
        });
    }

    this.showSuccessMessage = function (message) {
        app.alert({
            type: 'success',
            icon: 'check',
            message: message,
            container: self.instance.getTableWrapper(),
            place: 'prepend'
        });
    }


    this.init = function () {

        // onBeforeLoad
        if (onBeforeLoad) {
            onBeforeLoad();
        }
        // console.log(hiddenField);
        // custom hidden field for ajax // ADNAN::
        if (hiddenField && $(hiddenField).length == 0) {
            var $hiddenInput = $('<input/>', {type: 'hidden', id: hiddenField.substr(1), value: ''});
            $hiddenInput.appendTo('body');
        }

        self.instance = new Datatable();
        var options = {

            src: $(element),

            onSuccess: function (grid, response) {
                // onSuccess
                if (onSuccess) {
                    onSuccess(response, grid);
                }
            },

            onError: function (grid) {
                if (onError) {
                    onError(grid);
                }
            },

            onDataLoad: function (grid, s) {

                // hiding filters
                if ( !self.showFilters ) {
                    $(element).find('tr.filter').hide();
                }

                if (onLoad) {
                    onLoad(s, grid);
                }
            },

            loadingMessage: 'Loading...',

            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
                // So when dropdowns used the scrollable div should be removed.
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
                
                "language": { // language settings
                    "metronicGroupActions": "_TOTAL_ records selected:  ",
                    "metronicAjaxRequestGeneralError": "Server Error. Please Try Again",
                    // "info": 'Showing _TOTAL_ of _TOTAL_ entries'
                },
                "dom": "<'row'<'col-md-8 col-sm-12'><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r><t><'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>", // datatable layout
                "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.

                "lengthMenu": [
                    [25, 50, 100],
                    [25, 50, 100] // change per page values here
                ],

                "pageLength": 25, // default record count per page

                "ajax": {
                    "url": url, // ajax source
                    "type": "POST", // request type
                    "data": function (data) {

                        app.blockUI({
                            message: self.instance.loadingMessage,
                            target: self.instance.gettableContainer(),
                            overlayColor: 'none',
                            centerY: true,
                            boxed: true
                        });

                        // parent class
                        var filterAjaxParams = self.instance.getAjaxParams();
                        $.each(filterAjaxParams, function (key, value) {
                            data[key] = value;
                        });

                        // this class
                        $.each(ajaxParams, function (key, value) {
                            data[key] = value;
                        });

                        var customData = $(hiddenField).val();
                        if (customData) {
                            var json = JSON.parse(customData);
                            $.each(json, function (key, value) {
                                data[key] = value;
                            });
                        }

                        return data;
                    },

                    "beforeSend": function () {
                        //$('.alert').fadeOut();
                    },
                    // }::

                },

                "columnDefs": orderableColumnList,

                // default sort column
                "order": sortColumn
            }
        };

        if (onDraw) {
            options.onDraw = onDraw;
        }

        options.dataTable.paging = self.paging;
        options.dataTable.bPaginate = self.paging;
        options.dataTable.bFilter = self.filters;
        options.dataTable.pageLength = self.pageLength;
        options.dataTable.pagingType = self.pagingType;
        options.bInfo = self.info;
        if ( self.columns ) {
            options.dataTable.columns = self.columns;
        }

        options.dataTable.dom = "<'row'<'col-md-12 col-sm-12'><'table-group-actions'>r><t><'row'<'col-md-12 col-sm-12'pli><'col-md-4 col-sm-12'>>";
        if ( !self.paging ) {
            // hiding total # of record found when paging is disabled
            options.custom = {
             "noInfo": true
            };
        }
        self.instance.init(options);
        self.dataTable = self.instance.getDataTable();
    }

    this.setSortColumn = function( colIndex, direction) {
        sortColumn = [];
        direction = typeof direction == 'undefined' ? 'asc' : direction;
        sortColumn.push ( [ colIndex, direction ] );
    }

    this.setOrderableColumnList = function( colIndex, isOrderable ) {
        orderableColumnList = [{
            'orderable': isOrderable,
            'targets': colIndex
        }];
        return self;
    }

    this.setAjaxParam = function (name, value) {
        ajaxParams[name] = value;
        return self;
    }

    this.setAjaxUrl = function (url) {
        self.instance.getDataTable().ajax.url(url);
        return self;
    }

    this.invisibleColumn = function (is_instant, column) {
        if( is_instant === 'instant'){
            self.instance.getDataTable().column(column).visible(1);
        }else{
            self.dataTable.column(column).visible(0);
        }
        return self;
    }

    this.clearAjaxParam = function () {
        ajaxParams = {};
        $(hiddenField).val('');
        return self;
    }

    this.reload = function (jsAjaxParams) {
        if (typeof jsAjaxParams == 'object') {
            //alert( jsAjaxParams ); TODO:: IN PROGRESS
        }
        $(hiddenField).val(JSON.stringify(ajaxParams));
        self.instance.getDataTable().ajax.reload(null, false);
        return self;
    }

    this.download = function (url, params) {
        var gridParams = xGrid.ajax.params();
        if (typeof params != 'undefined' && params) {

            if (typeof params == 'string') {
                // converting query string to object
                var vars = params.split("&");
                params = {};
                for (var i = 0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    pair[0] = decodeURIComponent(pair[0]);
                    pair[1] = decodeURIComponent(pair[1]);
                    // If first entry with this name
                    if (typeof params[pair[0]] === "undefined") {
                        params[pair[0]] = pair[1];
                        // If second entry with this name
                    } else if (typeof params[pair[0]] === "string") {
                        var arr = [params[pair[0]], pair[1]];
                        params[pair[0]] = arr;
                        // If third or later entry with this name
                    } else {
                        params[pair[0]].push(pair[1]);
                    }
                }
            }
            console.log(params);
            if (typeof params == 'object') {
                $.each(params, function (key, value) {
                    gridParams[key] = value;
                });
            }
        }
        var newForm = jQuery('<form>', {
            'action': url,
            'method': 'post',
            'target': '_top'
        }).append(jQuery('<input>', {
            'name': 'jsonForm',
            'value': JSON.stringify(gridParams),
            'type': 'hidden'
        })).append(jQuery('<input>', {
            'name': '_token',
            'value': $('meta[name="csrf-token"]').attr('content'),
            'type': 'hidden'
        }));
        newForm.submit();
    }

}