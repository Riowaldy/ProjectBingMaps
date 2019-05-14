<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8" />
	<script type='text/javascript'>
    var map, infobox;

    function GetMap() {
        map = new Microsoft.Maps.Map('#myMap', {
        	credentials:"AhSe5klF9GpwwzeQyUmlmNFC2SdpCg9TQxMMhfdtwfgq-Muz7gH9J012nFKPParZ",
			center: new Microsoft.Maps.Location(-7.290011, 112.755719),
			mapTypeId: Microsoft.Maps.MapTypeId.aerial,
			zoom: 12.5
        });

        //Create an infobox at the center of the map but don't show it.
        infobox = new Microsoft.Maps.Infobox(map.getCenter(), {
            visible: false
        });

        //Assign the infobox to a map instance.
        infobox.setMap(map);

        //Create random locations in the map bounds.
        var randomLocations = Microsoft.Maps.TestDataGenerator.getLocations(5, map.getBounds());
        
        for (var i = 0; i < randomLocations.length; i++) {
            var pin = new Microsoft.Maps.Pushpin(randomLocations[i]);

            //Store some metadata with the pushpin.
            pin.metadata = {
                title: 'Pin ' + i,
                description: 'Discription for pin' + i
            };

            //Add a click event handler to the pushpin.
            Microsoft.Maps.Events.addHandler(pin, 'click', pushpinClicked);

            //Add pushpin to the map.
            map.entities.push(pin);
        }
    }

    function pushpinClicked(e) {
        //Make sure the infobox has metadata to display.
        if (e.target.metadata) {
            //Set the infobox options with the metadata of the pushpin.
            infobox.setOptions({
                location: e.target.getLocation(),
                title: e.target.metadata.title,
                description: e.target.metadata.description,
                visible: true
            });
        }
    }
    </script>
    <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap'async defer>
	</script>
</head>
<body>
    <div id="myMap" style="position:relative;width:600px;height:400px;"></div>
</body>
</html>