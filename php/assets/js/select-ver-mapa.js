$(document).ready(function() {

    // Creamos el array de cada tipo de delito que contiene sus diferentes subtipos de delitos
    var todos = [
        { display: "TODOS", value: "TODOS" }
    ];

    var sustraccion_de_motocicleta = [
        { display: "TODOS", value: "TODOS" },
        { display: "VIA PUBLICA", value: "VIA PUBLICA" },
        { display: "USO DE ARMA BLANCA O DE FUEGO", value: "USO DE ARMA BLANCA O DE FUEGO" },
        { display: "INTERIOR DEL DOMICILIO", value: "INTERIOR DEL DOMICILIO" },
        { display: "INTENTO", value: "INTENTO" }
    ];

    var sustraccion_de_automovil = [
        { display: "TODOS", value: "TODOS" },
        { display: "SUSTRACCION DEL RODADO", value: "SUSTRACCION DEL RODADO" },
        { display: "ELEMENTOS DEL INTERIOR", value: "ELEMENTOS DEL INTERIOR" },
        { display: "SUSTRACCION DE RUEDAS.", value: "SUSTRACCION DE RUEDAS" }
    ];

    var ilicito_contra_la_propiedad = [
        { display: "TODOS", value: "TODOS" },
        { display: "COMERCIO", value: "COMERCIO" },
        { display: "CASA PARTICULAR", value: "CASA PARTICULAR" },
        { display: "ENTIDAD PUBLICA", value: "ENTIDAD PUBLICA" },
        { display: "ASALTO CON ARMA BLANCA/ ELEMENTO CONTUNDENTE", value: "ASALTO CON ARMA BLANCA/ ELEMENTO CONTUNDENTE" },
        { display: "ASALTO CON ARMA DE FUEGO", value: "ASALTO CON ARMA DE FUEGO" },
        { display: "OBRA EN CONSTRUCCION", value: "OBRA EN CONSTRUCCION" },
        { display: "TOMA DE REHENES", value: "TOMA DE REHENES" }
    ];

    var arrebato = [
        { display: "TODOS", value: "TODOS" },
        { display: "INTENTO", value: "INTENTO" },
        { display: "CONSUMADO", value: "CONSUMADO" },
    ];

    var ilicito_en_la_via_publica = [
        { display: "TODOS", value: "TODOS" },
        { display: "SUMINISTRO ELECTRICO/SEÑAL DE TELEFONIA/OTROS", value: "SUMINISTRO ELECTRICO/SEÑAL DE TELEFONIA/OTROS" },
        { display: "ASALTO CON ARMA BLANCA/ ELEMENTO CONTUNDENTE", value: "ASALTO CON ARMA BLANCA/ ELEMENTO CONTUNDENTE" },
        { display: "ASALTO CON ARMA DE FUEGO", value: "ASALTO CON ARMA DE FUEGO" },
        { display: "SUSTRACCION DE BICICLETA", value: "SUSTRACCION DE BICICLETA" }
    ];

    var desorden = [
        { display: "TODOS", value: "TODOS" },
        { display: "VIVIENDA", value: "VIVIENDA" },
        { display: "VIA PUBLICA", value: "VIA PUBLICA" },
        { display: "CON ARMAS DE FUEGO", value: "CON ARMAS DE FUEGO" },
        { display: "ARMAS BLANCAS", value: "ARMAS BLANCAS" },
        { display: "PELEA DE GRUPOS ANTAGONICOS", value: "PELEA DE GRUPOS ANTAGONICOS" },
        { display: "DISCUSION ENTRE VECINOS", value: "DISCUSION ENTRE VECINOS" },
    ];

    var abuso_sexual = [
        { display: "TODOS", value: "TODOS" },
        { display: "ABUSO SEXUAL", value: "ABUSO SEXUAL" },
        { display: "TENTATIVA DE ABUSO", value: "TENTATIVA DE ABUSO" },
    ];

    var acoso_sexual = [
        { display: "TODOS", value: "TODOS" },
        { display: "ACOSO EN LA VIA PUBLICA", value: "ACOSO EN LA VIA PUBLICA" },
    ];

    var amenazas = [
        { display: "TODOS", value: "TODOS" },
        { display: "AMENAZA DE BOMBA", value: "AMENAZA DE BOMBA" },
        { display: "AMENAZA VERBAL", value: "AMENAZA VERBAL" },
        { display: "AMENAZAS CON ARMA BLANCA", value: "AMENAZAS CON ARMA BLANCA" },
        { display: "AMENAZAS CON ARMA DE FUEGO", value: "AMENAZAS CON ARMA DE FUEGO" }
    ];

    var armas = [
        { display: "TODOS", value: "TODOS" },
        { display: "DETONACIONES", value: "DETONACIONES" },
        { display: "PORTACION DE ARMA BLANCA", value: "PORTACION DE ARMA BLANCA" },
        { display: "PORTACION DE ARMA DE FUEGO", value: "PORTACION DE ARMA DE FUEGO" },
        { display: "USO INDEBIDO HONDA/AIRECOMPRIMIDO", value: "USO INDEBIDO HONDA/AIRECOMPRIMIDO" }
    ];

    var exhibiciones_obsenas = [
        { display: "TODOS", value: "TODOS" },
        { display: "EXHIBICION OBSENA EN LA VIA PUBLICA", value: "EXHIBICION OBSENA EN LA VIA PUBLICA" },
    ];

    var violencia_familiar_y_de_genero = [
        { display: "TODOS", value: "TODOS" },
        { display: "VIOLENCIA DE GENERO EN DOMICILIO", value: "VIOLENCIA DE GENERO EN DOMICILIO" },
        { display: "VIOLENCIA DE GENERO EN LA VIA PUBLICA", value: "VIOLENCIA DE GENERO EN LA VIA PUBLICA" },
        { display: "VIOLENCIA INTRAFAMILIAR", value: "VIOLENCIA INTRAFAMILIAR" }
    ];

    // Aqui creamos verificamos cual opciones apareceran dependiendo de la seleccion@superservicios

    $("#tipo").change(function() {
        var parent = $(this).val();

        switch (parent) {
            case 'TODOS':
                list(todos);
                break;
            case 'SUSTRACCION DE MOTOCICLETA':
                list(sustraccion_de_motocicleta);
                break;
            case 'SUSTRACCION DE AUTOMOVIL':
                list(sustraccion_de_automovil);
                break;
            case 'ILICITO CONTRA LA PROPIEDAD':
                list(ilicito_contra_la_propiedad);
                break;
            case 'ARREBATO':
                list(arrebato);
                break;
            case 'ILICITO EN LA VIA PUBLICA':
                list(ilicito_en_la_via_publica);
                break;
            case 'DESORDEN':
                list(desorden);
                break;
            case 'ABUSO SEXUAL':
                list(abuso_sexual);
                break;
            case 'ACOSO SEXUAL':
                list(acoso_sexual);
                break;
            case 'AMENAZAS':
                list(amenazas);
                break;
            case 'ARMAS':
                list(armas);
                break;
            case 'EXHIBICIONES OBSENAS':
                list(exhibiciones_obsenas);
                break;
            case 'VIOLENCIA FAMILIAR Y DE GENERO':
                list(violencia_familiar_y_de_genero);
                break;
            default: //default child option is blank
                $("#subtipo").html('');
                $('#subtipo').prop('disabled', true);
                break;
        }
    });

    //function to populate child select box
    function list(array_list) {
        $("#subtipo").html(""); //reset child options
        $(array_list).each(function(i) { //populate child options
            $("#subtipo").append("<option value=\"" + array_list[i].value + "\">" + array_list[i].display + "</option>");
        });
        $('#subtipo').prop('disabled', false);
    }

});