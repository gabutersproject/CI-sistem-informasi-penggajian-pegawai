<?php
	$dbcon = mysqli_connect("localhost","root","","db_penjualan");
	$bulan = mysqli_query($dbcon,"SELECT * FROM penjualan WHERE tahun='2016' ORDER BY id ASC");
	$hasil = mysqli_query($dbcon,"SELECT * FROM penjualan WHERE tahun='2016' ORDER BY  id asc")
?>
<!DOCTYPE html>
<html>
<head>
	<title>Belajar Chart js</title>
	<script type="text/javascript" src="Chart.bundle.js"></script>
	<style type="text/css">
            .container {
                width: 50%;
                margin: 15px auto;
            }
        </style>

</head>
<body>
	<div class="container">
		<canvas id="myChart" width="100" height="100">
		</canvas>
	</div>
	<script type="text/javascript">
		var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php while($b = mysqli_fetch_array($bulan)){ echo '"'.$b['bulan'].'",';}?>],
                    datasets: [{
                            label: 'HASIL PENJUALAN TAHUN 2016',
                            data: [<?php while($b = mysqli_fetch_array($hasil)){ echo '"'.$b['hasil_penjualan'].'",';}?>],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });
	</script>
</body>
</html>