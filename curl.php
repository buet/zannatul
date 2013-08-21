<?php
/*if(function_exists('curl_version')){
	echo('Posi');
}else{
	echo('NNN');
}*/

echo 'Curl: ', function_exists('curl_version') ? 'Enabled' : 'Disabled';
?>