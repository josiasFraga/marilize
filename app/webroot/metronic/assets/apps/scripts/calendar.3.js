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
                        right: 'prev,next,today,month,agendaWeek,agendaDay,basicDay'
                    };
                }
            }

            $('#calendar').fullCalendar('destroy'); // destroy the calendar

            // LOGICA PARA PREENCHER OS EVENTOS
            function isEmpty(obj) {
                for (var prop in obj) {
                    if (obj.hasOwnProperty(prop))
                        return false;
                }
                return true;
            }
            var agendamentos = new Array();
            var agenda_eventos = window.agenda;
            for (i = 0; i < agenda_eventos.length; i++) {
                var data_ini = agenda_eventos[i].start;
                agenda_eventos[i].start = new Date(data_ini);
                if ( !isEmpty(agenda_eventos[i].end) ) {
                    var data_fim = agenda_eventos[i].end;
                    agenda_eventos[i].end = new Date(data_fim);
                }
                agenda_eventos[i].backgroundColor = App.getBrandColor(agenda_eventos[i].backgroundColor)
                agendamentos[i] = agenda_eventos[i];
            }
            $('#calendar').fullCalendar({ //re-initialize the calendar
                header: {
                    left: 'title',
                    center: '',
                    right: 'prev,next,today,month,basicDay'
                },
                defaultView: 'month', // change default view with available options from http://arshaw.com/fullcalendar/docs/views/Available_Views/ 
                // slotMinutes: 15,
                slotDuration: "00:30:00", // A FREQUÊNCIA PARA EXIBIR INTERVALOS DE TEMPO
                editable: false, // false PARA NAO DEIXAR MEXER NOS ITENS
                droppable: false, // this allows things to be dropped onto the calendar !!!
                weekends: false, // PARA NAO MOSTRAR DOMINGOS E SABADOS
                minTime: "06:00:00", // PARA O HORARIO DA SEMANA A SER MOSTRADO COMECAR EM 6h
                // displayEventTime: false, // PARA NAO MOSTRAR A HORA DO EVENTO AO LADO DELE
                events: agendamentos
            });

        }

    };

}();

var TelaCheia = function () {

    var clicar;

    var clicarBotoes = function () {
        clicar = setInterval(trocarBotoes, 30000);
    }

    var pararClickBotoes = function () {
        clearInterval(clicar);
    }

    var trocarBotoes = function () {
        var btn1 = $('button.fc-month-button').hasClass('fc-state-active');
        var btn2 = $('button.fc-agendaWeek-button').hasClass('fc-state-active');
        var btn3 = $('button.fc-basicDay-button').hasClass('fc-state-active');
        // if (btn1) $('button.fc-agendaWeek-button').trigger('click');
        if (btn1) {
            $('#fullscreen').animate({ scrollTop: 0 }, 0); // $('#fullscreen').animate({ scrollTop: // local para onde direcionar 0 vai para o topo, $(document).height() pega a altura da pagina e direciona para baixo}, // aqui vai o tempo da animacao em ms);
            $('button.fc-basicDay-button').trigger('click');
            $('#fullscreen').animate({ scrollTop: $(document).height() }, 1000);
        }
        if (btn2) {
            $('button.fc-basicDay-button').trigger('click');
        }
        if (btn3) {
            $('#fullscreen').animate({ scrollTop: 0 }, 0);
            $('button.fc-month-button').trigger('click');
            $('#fullscreen').animate({ scrollTop: $(document).height() }, 30000);
        }
    }

    var fullScreen = function () {
        $('#btn-telacheia').click(function () {
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