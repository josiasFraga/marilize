var AppCalendar = function() {

    return {
        //main function to initiate the module
        init: function() {
            this.initCalendar();
        },

        initCalendar: function() {

            if (!jQuery().fullCalendar) {
                return;
            }

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var h = {};

            if (App.isRTL()) {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        right: 'title, prev, next',
                        center: '',
                        left: 'agendaDay, agendaWeek, month, today'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        right: 'title',
                        center: '',
                        left: 'agendaDay, agendaWeek, month, today, prev,next'
                    };
                }
            } else {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        left: 'title, prev, next',
                        center: '',
                        right: 'today,month,agendaWeek,agendaDay'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        left: 'title',
                        center: '',
                        right: 'prev,next,today,month,agendaWeek,agendaDay'
                    };
                }
            }

            var initDrag = function(el) {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim(el.text()) // use the element's text as the event title
                };
                // store the Event Object in the DOM element so we can get to it later
                el.data('eventObject', eventObject);
                // make the event draggable using jQuery UI
                el.draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });
            };

            var addEvent = function(title) {
                title = title.length === 0 ? "Untitled Event" : title;
                var html = $('<div class="external-event label label-default">' + title + '</div>');
                jQuery('#event_box').append(html);
                initDrag(html);
            };

            $('#external-events div.external-event').each(function() {
                initDrag($(this));
            });

            $('#event_add').unbind('click').click(function() {
                var title = $('#event_title').val();
                addEvent(title);
            });

            //predefined events
            $('#event_box').html("");
            addEvent("My Event 1");
            addEvent("My Event 2");
            addEvent("My Event 3");
            addEvent("My Event 4");
            addEvent("My Event 5");
            addEvent("My Event 6");

            $('#calendar').fullCalendar('destroy'); // destroy the calendar
            // LOGICA PARA PREENCHER OS EVENTOS
            function isEmpty(obj) {
                for (var prop in obj) {
                    if (obj.hasOwnProperty(prop))
                        return false;
                }
                return true;
            }
            // function isEmpty(obj) {
            //     return Object.keys(obj).length === 0;
            // }
            var agendamentos = new Array();
            var agenda_eventos = window.agenda;
            for (i = 0; i < agenda_eventos.length; i++) {
                /* if (i == 3) {
                    agenda_eventos[i].title = "O LOKO TIO";
                } */
                // new Date(year, month, day, hours, minutes, seconds, milliseconds)
                var data_ini = agenda_eventos[i].start;
                // console.log(data_ini);
                agenda_eventos[i].start = new Date(data_ini);
                if ( !isEmpty(agenda_eventos[i].end) ) {
                    var data_fim = agenda_eventos[i].end;
                    // console.log(data_fim);
                    agenda_eventos[i].end = new Date(data_fim);
                }
                agenda_eventos[i].backgroundColor = App.getBrandColor(agenda_eventos[i].backgroundColor)
                agendamentos[i] = agenda_eventos[i];
                // console.log(agenda_eventos[i]);
            }
            // console.log(agendamentos);
            
            $('#calendar').fullCalendar({ //re-initialize the calendar
                header: h,
                defaultView: 'month', // change default view with available options from http://arshaw.com/fullcalendar/docs/views/Available_Views/ 
                // slotMinutes: 15,
                slotDuration: "00:30:00", // A FREQUÊNCIA PARA EXIBIR INTERVALOS DE TEMPO
                editable: false, // false PARA NAO DEIXAR MEXER NOS ITENS
                droppable: false, // this allows things to be dropped onto the calendar !!!
                weekends: false, // PARA NAO MOSTRAR DOMINGOS E SABADOS
                minTime: "06:00:00", // PARA O HORARIO DA SEMANA A SER MOSTRADO COMECAR EM 6h
                // displayEventTime: false, // PARA NAO MOSTRAR A HORA DO EVENTO AO LADO DELE
                drop: function(date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');
                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.className = $(this).attr("data-class");

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },
                events: agendamentos
            });

        }

    };

}();

var TelaCheia = function () {

    var clicar;

    var clicarBotoes = function () {
        clicar = setInterval(trocarBotoes, 15000);
    }

    var pararClickBotoes = function () {
        clearInterval(clicar);
    }

    var trocarBotoes = function () {
        var btn1 = $('button.fc-month-button').hasClass('fc-state-active');
        var btn2 = $('button.fc-agendaWeek-button').hasClass('fc-state-active');
        var btn3 = $('button.fc-agendaDay-button').hasClass('fc-state-active');
        if (btn1) $('button.fc-agendaWeek-button').trigger('click');
        if (btn2) $('button.fc-agendaDay-button').trigger('click');
        if (btn3) $('button.fc-month-button').trigger('click');
    }

    var fullScreen = function () {
        $('#btn-telacheia').click(function () {
            // document.documentElement.requestFullscreen();
            let elem = document.querySelector("#fullscreen");
            if ( !document.fullscreenElement ) {
                elem.requestFullscreen().then({}).catch(err => {
                    alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                });
                // $('#btn-telacheia').text('Sair Tela Cheia ').append('<i class="fa fa-tv"></i>');
                $('#fullscreen').css({ "overflow": "auto", "background-color": "#e9ecf3" });
                clicarBotoes();
            } else {
                // $('#btn-telacheia').text('Tela Cheia ').append('<i class="fa fa-tv"></i>');
                document.exitFullscreen();
                pararClickBotoes();
            }
        });
    }

    return {
        init: function () {
            fullScreen();
            document.addEventListener('keydown', function (e) {
                e = e || window.event;
                var code = e.which || e.keyCode;
                // console.log(code);
                if (code === 27) { // ESC
                    pararClickBotoes();
                }
            });
        }

    };

}();

jQuery(document).ready(function() {    
    AppCalendar.init();
    TelaCheia.init();
});