<?php
include 'connect.php';

// Fetch data for Active vs. Inactive Users
$sql = "SELECT isActive, COUNT(*) as count FROM tblcustomer GROUP BY isActive";
$result = $mysqli->query($sql);

$customer_data = [];
while($row = $result->fetch_assoc()) {
    $customer_data[] = [$row['isActive'] == 1 ? 'Active' : 'Inactive', (int)$row['count']];
}

// Fetch data for Current vs. Inactive Room Requests
$sql = "SELECT isCurrentRequest, COUNT(*) as count FROM tblroomrequest GROUP BY isCurrentRequest";
$result = $mysqli->query($sql);

$request_data = [];
while($row = $result->fetch_assoc()) {
    $request_data[] = [$row['isCurrentRequest'] == 1 ? 'Current' : 'Inactive', (int)$row['count']];
}

// Fetch data for Gender Distribution
$sql = "SELECT gender, COUNT(*) as count FROM tbluserprofile GROUP BY gender";
$result = $mysqli->query($sql);

$gender_data = [];
while($row = $result->fetch_assoc()) {
    $gender_data[] = [$row['gender'], (int)$row['count']];
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});

      // Active vs. Inactive Users Chart
      google.charts.setOnLoadCallback(drawCustomerChart);
      function drawCustomerChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'Count'],
          <?php
          foreach($customer_data as $data) {
              echo "['".$data[0]."', ".$data[1]."],";
          }
          ?>
        ]);

        var options = {
          title: 'Active vs. Inactive Users'
        };

        var chart = new google.visualization.PieChart(document.getElementById('customer_chart'));
        chart.draw(data, options);
      }

      // Current vs. Inactive Room Requests Chart
      google.charts.setOnLoadCallback(drawRequestChart);
      function drawRequestChart() {
        var data = google.visualization.arrayToDataTable([
          ['Status', 'Count'],
          <?php
          foreach($request_data as $data) {
              echo "['".$data[0]."', ".$data[1]."],";
          }
          ?>
        ]);

        var options = {
          title: 'Current vs. Inactive Room Requests'
        };

        var chart = new google.visualization.PieChart(document.getElementById('request_chart'));
        chart.draw(data, options);
      }

      // Gender Distribution Chart
      google.charts.setOnLoadCallback(drawGenderChart);
      function drawGenderChart() {
        var data = google.visualization.arrayToDataTable([
          ['Gender', 'Count'],
          <?php
          foreach($gender_data as $data) {
              echo "['".$data[0]."', ".$data[1]."],";
          }
          ?>
        ]);

        var options = {
          title: 'Gender Distribution'
        };

        var chart = new google.visualization.PieChart(document.getElementById('gender_chart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="customer_chart" style="width: 900px; height: 500px;"></div>
    <div id="request_chart" style="width: 900px; height: 500px;"></div>
    <div id="gender_chart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
