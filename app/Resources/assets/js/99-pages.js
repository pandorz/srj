
app.pagesController = app.pagesController || {};
app.pagesController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    
    calendar : function () {

        if (typeof events !== "undefined") {
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
        }

        function showEventsonDays() {
            for (var i = 0; i < events.length; i++) {
                var evStartDate = new Date(events[i].start),
                    evEndDate = new Date(events[i].end),
                    evTitle = events[i].title,
                    evUrl = events[i].url;
                addClassByDate(evStartDate, evEndDate, evTitle, evUrl);
            }
        }

        function addClassByDate(date, dateEnd, title, url) {
            var eventDates = [];
            // if it is a date
            if (Object.prototype.toString.call(dateEnd) === "[object Date]") {
                // if date is valid
                if ( !isNaN( dateEnd.getTime() ) ) {
                    while (date <= dateEnd) {
                        eventDates.push(new Date(date));
                        date.setDate(date.getDate() + 1);
                    }
                }
                else eventDates = [date];
            }
            eventDates.forEach(function(d){
                var dataAttr = getDataAttr(d),
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
            });

        }

        function getDataAttr(date) {
            var day = date.getDate();
            var month = date.getMonth() + 1;
            return date.getFullYear() + "-" + (month.toString().length === 2 ? month : "0" + month) + "-" + (day.toString().length === 2 ? day : "0" + day);
        };
    },
        
};

$(document).ready(function(){
    
    // Home
    if ($('.home #calendar')) {
        app.pagesController.defaultAction.calendar();
    }
});
            