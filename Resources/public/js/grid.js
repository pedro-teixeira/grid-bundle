!function ($) {

    /* GRID PUBLIC CLASS DEFINITION
     * ================================= */


    var Grid = function (element, options) {
        this.$element = $(element)
        this.options = $.extend({}, $.fn.grid.defaults, options)
        this.ajaxUrl = this.options.ajaxUrl || this.ajaxUrl
        this.listen()
        this.ajax()
    }

    Grid.prototype = {

        constructor:Grid

        , ajax:function () {

            var filters = this.$element.find('form').serializeArray(),
                tbody = this.$element.find('table').find('tbody')

            $.ajax({
                url:this.ajaxUrl,
                type:'get',
                data:{
                    'filters': filters
                },
                dataType:'json',
                success:function (data) {

                    var html = ''

                    $.each(data.rows, function (i, item) {
                        html += '<tr>'
                        $.each(item, function(i, value) {
                            if (value == null) {
                                value = ''
                            }

                            html += '<td>' + value + '</td>'
                        })
                        html += '</tr>'
                    })

                    tbody.html(html)
                },
                error:function (error) {
                    alert('Error: ' + error.message)
                }
            })

            return this
        }

        , listen:function () {
            this.$element.find('form').on('submit', $.proxy(this.submit, this))
            this.$element.find('select').on('change', $.proxy(this.submit, this))

            return this
        }

        , submit:function () {
            this.ajax()

            return false
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