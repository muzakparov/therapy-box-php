if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(setWeather);
} else {
    $.get( "http://api.openweathermap.org/data/2.5/weather?lat=35&lon=139&appid=d0a10211ea3d36b0a6423a104782130e", function( data ) {
        setWeather({coords:{latitude:35, longitude:139}});
    });
}

function setWeather(position) {
    $.get( "http://api.openweathermap.org/data/2.5/weather?lat="+
        position.coords.latitude+"&lon="+
        position.coords.longitude+"&appid=d0a10211ea3d36b0a6423a104782130e", function( data ) {
        console.log(data);
        var temp=Math.round(data.main.temp-273.15);
        var location=data.name;
        var basePath='./assets/images/weather/';
        var imgIcon;

        $('.temp').html(temp+' degrees');
        $('.location').html('in '+location);

        switch(data.weather.main){
            case 'Rain':
                imgIcon='Rain_icon.png';
                break;
            case 'Sun':
                imgIcon='Sun_icon.png';
                break;
            default:
                imgIcon='Cloud_icon.png';
                break;
        }

        $('.img-icon').attr('src',basePath+imgIcon);
    });
}
