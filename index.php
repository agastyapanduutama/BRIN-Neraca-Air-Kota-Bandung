<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" />

<!-- Tambahkan tag <link> untuk gaya CSS -->
<!-- <link rel="stylesheet" href="http://osl.bingkaikodeku.my.id/visualisasi/node_modules/leaflet-arrowheads/dist/leaflet-arrowheads.css"> -->


<style>
    #map {
        height: 600px;
    }

    #map-select {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 1000;
    }
</style>

<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="#">Neraca Air Bandung</a>
    </div>
</nav>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-2 bg-warning">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white max-vh-100">


                <h4 class="mt-4">Jenis Peta</h4>
                <div class="container">
                    <select class="form-control" id="map-type" onchange="changeMapType()">
                        <option value="Esri.WorldImagery">Esri World Imagery</option>
                        <option value="Esri.WorldTerrain">Esri World Terrain</option>
                        <option value="OpenStreetMap.Mapnik" selected>OpenStreetMap</option>
                        <option value="OpenTopoMap">OpenTopoMap</option>
                        <option value="Stamen_Terrain">Statment Terain</option>
                    </select>
                </div>

                <h4 class="mt-4">Lokasi</h4>
                <div class="container">
                    <select class="form-select" id="ddlViewBy" onchange="changeSpesificLocation()" aria-label="Default select example">
                        <option selected value="showAll">Tampilkan Semua</option>
                        <option value="showKota">Kota Bandung</option>
                        <option value="showKab">Kabupaten Bandung</option>
                        <option value="showKBB">Kabupaten Bandung Barat</option>
                        <option value="removeAll">Sembunyikan Semua</option>
                    </select>
                </div>
                <h4 class="mt-4">Keterangan</h4>
                <div class="container">
                    
                    <div class="row mt-1">
                        <div class="col">
                            <img src="./img/black-line.png" class="imgketerangan w-50" alt="">
                        </div>
                        <div class="col">
                            <div class="text-keterangan">
                                Perbatasan
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col">
                            <img src="./img/blue-line.png" class="imgketerangan w-50" alt="">
                        </div>
                        <div class="col">
                            <div class="text-keterangan">
                                Sungai
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="col p-0">
            <div id="map"></div>
        </div>
    </div>
</div>


</div>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet-providers@1.13.0/leaflet-providers.js"></script>
<script src="http://osl.bingkaikodeku.my.id/visualisasi/node_modules/leaflet-arrowheads/src/leaflet-arrowheads.js">
</script>
<script src="https://raw.githubusercontent.com/calvinmetcalf/catiline/master/dist/catiline.min.js"></script>
<script src="https://unpkg.com/shpjs@latest/dist/shp.js"></script>

<script type="text/javascript">
    var m = L.map('map').setView([-6.898606703691583, 107.61840761055102], 13);
    var tileLayers = {
        'Esri.WorldImagery': L.tileLayer.provider('Esri.WorldImagery', {
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
            maxZoom: 18,
        }),
        'Esri.WorldTerrain': L.tileLayer.provider('Esri.WorldTerrain', {
            attribution: 'Tiles &copy; Esri &mdash; Source: USGS, Esri, TANA, DeLorme, and NPS',
            maxZoom: 18,
        }),
        'OpenStreetMap.Mapnik': L.tileLayer.provider('OpenStreetMap.Mapnik', {
            maxZoom: 18,
        }),
        'OpenTopoMap': L.tileLayer.provider('OpenTopoMap', {
            attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }),
        'Stamen_Terrain': L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}{r}.{ext}', {
            subdomains: 'abcd',
            maxZoom: 18,
            ext: 'png',
            attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }),
    };

    var defaultLayer = tileLayers['OpenStreetMap.Mapnik'];
    defaultLayer.addTo(m);
    var geo = L.geoJSON().addTo(m);


    function changeMapType() {
        var select = document.getElementById('map-type');
        var selectedValue = select.value;
        var selectedLayer = tileLayers[selectedValue];

        if (selectedLayer) {
            selectedLayer.addTo(m);
        }
    }

    function loadAndAddShapefile(layerName, fileName) {
        shp(fileName)
            .then(function(data) {
                geo.addData(data);
                console.log(layerName + ' loaded successfully.');
            })
            .catch(function(error) {
                console.error('Error loading ' + layerName + ':', error);
            });
    }

    function changeSpesificLocation() {
        var e = document.getElementById("ddlViewBy");
        var value = e.value;

        if (value == "showKota") {
            showKotaBandung();
        }

        if (value == "removeAll") {
            removeAllShape();
        }

        if (value == "showAll") {
            showAllShapefiles();
        }

        if (value == "showKab") {
            showKabupatenBandung();
        }

        if (value == "showKBB") {
            showKabupatenBandungBarat();
        }
    }

    var kmlLayerKotaBandung;
    var kmlLayerKabupatenBandung;
    var kmlLayerKabupatenBandungBarat;

    function removeAllShape() {
        geo.clearLayers();
        removeAllKML();
    }

    function showKotaBandung() {

        removeAllShape();
        loadAndAddShapefile('Kota Bandung Sungai AR', 'http://localhost/neraca_air/sungai/kota_bandung/SUNGAI_AR_25K');
        loadAndAddShapefile('Kota Bandung Sungai LN', 'http://localhost/neraca_air/sungai/kota_bandung/SUNGAI_LN_25K');

        fetch('batas_provinsi/kotabandung.kml')
            .then(response => response.text())
            .then(kmltext => {
                kmlLayerKotaBandung = omnivore.kml.parse(kmltext, null, L.geoJSON(null, {
                    style: function(feature) {
                        // Tambahkan logika di sini untuk menentukan warna berdasarkan properti atau kondisi lainnya
                        return {
                            fillColor: 'green', // Ganti dengan warna yang diinginkan
                            weight: 1,
                            opacity: 1,
                            color: 'black',
                            fillOpacity: 0.1
                        };
                    }
                }));
                kmlLayerKotaBandung.addTo(m);

                var bounds = kmlLayerKotaBandung.getBounds();
                m.fitBounds(bounds);
            })
            .catch(error => {
                console.error('Error loading KML:', error);
            });

    }

    function showKabupatenBandung() {
        removeAllShape();
        loadAndAddShapefile('Kab Bandung Sungai AR', 'http://localhost/neraca_air/sungai/kab_bandung/SUNGAI_AR_25K');
        loadAndAddShapefile('Kab Bandung Sungai LN', 'http://localhost/neraca_air/sungai/kab_bandung/SUNGAI_LN_25K');

        fetch('batas_provinsi/kabbandung.kml')
            .then(response => response.text())
            .then(kmltext => {
                kmlLayerKabupatenBandung = omnivore.kml.parse(kmltext, null, L.geoJSON(null, {
                    style: function(feature) {
                        // Tambahkan logika di sini untuk menentukan warna berdasarkan properti atau kondisi lainnya
                        return {
                            fillColor: 'green', // Ganti dengan warna yang diinginkan
                            weight: 1,
                            opacity: 1,
                            color: 'black',
                            fillOpacity: 0.1
                        };
                    }
                }));
                kmlLayerKabupatenBandung.addTo(m);

                var bounds = kmlLayerKabupatenBandung.getBounds();
                m.fitBounds(bounds);
            })
            .catch(error => {
                console.error('Error loading KML:', error);
            });
    }

    function showKabupatenBandungBarat() {
        removeAllShape();
        loadAndAddShapefile('Kab Bandung Barat Sungai AR', 'http://localhost/neraca_air/sungai/kab_bandung_barat/SUNGAI_AR_25K');
        loadAndAddShapefile('Kab Bandung Barat Sungai LN', 'http://localhost/neraca_air/sungai/kab_bandung_barat/SUNGAI_LN_25K');

        fetch('batas_provinsi/kabbandungbarat.kml')
            .then(response => response.text())
            .then(kmltext => {
                kmlLayerKabupatenBandungBarat = omnivore.kml.parse(kmltext, null, L.geoJSON(null, {
                    style: function(feature) {
                        // Tambahkan logika di sini untuk menentukan warna berdasarkan properti atau kondisi lainnya
                        return {
                            fillColor: 'green', // Ganti dengan warna yang diinginkan
                            weight: 1,
                            opacity: 1,
                            color: 'black',
                            fillOpacity: 0.1
                        };
                    }
                }));
                kmlLayerKabupatenBandungBarat.addTo(m);

                var bounds = kmlLayerKabupatenBandungBarat.getBounds();
                m.fitBounds(bounds);
            })
            .catch(error => {
                console.error('Error loading KML:', error);
            });
    }

    function removeAllKML() {
        if (kmlLayerKotaBandung) {
            m.removeLayer(kmlLayerKotaBandung);
        }

        if (kmlLayerKabupatenBandung) {
            m.removeLayer(kmlLayerKabupatenBandung);
        }

        if (kmlLayerKabupatenBandungBarat) {
            m.removeLayer(kmlLayerKabupatenBandungBarat);
        }

    }

    function showAllShapefiles() {
        showKotaBandung();
        showKabupatenBandung();
        showKabupatenBandungBarat();
    }

    document.addEventListener("DOMContentLoaded", function() {
        showKotaBandung();
    });
</script>