<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>nginx on Raspberry!</title>
  </head>
  <body class="bg-dark text-white">
    <?php
        $mysql_connection = require_once('connection.php');
        include_once('readsensors.php');
        $read_sensors = read_sensors();
        $cpu_temp = intval($read_sensors[0]['temp1']['input']);
    ?>
    <div>
      <div class="position-absolute top-50 start-50 translate-middle shadow p-3 mb-5 rounded">
        <?php echo "<pre>".shell_exec("screenfetch | aha -n")."</pre>"; ?>
      </div>
      <div class="position-absolute top-50 start-50 shadow p-3 mb-5 rounded bg-dark">
        nginx is <span class="text-success fw-bold">running</span><br />
        mysql is <?php echo ($mysql_connection) ? "<span class=\"text-success fw-bold\">connected</span>" : "<span class=\"text-danger fw-bold\">disconnected</span>"; ?><br />
        cpu temp <?php echo ($cpu_temp < 50) ? "<span class=\"text-success fw-bold\">$cpu_temp</span>" : "<span class=\"text-danger fw-bold\">$cpu_temp</span>"; ?> °C
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  </body>
</html>