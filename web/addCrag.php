<?php
    session_start();
    if ($_SESSION['user_class'] != 'admin') {
      header("Location: login.php");
    }
    include('top.php');

    // check if places api key exists.
    include "dbconfig.php";
    $query = "SELECT * FROM `bulder`.`bulder_setting` WHERE setting = 'placeskey' LIMIT 1;";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) != 0) {
      $row = mysqli_fetch_assoc($result);
      $placeskey = $row['value'];
      $places = True;
    } else {
      $placeskey = "";
      $places = False;
    }
    mysqli_close($conn);

?>

  <div class="bg-light p-5 rounded">
    <h1>Add Crag</h1>
    <form method="post" action="processnewcrag.php">
        <?php
          if ($places) {
        ?>
        <div class="mb-3">
        <label for="autocomplete" class="form-label">Search</label>
            <input id="autocomplete" class="form-control" placeholder="Search address" type="text"></input>
        </div>
        <?php
          }
        ?>
        <div class="mb-3">
            <label for="frmCragName" class="form-label">Name</label>
            <input type="text" class="form-control" name="frmCragName" id="frmCragName" value="">
        </div>
        <div class="mb-3">
            <label for="frmLon" class="form-label">Longitude</label>
            <input type="text" class="form-control" name="frmLon" id="frmLon" value="">
        </div>
        <div class="mb-3">
            <label for="frmLat" class="form-label">Latitude</label>
            <input type="text" class="form-control" name="frmLat" id="frmLat" value="">
        </div>
        <div class="mb-3">
            <label for="frmCity" class="form-label">City</label>
            <input type="text" class="form-control" name="frmCity" id="frmCity" value="">
        </div>
        <div class="mb-3">
            <input class="btn btn-primary" type="submit" value="Submit">
        </div>
    </form>
  </div>
  <?php
    if ($places) {
  ?>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=<?php echo $placeskey; ?>&libraries=places"></script>
  <script>
function initialize() {

var ac = new google.maps.places.Autocomplete(
  (document.getElementById('autocomplete')), {
    types: ['establishment']
  });

ac.addListener('place_changed', function() {

  var place = ac.getPlace();

  if (!place.geometry) {
    // User entered the name of a Place that was not suggested and
    // pressed the Enter key, or the Place Details request failed.
    console.log("No details available for input: '" + place.name + "'");
    return;
  }

  console.log("You selected: '" + place.formatted_address + "'");
  console.log(place.name);
  
  console.log(place.place_id);
  document.getElementById("frmLon").value = place.geometry.location.lng();
  document.getElementById("frmLat").value = place.geometry.location.lat();
  console.log(place.geometry.location.toString());
  console.log(place.address_components);
  console.log(place.formatted_address);
  console.log(place.vicinity);
  var city = place.vicinity.replaceAll(' ','').split(',')
  city = city[city.length -1]
  document.getElementById("frmCity").value = city;
  document.getElementById("frmCragName").value = place.name;
});

// Trigger search on blur
google.maps.event.addDomListener(document.getElementById("autocomplete"), 'blur', function() {

      // Find the pac-container element
  var pacContainer = nextByClass(this, 'pac-container');
  
  // Check if we are hovering on one of the pac-items
  // :hover propagates to parent element so we only need to check it on the pac-container
  // We trigger the focus and keydown only if :hover is false otherwise it will interfere with a place selection via mouse click
  if (pacContainer.matches(':hover') === false) {
  
      google.maps.event.trigger(this, 'focus', {});
    google.maps.event.trigger(this, 'keydown', {
      keyCode: 13
    });
  }

});
}

function hasClass(elem, cls) {
var str = " " + elem.className + " ";
var testCls = " " + cls + " ";
return (str.indexOf(testCls) != -1);
}

function nextByClass(node, cls) {
while (node = node.nextSibling) {
  if (hasClass(node, cls)) {
    return node;
  }
}
return null;
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>
<?php
  }
?>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

<?php
    include('bottom.php');
?>