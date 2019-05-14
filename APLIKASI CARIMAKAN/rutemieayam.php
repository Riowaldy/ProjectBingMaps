<!DOCTYPE html>
<html>
<head>
	<title></title>
<script>
	var map, directionsManager;

	function GetMap(){
		map = new Microsoft.Maps.Map('#myMap', {
			credentials: 'AhSe5klF9GpwwzeQyUmlmNFC2SdpCg9TQxMMhfdtwfgq-Muz7gH9J012nFKPParZ', 
			mapTypeId: Microsoft.Maps.MapTypeId.aerial, 
			zoom: 11
		});
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showDirection);
		} else {
			alert("Geolocation is not supported by this browser.");
		}
	}

	function showDirection(position){
		var x = document.getElementById('tujuan').value;

		//memecah string menjadi array, menggunakan pemisah "," 
		var tujuan = x.split(',');

		//Load modul directions
		Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function () {
			//membuat instance directions manager. 
			directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);

			//membuat waypoint yang akan dilalui rute. 
			var lati = position.coords.latitude; // didapatkan dari geolocation
			var longi = position.coords.longitude; // didapatkan dari geolocation
			var asal = new Microsoft.Maps.Directions.Waypoint({ address: 'Posisi Anda', location: new Microsoft.Maps.Location(lati,longi) });
			directionsManager.addWaypoint(asal);

			var destinasi = new Microsoft.Maps.Directions.Waypoint({ address: tujuan[2], 
				location: new Microsoft.Maps.Location(tujuan[0],tujuan[1]) });
			directionsManager.addWaypoint(destinasi);

			//set opsi request, mempergunakan kilometer, dan menghindari jalan tol. 
			directionsManager.setRequestOptions({
				distanceUnit: Microsoft.Maps.Directions.DistanceUnit.km, 
				routeAvoidance: [Microsoft.Maps.Directions.RouteAvoidance.tolls]
			});

			//membuat garis dari rute berwarna hijau
			directionsManager.setRenderOptions({
				drivingPolylineOptions: {
					strokeColor: 'red', 
					strokeThickness: 6
				}, 
				waypointPushpinOptions: {
					title: '' 
				},
				itineraryContainer: '#directionsItinerary' 
			});
			//memperhitungkan rute yang ditempuh
			directionsManager.calculateDirections();
		});
	}
</script>
<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap' async defer> </script>
</head>
<body>
	<div class="directionsContainer" 
	style="width:20%;height:100%;float:left;margin-left:15px;margin-right:75px;">
		<select id="tujuan" onchange="GetMap();" style="margin-bottom:10px;">
			<?php
			$conn = mysqli_connect('localhost','root', '', 'gis');
			// Cek koneksi
			if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
			}
			$sql = "SELECT nama,longlat from mieayam";
			$result = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_assoc($result)) {?>
			<option value="<?php echo
			$row['longlat'].','.$row['nama'];?>"><?php echo
			$row['nama'];?></option>
			<?php
			};
			?>
		</select>
		<div id="directionsItinerary"></div>
	</div>
	<div id="myMap" style="width:70%;height:100%;float:left;"></div>	
</body>
</html>
