!function ($) {

    /* GRID PUBLIC CLASS DEFINITION
     * ================================= */


    var Grid = function (element, options) {
        this.$element = $(element)
        this.options = $.extend({}, $.fn.grid.defaults, options)
        this.ajaxUrl = this.options.ajaxUrl || this.ajaxUrl
        this.limit = this.options.limit || this.limit
        this.exportFlag = false
        this.sortIndex = ''
        this.sortOrder = 'ASC'
        this.page = 1
        this.totalRows = 0
        this.totalPages = 0
        this.listen()
        this.ajax()
    }

    Grid.prototype = {

        constructor:Grid

        , ajax:function () {

            var filters = this.$element.find('form').serializeArray(),
                tbody = this.$element.find('table').find('tbody.row-result'),
                emptyTbody = this.$element.find('table').find('tbody.row-empty'),
                thisClass = this

            this.page = this.$element.find('#pagination #pagination-page').val()
            this.limit = this.$element.find('#pagination #pagination-limit').val()

            $.ajax({
                url:this.ajaxUrl,
                type:'get',
                data:{
                    'page':this.page,
                    'limit':this.limit,
                    'sort': this.sortIndex,
                    'sort_order': this.sortOrder,
                    'export': (this.exportFlag ? 1 : 0),
                    'filters': filters
                },
                dataType:'json',
                timeout: (this.exportFlag ? (5*60*1000) : (10 * 1000)),
                beforeSend:function (data) {
                    thisClass.gridLock()
                },
                success:function (data) {
                    thisClass.gridUnlock()

                    if (data.file_hash) {
                        window.location = thisClass.ajaxUrl + '?export=1&file_hash=' + data.file_hash
                        return
                    }

                    thisClass.page = data.page
                    thisClass.limit = data.page_limit
                    thisClass.totalRows = data.row_count
                    thisClass.totalPages = data.page_count

                    thisClass.paginationProcess()

                    var html = ''

                    if (data.rows.length > 0) {
                        emptyTbody.hide()
                        $.each(data.rows, function (i, item) {
                            html += '<tr>'
                            $.each(item, function (i, value) {
                                if (value == null) {
                                    value = ''
                                }

                                html += '<td>' + value + '</td>'
                            })
                            html += '</tr>'
                        })
                    } else {
                        emptyTbody.show()
                    }

                    tbody.html(html)
                },
                error:function (error) {
                    thisClass.gridUnlock()

                    emptyTbody.show()
                    tbody.html('')

                    alert('Error: ' + error.statusText)
                }
            })

            return this
        }

        , listen:function () {
            this.$element.find('form').on('submit', $.proxy(this.submit, this))
            this.$element.find('select').on('change', $.proxy(this.ajax, this))

            this.$element.find('#refresh-button').on('click', $.proxy(this.ajax, this))
            this.$element.find('#refresh-filters-button').on('click', $.proxy(this.refreshFilters, this))
            this.$element.find('#export-button').on('click', $.proxy(this.export, this))
            this.$element.find('#row-filters-label th').on('click', $.proxy(this.processOrder, this))

            this.$element.find('#pagination-back-button').on('click', $.proxy(this.paginationBack, this))
            this.$element.find('#pagination-forward-button').on('click', $.proxy(this.paginationForward, this))

            return this
        }

        , submit:function () {
            this.ajax()

            return false
        }

        , refreshFilters:function () {

            $.each(this.$element.find('form'), function (i, form) {
                form.reset()
            })

            $.each(this.$element.find('.date-input'), function (i, input) {
                $(input).removeAttr('value')
            })

            this.ajax()

            return this
        }

        , export:function () {
            this.exportFlag = true
            this.ajax()
            this.exportFlag = false

            return this
        }

        , gridLock:function () {
            this.$element.find('input, select, textarea, button').attr('disabled', true)
            this.$element.css({opacity:0.5});

            return this
        }

        , gridUnlock:function () {
            this.$element.find('input, select, textarea, button').attr('disabled', false)
            this.$element.css({opacity:1});

            return this
        }

        , processOrder:function (event) {

            var element = $(event.target)
                sortIndex = element.data('index')

            if (!sortIndex) {
                return false
            }

            if (this.sortIndex == sortIndex) {
                if (this.sortOrder == 'DESC') {
                    this.sortOrder = 'ASC'
                } else {
                    this.sortOrder = 'DESC'
                }
            } else {
                this.sortOrder = 'ASC'
                this.sortIndex = sortIndex
            }

            this.processOrderIcon(element)

            this.ajax()

            return this
        }

        , processOrderIcon:function (element) {
            $.each(this.$element.find('#row-filters-label th i'), function(i, item) {
                item.remove()
            })

            if (this.sortOrder == 'DESC') {
                element.append(' <i class="icon-chevron-down"></i>')
            } else {
                element.append(' <i class="icon-chevron-up"></i>')
            }

            return this
        }

        , paginationProcess:function () {

            this.$element.find('#pagination #pagination-back-button').attr('disabled', false)
            this.$element.find('#pagination #pagination-forward-button').attr('disabled', false)

            if (this.page <= 1) {
                this.$element.find('#pagination #pagination-back-button').attr('disabled', true)
            }

            if (this.page >= this.totalPages) {
                this.$element.find('#pagination #pagination-forward-button').attr('disabled', true)
            }

            this.$element.find('#pagination #pagination-page').val(this.page)
            this.$element.find('#pagination #pagination-total-pages').html(this.totalPages)
            this.$element.find('#pagination #pagination-total').html(this.totalRows)
            this.$element.find('#pagination #pagination-limit').val(this.limit)

            this.$element.find('#pagination input').attr('disabled', false)

            return this
        }

        , paginationBack:function () {
            this.page --
            this.$element.find('#pagination #pagination-page').val(this.page)

            this.ajax()

            return this
        }

        , paginationForward:function () {
            this.page ++
            this.$element.find('#pagination #pagination-page').val(this.page)

            this.ajax()

            return this
        }
    }

    /* GRID PLUGIN DEFINITION
     * =========================== */

    $.fn.grid = function (option) {
        return this.each(function () {
            var $this = $(this)
                , data = $this.data('grid')
                , options = typeof option == 'object' && option

            if (!data) $this.data('grid', (data = new Grid(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    $.fn.grid.defaults = {
        ajaxUrl:false,
        limit:20
    }

    $.fn.grid.Constructor = Grid

}(window.jQuery)