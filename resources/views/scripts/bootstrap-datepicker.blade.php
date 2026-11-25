<script type="module">
    $.extend(true, $.fn.datepicker, {
        dates: {
            custom: {
                days: [
                    @json(__('datetime-pickers.days.sunday')),
                    @json(__('datetime-pickers.days.monday')),
                    @json(__('datetime-pickers.days.tuesday')),
                    @json(__('datetime-pickers.days.wednesday')),
                    @json(__('datetime-pickers.days.thursday')),
                    @json(__('datetime-pickers.days.friday')),
                    @json(__('datetime-pickers.days.saturday'))
                ],
                daysShort: [
                    @json(__('datetime-pickers.daysShort.sun')),
                    @json(__('datetime-pickers.daysShort.mon')),
                    @json(__('datetime-pickers.daysShort.tue')),
                    @json(__('datetime-pickers.daysShort.wed')),
                    @json(__('datetime-pickers.daysShort.thu')),
                    @json(__('datetime-pickers.daysShort.fri')),
                    @json(__('datetime-pickers.daysShort.sat'))
                ],
                daysMin: [
                    @json(__('datetime-pickers.daysMin.su')),
                    @json(__('datetime-pickers.daysMin.mo')),
                    @json(__('datetime-pickers.daysMin.tu')),
                    @json(__('datetime-pickers.daysMin.we')),
                    @json(__('datetime-pickers.daysMin.th')),
                    @json(__('datetime-pickers.daysMin.fr')),
                    @json(__('datetime-pickers.daysMin.sa'))
                ],
                months: [
                    @json(__('datetime-pickers.months.january')),
                    @json(__('datetime-pickers.months.february')),
                    @json(__('datetime-pickers.months.march')),
                    @json(__('datetime-pickers.months.april')),
                    @json(__('datetime-pickers.months.may')),
                    @json(__('datetime-pickers.months.june')),
                    @json(__('datetime-pickers.months.july')),
                    @json(__('datetime-pickers.months.august')),
                    @json(__('datetime-pickers.months.september')),
                    @json(__('datetime-pickers.months.october')),
                    @json(__('datetime-pickers.months.november')),
                    @json(__('datetime-pickers.months.december'))
                ],
                monthsShort: [
                    @json(__('datetime-pickers.monthsShort.jan')),
                    @json(__('datetime-pickers.monthsShort.feb')),
                    @json(__('datetime-pickers.monthsShort.mar')),
                    @json(__('datetime-pickers.monthsShort.apr')),
                    @json(__('datetime-pickers.monthsShort.may')),
                    @json(__('datetime-pickers.monthsShort.jun')),
                    @json(__('datetime-pickers.monthsShort.jul')),
                    @json(__('datetime-pickers.monthsShort.aug')),
                    @json(__('datetime-pickers.monthsShort.sep')),
                    @json(__('datetime-pickers.monthsShort.oct')),
                    @json(__('datetime-pickers.monthsShort.nov')),
                    @json(__('datetime-pickers.monthsShort.dec'))
                ],
                today: @json(__('datetime-pickers.today')),
                clear: @json(__('datetime-pickers.clear')),
                weekStart: 0,
                format: @json(config('app.date_format_javascript'))
            }
        },
        defaults: {
            language: 'custom',
            orientation: 'bottom left',
            autoclose: true
        }
    });
</script>
