<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Absen Harian</h4>
            </div>
            <div class="card-body">
                <table class="table w-100">
                    <thead>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Absen Masuk</th>
                        <th>Absen Pulang</th>
                    </thead>
                    <tbody>
                        <tr>
                            <?php if(is_weekend()): ?>
                                <td class="bg-light text-danger" colspan="4">Hari ini libur. Tidak Perlu absen</td>
                            <?php else: ?>
                                <td><i class="fa fa-3x fa-<?= ($absen < 2) ? "warning text-warning" : "check-circle-o text-success" ?>"></i></td>
                                <td><?= tgl_hari(date('d-m-Y')) ?></td>
                                <td>
                                    <a href="<?= base_url('absensi/absen/masuk') ?>" value="Get Location" onclick="getLocationConstant()" class="btn btn-primary btn-sm btn-fill"<?= ($absen == 1) ? 'disabled style="cursor:not-allowed"' : '' ?>>Absen Masuk</a>
                                </td>
                                <td>
                                    <a href="<?= base_url('absensi/absen/pulang') ?>" class="btn btn-success btn-sm btn-fill"<?= ($absen !== 1 || $absen == 2) ? 'disabled style="cursor:not-allowed"' : '' ?>>Absen Pulang</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    </tbody>
                </table>
                <label for="Latitude">Latitude</label><br>
                     <input class="multi-lainnya" type="text" id="Latitude" name="Latitude" value="" readonly><br>
                     
                     
                     <label for="Longitude">Longitude</label><br>
                     <input class="multi-lainnya" type="text" id="Longitude" name="Longitude" value="" readonly><br><br>
            </div>
        </div>
    </div>
</div>
<script>
    function showPosition() {
        navigator.geolocation.getCurrentPosition(showMap);
    }

    function showMap(position) {
        // Get location data
        var lat = position.coords.latitude;
        var geo1 = document.getElementById("lat");
        geo1.value = lat;
        var long = position.coords.longitude;
        var geo2 = document.getElementById("long");
        geo2.value = long;
    }

    // Prevent forms from submitting.
    function preventFormSubmit() {
        var forms = document.querySelectorAll('form');
        for (var i = 0; i < forms.length; i++) {
            forms[i].addEventListener('submit', function(event) {
                event.preventDefault();
            });
        }
    }
    window.addEventListener('load', preventFormSubmit);
    window.addEventListener('load', showPosition);

    function handleFormSubmit(formObject) {
        google.script.run.processForm(formObject);
        document.getElementById("myForm").reset();
    }
    
</script>

 <script type="text/javascript"> 
 function getLocationConstant()
{
    if(navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(onGeoSuccess,onGeoError);  
    } else {
    document.getElementById("Latitude").value =  "not support"; 
    document.getElementById("Longitude").value = "not support";
    }
    
}

// If we have a successful location update
function onGeoSuccess(event){

document.getElementById("Latitude").value =  event.coords.latitude; 

document.getElementById("Longitude").value = event.coords.longitude;


google.script.url.withSuccessHandler(reverseLatLong).olahLatLong(event.coords.latitude, event.coords.longitude);



        
}




// If something has gone wrong with the geolocation request
function onGeoError(event)
{
    document.getElementById("Latitude").value =  "not support"; 
    document.getElementById("Longitude").value = "not support";
}

function reverseLatLong(address){

sweetAlert({

            title: "Lokasi*:",

            text: "" + address + "\n\n" + '*TROUBLESHOOT: Apabila lokasi tidak sesuai, tingkatkan akurasi perangkat dengan masuk ke alamat https://www.google.com/maps/ kemudian pilih "Lokasi Anda", biarkan selama 15 detik. Kemudian kembali lagi ke presensi, tekan tombol "Get Location".',

            timer: 5000,

            buttons: false,

            icon:"success"

});

}

function doGet(request) {
  return HtmlService.createTemplateFromFile('Chart').evaluate()
  .addMetaTag('viewport', 'width=device-width, initial-scale=1');
}

/* @Include JavaScript and CSS Files */
function include(filename) {
  return HtmlService.createHtmlOutputFromFile(filename)
  .getContent();
}

/* @Process Form */
function processForm(formObject) {
  var currentDate = new Date();
  var url = "isi dengan url spreadsheet";
  var ss = SpreadsheetApp.openByUrl(url);
  var ws = ss.getSheetByName("Output");
  var response = Maps.newGeocoder().reverseGeocode(formObject.lat, formObject.long);
  var address = response["results"][0]["formatted_address"];
  ws.appendRow(
    [
      currentDate,
      formObject.nama,
      formObject.device,
      formObject.lat,
      formObject.long,
      address
    ]
  );
}

function olahLatLong(lat,long){

var response = Maps.newGeocoder().reverseGeocode(lat,long);

var address = response["results"][0]["formatted_address"];

return address;

}
 </script>
 