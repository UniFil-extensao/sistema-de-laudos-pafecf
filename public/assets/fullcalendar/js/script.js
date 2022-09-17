
//inicializa o jquery.
$(function () {

    $('.date-time').mask('00/00/0000 00:00:00');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".delete-event").click(function () {

        let id = $("#modalCalendar input[name='id']").val();

        let Event = {
            id: id, // receberá o id no objeto
            _method: 'DELETE'
        };

        let route = routeEvents('routeEventDelete');
        sendEvent(route, Event);

    })

    $(".save-event").click(function () {

        let id = $("#modalCalendar input[name='id']").val();

        let title = $("#modalCalendar input[name='title']").val();

        let start = moment($("#modalCalendar input[name='start']").val(), "DD/MM/YYYY HH:mm:ss").format('YYYY-MM-DD HH:mm:ss');

        let end = moment($("#modalCalendar input[name='end']").val(), "DD/MM/YYYY HH:mm:ss").format('YYYY-MM-DD HH:mm:ss');

        let color = $("#modalCalendar input[name='color']").val();

        let description = $("#modalCalendar textarea[name='description']").val();

        let Event = {
            title: title,
            start: start,
            end: end,
            color: color,
            description: description
        };

        let route;

        if (id == '') {
            route = routeEvents('routeEventStore');
        } else {
            route = routeEvents('routeEventUpdate');
            Event.id = id;
            Event._method = 'PUT';
        }

        sendEvent(route, Event);

    });

});

function sendEvent(route, data_) {
    $.ajax({
        url: route,
        data: data_,
        method: 'POST',
        dataType: 'json',
        success: function (json) {

            if (json) {
                location.reload();
            }
        }
    });
}

function routeEvents(route) {

    return document.getElementById('calendar').dataset[route];
}

function resetForm(form) {
    $(form)[0].reset();
}
