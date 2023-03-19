<style>
    #map-layer {
        margin: 20px 0px;
        /* max-width: 600px; */
        min-height: 400px;
        height: 400px;
    }

    .custom-map-control-button {
        background-color: #fff;
        border: 0;
        border-radius: 2px;
        box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
        margin: 10px;
        padding: 0 0.5em;
        font: 400 18px Roboto, Arial, sans-serif;
        overflow: hidden;
        height: 40px;
        cursor: pointer;
    }

    .custom-map-control-button:hover {
        background: rgb(235, 235, 235);
    }

    .gm-style-iw-d {
        color: black;
    }
</style>
<?php
$Nama = '';
$WilayahID = '';
$WA = '';
$Alamat = '';
$KodePos = '';
$Kontak = '';
$Latitude = '';
$Longitude = '';
$UndanganID =  $_POST['undanganid'];
if (!empty($UndanganID)) {
    $qeu = db_connect('db_undangan')->query('SELECT * FROM undangan WHERE UndanganID="' . $UndanganID . '"')->getRow();
    $Nama = $qeu->Nama;
    $WilayahID = $qeu->WilayahID;
    $WA = $qeu->WA;
    $Alamat = $qeu->Alamat;
    $KodePos = $qeu->KodePos;
    $Kontak = $qeu->Kontak;
    $Latitude = $qeu->Latitude;
    $Longitude = $qeu->Longitude;
}
$wilayah = json_decode(file_get_contents("https://ibnux.github.io/data-indonesia/kecamatan/1371.json"));
// echo '<pre>' . print_r($wilayah) . '</pre>';
?>

<form action="<?= route_to('save.undangan'); ?>" method="post" id="form-undangan">
    <?= csrf_field() ?>
    <div class="modal-body">
        <div class="form-group mb-3">
            <label class="text-black">Nama</label>
            <input type="text" name="Nama" class="form-control" value="<?= $Nama; ?>" placeholder="Nama">
        </div>



        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label class="text-black">Wilayah</label>
                <select class="form-select form-control" name="WilayahID" id="Wilayah" aria-label="Default select example">
                    <option value="">[Pilih WIlayah]</option>
                    <?php
                    foreach ($wilayah as $val) {
                        // $WilayahID == $val->id ? $sel = 'selected' : $sel = '';
                        $selected = $WilayahID == $val->id ? 'selected' : '';
                        echo '<option value="' . $val->id . '" ' . $selected . '>' . $val->nama . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-6 mb-3">
                <label class="text-black">Kode Pos</label>
                <input type="text" name="KodePos" class="form-control" value="<?= $KodePos; ?>" placeholder="kode pos">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label class="text-black">No Telpon</label>
                <input type="text" name="Kontak" class="form-control" value="<?= $Kontak; ?>" placeholder="kontak PT">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label class="text-black">No Whatsaap</label>
                <input type="text" name="WA" class="form-control" value="<?= $WA; ?>" placeholder="kontak PT">
            </div>
        </div>
        <div class="form-group mb-3">
            <div id="map-layer"></div>
        </div>
        <div class="row">
            <div class="form-group col-md-6 mb-3">
                <label class="text-black">Latitude</label>
                <input type="text" name="Latitude" class="form-control" id="Latitude" value="<?= $Latitude; ?>" placeholder="latitude">
            </div>
            <div class="form-group col-md-6 mb-3">
                <label class="text-black">Longitude</label>
                <input type="text" name="Longitude" class="form-control" id="Longitude" value="<?= $Longitude; ?>" placeholder="longitude">
            </div>
        </div>
        <div class="form-group mb-3">
            <label class="text-black">Alamat Lengkap</label>
            <textarea class="form-control" name="Alamat" rows="4"><?= $Alamat; ?></textarea>
        </div>
    </div>
    <input type="hidden" name="UndanganID" value="<?= $UndanganID; ?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="simpanData" class="btn btn-primary">Simpan Data</button>
    </div>
</form>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_vGZ1RdTwdY9mf-sq0SgjSso5TNhFjmo&callback=initMap"></script>
<script>
    $(document).ready(function() {
        let map, infoWindow;
        let markers = [];

        function initMap() {

            var LatCode = $('#Latitude').val();
            var LngCode = $('#Longitude').val();
            if (LatCode && LngCode) {
                var location = {
                    lat: parseFloat(LatCode),
                    lng: parseFloat(LngCode)
                };
                var zm = 16;
            } else {
                var location = {
                    lat: -6.200000,
                    lng: 106.816666
                };
                var zm = 5;
            }

            map = new google.maps.Map(document.getElementById("map-layer"), {
                center: location,
                zoom: zm,

            });
            placeMarkerAndPanTo(location, map);
            infoWindow = new google.maps.InfoWindow();
            infoWindow.close();

            const locationButton = document.createElement("button");
            locationButton.setAttribute('type', 'button');
            locationButton.textContent = "GET LOCATION";
            locationButton.classList.add("custom-map-control-button");
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
            locationButton.addEventListener("click", () => {
                // Try HTML5 geolocation.

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                            successCallback,
                            errorCallback_lowAccuracy,
                            {
                                maximumAge: 600000,
                                timeout: 10000,
                                enableHighAccuracy: false
                            }
                            const pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };

                            const contentString = "Latitude :" + position.coords.latitude + ' and Longitude :' + position.coords.longitude;

                            const infowindow = new google.maps.InfoWindow({
                                content: contentString,
                                // maxWidth: 200,
                                ariaLabel: "Uluru",
                            });

                            infoWindow.setPosition(pos);
                            infoWindow.setContent("Location found." + position.coords.latitude + '/' + position.coords.longitude);
                            infoWindow.open(map);
                            map.setCenter(pos);
                            map.setZoom(16);
                            $('#Latitude').val(position.coords.latitude);
                            $('#Longitude').val(position.coords.longitude);
                            // placeMarkerAndPanTo(pos, map);
                            const marker = new google.maps.Marker({
                                position: pos,
                                map,
                                title: "Hello World!",
                            });
                            marker.addListener("click", () => {
                                infowindow.open({
                                    anchor: marker,
                                    map,
                                });
                            });
                        },
                        () => {
                            handleLocationError(true, infoWindow, map.getCenter());

                        }
                    );
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                }

            });

            map.addListener("click", (mapsMouseEvent) => {
                // Close the current InfoWindow.
                infoWindow.close();

                // Create a new InfoWindow.
                infoWindow = new google.maps.InfoWindow({
                    position: mapsMouseEvent.latLng,
                });

                infoWindow.setContent(
                    JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
                );
                infoWindow.open(map);
                // console.log(mapsMouseEvent.latLng.toJSON());

                $('#Latitude').val(mapsMouseEvent.latLng.toJSON().lat);
                $('#Longitude').val(mapsMouseEvent.latLng.toJSON().lng);
                // placeMarkerAndPanTo(mapsMouseEvent.latLng, map);
                return false;
            });
        }

        function placeMarkerAndPanTo(latLng, map) {
            new google.maps.Marker({
                position: latLng,
                map: map,
            });
            map.panTo(latLng);
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(
                browserHasGeolocation ?
                "Error: The Geolocation service failed." :
                "Error: Your browser doesn't support geolocation."
            );
            infoWindow.open(map);
        }

        function errorCallback_lowAccuracy(error) {
            var msg = "<p>Can't get your location (low accuracy attempt). Error = ";
            if (error.code == 1)
                msg += "PERMISSION_DENIED";
            else if (error.code == 2)
                msg += "POSITION_UNAVAILABLE";
            else if (error.code == 3)
                msg += "TIMEOUT";
            msg += ", msg = " + error.message;

            $('body').append(msg);
        }

        function successCallback(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            $('body').append("<p>Your location is: " + latitude + "," + longitude + " </p><p>Accuracy=" + position.coords.accuracy + "m");
        }

        window.initMap = initMap;

        $('#form-undangan').submit(function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                enctype: 'multipart/form-data',
                data: new FormData(form),
                processData: false,
                contentType: false,
                cache: false,
                success: function(data, textStatus) {
                    DTable.ajax.reload(null, false);
                    if (data.param > 0) {
                        $("#myModals").modal("hide");
                        Swal.fire({
                            icon: 'success',
                            title: textStatus,
                            text: data.pesan,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        var pesan = '';
                        Object.keys(data.pesan).forEach(function(key) {
                            pesan += data.pesan[key] + ", ";
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan !',
                            text: pesan,
                        })
                    }

                }
            })
        });
    });
</script>