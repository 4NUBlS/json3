<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather | Nueapop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    * {
        font-family: 'Kanit', sans-serif;
    }
</style>

<body>
    <div class="container mt-5 pt-1" style="width: 500px; height: 600px; box-shadow: 0px 0px 10px 0px;">
        <div class="container mt-3">
            <div class="input-group mb-3">
                <span class="input-group-text">Latitude</span>
                <input id="lat_input" type="text" class="form-control">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Longitude</span>
                <input id="lon_input" type="text" class="form-control">
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button id="data_submit" class="btn btn-success" type="button">Submit</button>
            </div>
        </div>
        <div id="res_data" class="container my-3">
        </div>
    </div>
</body>
<script>
    function TODATE(date) {
        var dataDate = new Date(date * 1000);
        var months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        var year = dataDate.getFullYear();
        var month = months[dataDate.getMonth()];
        var date = dataDate.getDate();
        var hours = dataDate.getHours();
        var minutes = "0" + dataDate.getMinutes();
        var seconds = "0" + dataDate.getSeconds();
        var formattedTime = date + '/' + month + '/' + year + ' ' + ' เวลา ' + hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
        return formattedTime
    }

    function loadJSON(latitude, longitude) {
        var url = "https://api.openweathermap.org/data/2.5/weather?lat=" + latitude + "&lon=" + longitude + "&lang=th&appid=3fd9697ce75b6cd62920eeaff0acc3a2";
        $.getJSON(url)
            .done((data) => {
                console.log(data);
                var line = "<p class='my-1'>สถานที่: " + data.name + "</p>";
                line += "<p class='my-1'>อุณหภูมิ: " + (parseFloat(data.main.temp) - 273.15).toFixed(2) + " เซลเซียส</p>";
                line += "<p class='my-1'>ความชื้นสัมพัทธ์: " + data.main.humidity + "%</p>";
                line += "<p class='my-1'>ดวงอาทิตย์ขึ้นเวลา: " + TODATE(data.sys.sunrise) + "</p>";
                line += "<p class='my-1'>ดวงอาทิตย์ตกเวลา: " + TODATE(data.sys.sunset) + "</p>";
                line += "<p class='my-1'>ณ วันที่: " + TODATE(data.dt) + "</p>";
                line += '<img class="mt-3" src="https://wallpaperaccess.com/full/1292574.jpg" alt="" width="100%" height="200px">';
                $("#res_data").append(line);
            })
            .fail((xhr, status, err) => {
                console.log(xhr, status, err);
            });
    }

    var toastMixin = Swal.mixin({
        toast: true,
        icon: 'success',
        animation: true,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    $("#data_submit").click(() => {
        var latitude = $("#lat_input").val();
        var longitude = $("#lon_input").val();
        //var latitude = "8.5390972";
        //var longitude = "99.8397383";
        toastMixin.fire({
            title: 'Latitude : ' + latitude + '\nLongitude : ' + longitude
        });
        document.getElementById("res_data").innerHTML = "";
        loadJSON(latitude, longitude);
    });
</script>

</html>
