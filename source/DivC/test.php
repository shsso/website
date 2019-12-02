<?php
	include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/top.php");
	include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/header.php");
?>

<html lang="en">

	<head>
		<title>CSS Website Layout</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<style>
			* {
  			  box-sizing: border-box;
			}

			body {
  				margin: 0;
			}


			/* Create two equal columns that floats next to each other */
			.column {
  				float: left;
   				width: 50.00%;
    				padding: 15px;
			}				

			/* Clear floats after the columns */
			.row:after {
   				content: "";
    				display: table;
    				clear: both;
			}

		</style>
	</head>

	<body>

		<div class="row">
  
  			<div class="column">
    				<h2>Column 1 </h2>
    				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque ultricies, eget elementum magna tristique. Quisque vehicula, risus eget aliquam placerat, purus leo tincidunt eros, eget luctus quam orci in velit. Praesent scelerisque tortor sed accumsan convallis.</p>
  			</div>
  
			<div class="column">
    				<h2>Column 2</h2>
    				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sit amet pretium urna. Vivamus venenatis velit nec neque ultricies, eget elementum magna tristique. Quisque vehicula, risus eget aliquam placerat, purus leo tincidunt eros, eget luctus quam orci in velit. Praesent scelerisque tortor sed accumsan convallis.</p>
  			</div>
		</div>

	</body>
</html>

<?php
	include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/bottom.php");
?>