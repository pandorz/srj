
app.pagesController = app.pagesController || {};
app.pagesController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    
    calendar : function () {

        $('#calendar').fullCalendar({
            theme: false,
            locale: 'fr',
            header: {
                left: '',
                center: 'prev,title,next',
                right: ''
            },
            defaultDate: getDataAttr(new Date()),
            navLinks: false,
            //eventLimit: true, // allow "more" link when too many events
            displayEventTime: false,
            dayNamesShort: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            viewRender: function(view, element) {
                showEventsonDays();
            },
            events: events
        });
        showEventsonDays();

        function showEventsonDays() {
            for (var i = 0; i < events.length; i++) {
                var evStartDate = new Date(events[i].start),
                    evTitle = events[i].title,
                    evUrl = events[i].url;
                // var evFinishDate = new Date(events[i].end);
                // if (events[i].end) {
                //     while (evStartDate <= evFinishDate) {
                //         addClassByDate(evStartDate);
                //         evStartDate.setDate(evStartDate.getDate() + 1);
                //     }
                // } else {
                    addClassByDate(evStartDate, evTitle, evUrl);
                // }
            }
        }

        function addClassByDate(date, title, url) {
            var dataAttr = getDataAttr(date),
                $dayCell = $("[data-date='" + dataAttr + "']"),
                eventHtml;
                if (url != undefined) {
                    eventHtml = '<span class="my-fc-event-title"><a href="'+url+'">'+title+'</a></span>';
                }
                else {
                    eventHtml = '<span class="my-fc-event-title">'+title+'</span>';
                }
            $dayCell.addClass("hasEvent");
            if ($dayCell.find('.my-fc-event-ctn').length < 1) {
                $dayCell.append('<div class="my-fc-event-ctn"></div>');
            }
            $dayCell.find('.my-fc-event-ctn').append(eventHtml);
        }

        function getDataAttr(date) {
            return date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + (date.getDate().toString().length === 2 ? date.getDate() : "0" + date.getDate());
        };
    },
        
};

$(document).ready(function(){
    
    // Home
    if ($('.home #calendar')) {
        app.pagesController.defaultAction.calendar();
    }
});
            