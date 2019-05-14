<!DOCTYPE html>
<html>
<head>
	<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap'async defer>
	</script>

	<script type="text/javascript">
	
		var map, infobox, dataLayer;
		function GetMap() {
			// Seting Map Options dengan lat dan long kota surabaya
			map = new Microsoft.Maps.Map('#GIS',
			{
				credentials:"AhSe5klF9GpwwzeQyUmlmNFC2SdpCg9TQxMMhfdtwfgq-Muz7gH9J012nFKPParZ",
				center: new Microsoft.Maps.Location(-7.270210,112.756223),
				mapTypeId: Microsoft.Maps.MapTypeId.aerial,
				zoom: 15.8
			});

			//Membuat jendela infobox berada di tengah pin (tidak ditampilkan)
			infobox = new Microsoft.Maps.Infobox(map.getCenter(), {visible: false});

			//Assign infobox pada variabel map
			infobox.setMap(map);

			AddData();
	    }
	
	</script>
</head>
<body onload="GetMap();">
	<script type="text/javascript">
	function AddData(){
		<?php
		//koneksi ke database
		$koneksi = mysqli_connect("localhost","root","","gis");

		//ambil data dari database
		$result = mysqli_query ($koneksi, "select id, nama, longlat, alamat, notelp from bakso");

		$n=1;

		while($row = mysqli_fetch_assoc($result)){?>

			var pin<?php echo $n;?> = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(<?php
				echo $row['longlat'];?>));

			pin<?php echo $n;?>.metadata = {
				title: '<?php echo $row['nama'];?>',
				description: 'Alamat : <?php echo $row['alamat'];?> Telp : <?php echo $row['notelp'];?>'
			};

			Microsoft.Maps.Events.addHandler(pin<?php echo $n;?>, 'click', pushpinClicked);

			map.entities.push(pin<?php echo $n;?>);
		<?php
			$n++;
		}
		?>
	}

	function pushpinClicked(e) {
				if (e.target.metadata) {

				//Menambah metadata pushpin pada option di infobox
				infobox.setOptions({
					location: e.target.getLocation(),
					title: e.target.metadata.title,
					description: e.target.metadata.description,
					visible: true
					});
				}
			}

	</script>
	<div id="GIS" style="width:100%; height:100%"></div>
</body>
</html>