
    var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
    $("ul li").each(function(){
        if($(this).attr("id") == pgurl || $(this).attr("id") == '' || $(this).attr("id")+"#" == pgurl){
            $(this).addClass("active");
        }
    });

function inicializaControlFecha() {
    $('input[class="input-fecha"]').daterangepicker({
        "locale": {
            "format": "DD-MM-YYYY",
            "separator": " - ",
            "applyLabel": "Apply",
            "cancelLabel": "Cancel",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "D",
                "L",
                "M",
                "M",
                "M",
                "V",
                "S"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 0
        },
        singleDatePicker: true,
        showDropdowns: true
    });
}
    $('.jsSelect') .select2();
    $('.jsSelect').on('change', function() {$("#select2-"+((this).id)+"-container").css('color', (((this).value==="ND") ? "#B2B2B2" : "#000"));});




