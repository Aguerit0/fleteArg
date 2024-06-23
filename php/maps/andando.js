//lat y long iniciales
var myLatLng = { lat: -28.46957, lng: -65.78524 };
var mapOptions = {
    center: myLatLng,
    zoom: 13,
    mapTypeId: google.maps.MapTypeId.ROADMAP

};

//creo el mapa
var map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

//creo un objeto de DirectionsService para usar el método de ruta y obtener un resultado para nuestra solicitud
var directionsService = new google.maps.DirectionsService();

//crear un objeto DirectionsRenderer que usaremos para mostrar la ruta
var directionsDisplay = new google.maps.DirectionsRenderer();

// vincular el DirectionsRenderer al mapa
directionsDisplay.setMap(map);


//defino funcion calcRoute
function calcRoute() {
    //creo una petición
    var request = {
        origin: document.getElementById("from").value,
        destination: document.getElementById("to").value,
        travelMode: google.maps.TravelMode.DRIVING, //caminando, bicicleta, auto
        unitSystem: google.maps.UnitSystem.IMPERIAL
    }

    //pasar la solicitud al método de ruta
    directionsService.route(request, function (result, status) {
        if (status == google.maps.DirectionsStatus.OK) {

            //obtengo distancia y tiempo
            const output = document.querySelector('#output');

            //paso de millas a km
            milla = 1.60934;
            resultKm = parseFloat(result.routes[0].legs[0].distance.text);
            resultKm = resultKm*milla;
            resultKm = parseInt(resultKm);

            //

            output.innerHTML ='<div class="row form-group">'+
            '                        <h2 class="text-center text-title">Datos del Servicio</h2>'
            '                        <div class="col-12">'+
            '                            <p class="text-center small">Ubicación de Salida</p>'+
            '                            <input require disabled type="text" value="'+document.getElementById("from").value+'" id="ubiSalida" name="ubiSalida" >'+
            '                        </div>'+
            '                        <div class="col-12">'+
            '                            <p class="text-center small">Ubicación de Llegada</p>'+
            '                            <input require disabled type="text" value="'+document.getElementById("to").value+'" id="ubiLlegada" name="ubiLlegada" >'+
            '                        </div>'+
            '                        </div>'+
            '                        <div class="form-group justify-content-center">'+
            '                        <div class="col-12">'+
            '                            <p class="text-center small">Distancia Total</p>'+
            '                            <input require disabled type="text" value="'+resultKm+'" id="distancia" name="distancia" >'+
            '                        </div>'+
            '                        <div class="col-12">'+
            '                            <p class="text-center small">Tiempo Estimado</p>'+
            '                            <input require disabled type="text" value="'+result.routes[0].legs[0].duration.text+'" id="tiempo" name="tiempo" >'+
            '                        </div>'+
            '                        <br>'+
            '                        </div>'+
            '                        <div class="col-12 d-flex align-items-center justify-content-center">'+
            '                            <button class="btn btn-primary w-50" type="submit" name="submit">Contratar</button>'+
            '                        </div>';

            //muestro la ruta
            directionsDisplay.setDirections(result);
        } else {
            //elimino la ruta del mapa
            directionsDisplay.setDirections({ routes: [] });
            //centro el mapa en catamarca
            map.setCenter(myLatLng);

            //muestro mensaje de error
            output.innerHTML = "<div class='alert-danger'><i class='fas fa-exclamation-triangle'></i> No se puede obtener la distancia entre las 2 ubicaciones.</div>";
        }
    });

}



//create autocomplete objects for all inputs
var options = {
    types: ['(cities)']
}

var input1 = document.getElementById("from");
var autocomplete1 = new google.maps.places.Autocomplete(input1, options);

var input2 = document.getElementById("to");
var autocomplete2 = new google.maps.places.Autocomplete(input2, options);
