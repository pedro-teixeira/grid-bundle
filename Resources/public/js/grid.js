!function ($) {

    /* GRID PUBLIC CLASS DEFINITION
     * ================================= */


    var Grid = function (element, options) {
        this.$element = $(element)
        this.options = $.extend({}, $.fn.grid.defaults, options)
        this.ajaxUrl = this.options.ajaxUrl || this.ajaxUrl
        this.exportFlag = false
        this.listen()
        this.ajax()
    }

    Grid.prototype = {

        constructor:Grid

        , ajax:function () {

            var filters = this.$element.find('form').serializeArray(),
                tbody = this.$element.find('table').find('tbody.row-result'),
                emptyTbody = this.$element.find('table').find('tbody.row-empty'),
                thisClass = this;

            $.ajax({
                url:this.ajaxUrl,
                type:'get',
                data:{
                    'export': this.exportFlag,
                    'filters': filters
                },
                dataType:'json',
                beforeSend:function (data) {
                    thisClass.gridLock()
                },
                success:function (data) {

                    thisClass.gridUnlock()

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

                    alert('Error: ' + error.message)
                }
            })

            return this
        }

        , listen:function () {
            this.$element.find('form').on('submit', $.proxy(this.submit, this))
            this.$element.find('select').on('change', $.proxy(this.ajax, this))

            $('#refresh-button').on('click', $.proxy(this.ajax, this))
            $('#refresh-filters-button').on('click', $.proxy(this.refreshFilters, this))
            $('#export-button').on('click', $.proxy(this.export, this))

            return this
        }

        , submit:function () {
            this.ajax()

            return false
        }

        , refreshFilters:function () {
            this.$element.find('form')[0].reset()
            this.ajax()

            return this
        }

        , export:function () {
            this.exportFlag = true
            this.ajax()

            return this
        }

        , gridLock:function () {
            this.$element.find('input, select, textarea, button')
            this.$element.attr('disabled', true)
            this.$element.css({opacity:0.5});

            return this
        }

        , gridUnlock:function () {
            this.$element.find('input, select, textarea, button')
            this.$element.attr('disabled', false)
            this.$element.css({opacity:1});

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
        ajaxUrl:false
    }

    $.fn.grid.Constructor = Grid

}(window.jQuery)