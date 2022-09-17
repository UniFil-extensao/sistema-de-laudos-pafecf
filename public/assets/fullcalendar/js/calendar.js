document.addEventListener('DOMContentLoaded', function () {
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendarInteraction.Draggable

    /* inicializa o calendário
    -----------------------------------------------------------------*/

    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        locale: 'pt-br',
        navLinks: true,
        eventLimit: true,
        selectable: true,
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        drop: function (arg) {
            // is the "remove after drop" checkbox checked?
            if (document.getElementById('drop-remove').checked) {
                // if so, remove the element from the "Draggable Events" list
                arg.draggedEl.parentNode.removeChild(arg.draggedEl);
            }
        },

        eventDrop: function (element) { // arrastar evento
            let start = moment(element.event.start).format('YYYY-MM-DD HH:mm:ss'); // armazenar os valores
            let end = moment(element.event.end).format('YYYY-MM-DD HH:mm:ss');     // nas variáveis

            // propriedades - criar obj.
            let newEvent = {
                _method: 'PUT', // retorna o helper method
                id: element.event.id,
                start: start,
                end: end
            };
            // passa a rota e passa os dados para o evento
            sendEvent(routeEvents('routeEventUpdate'), newEvent)
        },

        eventClick: function (element) { // ao clicar em algum evento, formulário preenchido

            resetForm("#formEvent");

            $("#modalCalendar").modal('show');
            $("#modalCalendar #titleModal").text('Alterar Evento');
            $("#modalCalendar button.delete-event").css("display", "flex"); // aparecer somente qdo editar evento

            let id = element.event.id;
            $("#modalCalendar input[name='id']").val(id);

            let title = element.event.title;
            $("#modalCalendar input[name='title']").val(title);

            let start = moment(element.event.start).format('DD/MM/YYYY HH:mm:ss');
            $("#modalCalendar input[name='start']").val(start);

            let end = moment(element.event.end).format('DD/MM/YYYY HH:mm:ss');
            $("#modalCalendar input[name='end']").val(end);

            let color = element.event.backgroundColor;
            $("#modalCalendar input[name='color']").val(color);

            let description = element.event.extendedProps.description;
            $("#modalCalendar textarea[name='description']").val(description);
        },

        eventResize: function (element) { // redimensionar o evento
            let start = moment(element.event.start).format('YYYY-MM-DD HH:mm:ss'); // armazenar os valores
            let end = moment(element.event.end).format('YYYY-MM-DD HH:mm:ss');     // nas variáveis

            // propriedades - criar obj.
            let newEvent = {
                _method: 'PUT', // retorna o * method
                id: element.event.id,
                start: start,
                end: end
            };
            // passa a rota e passa os dados para o evento
            sendEvent(routeEvents('routeEventUpdate'), newEvent)
        },

        select: function (element) { // formulário ao clicar em alguma data

            resetForm("#formEvent"); // antes de abrir a modal, faz um reset nos dados do formulário

            $("#modalCalendar").modal('show');
            $("#modalCalendar #titleModal").text('Adicionar Evento');
            $("#modalCalendar button.delete-event").css("display", "none");

            let start = moment(element.start).format('DD/MM/YYYY HH:mm:ss');
            $("#modalCalendar input[name='start']").val(start);

            let end = moment(element.end).format('DD/MM/YYYY HH:mm:ss');
            $("#modalCalendar input[name='end']").val(end);

            $("#modalCalendar input[name='color']").val('#ff8f00');

            calendar.unselect();
        },

        events: routeEvents('routeLoadEvents'),

    });
    calendar.render();

});
