<?= $this->extend('layout/_app') ?>
<?= $this->section('content-css') ?>
<style>
    #calendar {
        max-width: 100%;
        height: 500px;
    }

    #mapLayer {
        height: 500px;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content-body') ?>
<div class="container-fluid p-0">

    <h1 class="h3 mb-3"><strong>Dashboard</strong> </h1>

    <div class="row">
        <div class="col-xl-12 d-flex">
            <div class="w-100">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Total Undangan</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="ri-calendar-event-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1"><?= $TotalUndangan; ?></h1>
                                <div class="mb-0">
                                    <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> <?= $TotalUndanganLocation; ?> </span>
                                    <span class="text-muted">yang sudah terlokasi</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Total Acara</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="ri-hotel-line"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3"><?= $TotalAcara; ?></h1>
                                <div class="mb-0">
                                    <span class="text-muted"> </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Calender Acara</h5>
                            </div>
                            <figure class="highcharts-figure p-2">
                                <div id="calendar"></div>
                            </figure>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Map Undangan</h5>
                            </div>
                            <figure class="highcharts-figure p-2">
                                <div class="content" id="mapLayer"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>
<?= $this->endSection() ?>
<?= $this->section('content-js') ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_vGZ1RdTwdY9mf-sq0SgjSso5TNhFjmo&callback=initMap" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.4/index.global.min.js" integrity="sha512-Rhv9XXoEZ1UpQs/0jMgV/oBaRsMmJBWRl95hMCcBhXT1gbek85Kr50kVTxjSNdHN/CESMYpcym/vLE9syEZukA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function initMap() {
        const map = new google.maps.Map(document.getElementById("mapLayer"), {
            zoom: 12,
            center: {
                lat: -0.947083,
                lng: 100.417181
            },
        });

        setMarkers(map);

    }


    function setMarkers(map) {
        const shape = {
            coords: [1, 1, 1, 20, 18, 20, 18, 1],
            type: "poly",
        };

        $.ajax({
            url: "<?php echo base_url('dashboard/location') ?>",
            method: 'GET',
            dataType: 'JSON',
            success: function(response) {
                for (let i = 0; i < response.length; i++) {
                    const beach = response[i];

                    const infowindow = new google.maps.InfoWindow({
                        content: beach[0],
                    });
                    // console.log(parseFloat(beach[1]))
                    const marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(beach[1]),
                            lng: parseFloat(beach[2])
                        },
                        map,
                        shape: shape,
                        title: beach[0],
                        zIndex: beach[3],
                    });

                    marker.addListener("click", () => {
                        infowindow.open({
                            anchor: marker,
                            map,
                        });
                    });
                }
            }
        })
    }

    window.initMap = initMap;




    document.addEventListener('DOMContentLoaded', function() {
        var eventData;
        $.ajax({
            url: "<?php echo base_url('acara/event-calender') ?>",
            method: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var eventData = response.data;
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    timeZone: 'Asia/Jakarta',
                    themeSystem: 'bootstrap',
                    headerToolbar: {
                        center: 'dayGridMonth,timeGridWeek',
                        end: 'today prevYear,prev,next,nextYear'
                    },
                    buttonText: {
                        dayGridMonth: 'Bulan',
                        timeGridWeek: 'Minggu'
                    },
                    titleFormat: { // will produce something like "Tuesday, September 18, 2018"
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                    },
                    eventTimeFormat: { // like '14:30:00'
                        hour: '2-digit',
                        minute: '2-digit',
                        meridiem: false
                    },
                    initialView: 'dayGridMonth',
                    // editable: true,
                    selectable: true,
                    events: eventData,
                    eventClick: function(info) {
                        var eventObj = info.event;

                        if (eventObj.url) {
                            alert(
                                'Clicked ' + eventObj.title + '.\n' +
                                'Will open ' + eventObj.url + ' in a new tab'
                            );

                            window.open(eventObj.url);

                            info.jsEvent.preventDefault(); // prevents browser from following link in current tab.
                        } else {

                            var serial = "&acaraid=" + eventObj.id;
                            $('#myModals').modal('toggle');
                            $(".modal-title").html("Informasi Acara");
                            base_url = $("#base_url").val();
                            page = base_url + "modal/modal-" + 'event-calender';
                            $.post(page, serial, function(data) {
                                $("#loading-ajax-modal").hide();
                                $("#konten").html(data);
                            });
                            // alert('Clicked ' + eventObj.title);
                        }
                    },
                });
                calendar.render();
            }
        })

    });
</script>
<?= $this->endSection() ?>