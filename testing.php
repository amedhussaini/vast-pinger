<!DOCTYPE html>
<html>
	<head>
		<link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet">
		    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
		   <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	</head>
	<body>
		<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/">amed's hacks</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="#">VAST Pinger</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
<?php
	set_time_limit(0);

	if ( isset($_POST["submit"]) ) {
	   if ( isset($_FILES["file"])) {
	            //if there was an error uploading the file
	        if ($_FILES["file"]["error"] > 0) {
	            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	        }
	        else {
	                 //Print file details
	             echo "Upload: " . $_FILES["file"]["name"] . "<br />";
	             echo "Type: " . $_FILES["file"]["type"] . "<br />";
	             echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
	             echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

	                 //if file already exists
	             if (file_exists("upload/" . $_FILES["file"]["name"])) {
	            echo $_FILES["file"]["name"] . " already exists. ";
	             }
	             else {
	                    //Store file in directory "upload" with the name of "uploaded_file.txt"
	            $storagename = "uploaded_file.txt";
	            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $storagename);
	            echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";
	            }
	        }
	     } else {
	             echo "No file selected <br />";
	     }


	if ( $file = fopen( "upload/" . $storagename , 'r' ) ) {

	    echo "File opened.<br />";

	    		echo '<table class="table table-striped table-bordered table-condensed">';
			echo '<thead>
          <tr>
            <th>URL</th>
            <th>Character Count</th>
          </tr>
        </thead>';
        	echo '<tbody>';

	    while (!feof($file) ) {

			$line_of_text = fgets($file);
			$parts = explode(',', $line_of_text);

	
			foreach($parts as $a) {

				//echo strlen(curl_download($a));
				//echo urlencode($a);
				echo "<tr><td>".$a."</td><td>".strlen(curl_download(trim($a)))."</td></tr>";
			}
			
		}
	 	echo '</tbody>';
			echo '</table>';
	}

	} else {


	?>
	

	<form class="well form-inline" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
  	<label>.CSV File</label>
  	<input type="file" name="file" id="file" />
  	<input type="submit" name="submit" />
	</form>
	<?php
	}


	function curl_download($Url){
	 
	    // is cURL installed yet?
	    if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }
	 
	    // OK cool - then let's create a new cURL resource handle
	    $ch = curl_init();
	 
	    // Now set some options (most are optional)
	 
	    // Set URL to download
	    curl_setopt($ch, CURLOPT_URL, $Url);
	 
	    // Set a referer
	    curl_setopt($ch, CURLOPT_REFERER, "http://www.example.org/yay.htm");
	 
	    // User agent
	    curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
	 
	    // Include header in result? (0 = yes, 1 = no)
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	 
	    // Should cURL return or print out the data? (true = return, false = print)
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 
	    // Timeout in seconds
	    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	 
	    // Download the given URL, and return output
	    $output = curl_exec($ch);
	 
	    // Close the cURL resource, and free system resources
	    curl_close($ch);
	 
	    return $output;
	}



?>
	</container>
	</body>
</html>