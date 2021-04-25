<div class="row">
    <div class="col-12">
        <div class="card">
            <form action="<?= base_url('absensi/absen_new') ?>" method="post">
                <div class="card-header">
                    <h4 class="card-title">Absensi Harian</h4>
                </div>
                <div class="card-body border-top py-0 my-3">
                    <h4 class="text-muted my-3">Absen</h4>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Absen Masuk" required="reuqired" readonly />
                            </div>
                        </div>
                    </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Absen <i class="fa fa-save"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    navigator.geolocation.getCurrentPosition(function(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;

        var apikey = '5cf88b8ed65d4fe4beeafb5e004c2b79';
        var api_url = 'https://api.opencagedata.com/geocode/v1/json'
        var request_url = api_url
            + '?'
            + 'key=' + apikey
            + '&q=' + encodeURIComponent(latitude + ',' + longitude)
            + '&pretty=1'
            + '&no_annotations=1';

        // see full list of required and optional parameters:
        // https://opencagedata.com/api#forward

        var request = new XMLHttpRequest();
        request.open('GET', request_url, true);

        request.onload = function() {
            // see full list of possible response codes:
            // https://opencagedata.com/api#codes

            if (request.status === 200){ 
            // Success!
            var data = JSON.parse(request.responseText);
            //   alert(data.results[0].formatted); // print the location
            document.getElementById("lokasi").value = 
                data.results[0].components['road'] +', '+
                data.results[0].components['village']+', '+
                data.results[0].components['town']+', '+
                data.results[0].components['state'];

            } else if (request.status <= 500){ 
            // We reached our target server, but it returned an error
                                
            console.log("unable to geocode! Response code: " + request.status);
            var data = JSON.parse(request.responseText);
            console.log('error msg: ' + data.status.message);
            } else {
            console.log("server error");
            }
        };

        request.onerror = function() {
            // There was a connection error of some sort
            console.log("unable to connect to server");        
        };

        request.send();  // make the request
    });
  
                             
</script>