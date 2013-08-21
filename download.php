<?php
/*
This is an example on how to use the OpenTok Restful services to create downloadable video links from your Archive ID and a Moderator Token
*/

//You must use or pass a moderator token derived from your API key
$token = "T1==cGFydG5lcl9pZD0zMjQ3OTY4MiZzZGtfdmVyc2lvbj10YnJ1YnktdGJyYi12MC45MS4yMDExLTAyLTE3JnNpZz1lYjg3Nzk3N2VkNjU1NTcxOWM3ZjVlM2UxMzU5MzY1YjBlNWI5ZTE5OnJvbGU9cHVibGlzaGVyJnNlc3Npb25faWQ9Ml9NWDR6TWpRM09UWTRNbjR4TWpjdU1DNHdMakYtVkhWbElFcDFiQ0F6TUNBeU1UbzBOem95TmlCUVJGUWdNakF4TTM0d0xqUTJPVGcxTVRoLSZjcmVhdGVfdGltZT0xMzc1MjQ2MDQ4Jm5vbmNlPTAuOTk2NzkxMjg4Mjg5NDMyJmV4cGlyZV90aW1lPTEzNzUzMzI0NDkmY29ubmVjdGlvbl9kYXRhPQ==";

//You must have stored or retrieved a valid Archive ID
$archiveId = "5a9c6422-74f6-44f0-ba66-79701be19025";



//This is the HTTP Header for the query
$authString = "X-TB-TOKEN-AUTH: ".$token;

//This is the Opentok URL, change to staging or production
$url = "https://api.opentok.com/hl/archive/getmanifest/".$archiveId;

//Creation of the cURL query
$postFields = Array("x-tb-token-auth:". $token); //puts HTTP Header into an array
$curl = curl_init(); // starts curl

curl_setopt($curl, CURLOPT_URL, $url); //pass the target URL (production or staging)
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //tells curl to return either the text to the browser (0) or to a variable (1)
curl_setopt($curl, CURLOPT_HTTPHEADER, $postFields); //tells curl what header information to pass
curl_setopt($curl, CURLOPT_POSTFIELDS, "a");
curl_setopt($curl, CURLOPT_POST, true); //tells curl what we are doing, which is a POST

$body = curl_exec($curl); //passes all the information curl received into $body variable
$info = curl_getinfo($curl);
curl_close($curl); // closes curl

$xmlform=@simplexml_load_string($body); //takes $body, which is a string and tells $xmlform that its supposed to be in XML

//this pulls out all the Video IDs from the XML in an array
foreach($xmlform->resources->video as $videoResourceItem) {
    $vidid[] = $videoResourceItem['id'];
}

//this tells us how large the array is
$archivesize = sizeof($vidid);

echo "Number of videos in the archive: ".$archivesize."<p>"; //simple feed back to verify the number of videos

//this loop creates downloadable links for each of your videos by making multiple curl requests
for ($i = 0; $i < $archivesize; $i++)
{
    echo "Video ID: ".$vidid[$i]."<br>";

    $url2 = "https://api.opentok.com/hl/archive/url/".$archiveId."/".$vidid[$i]; //change for staging or production
    $curl2 = curl_init();

    curl_setopt($curl2, CURLOPT_URL, $url2);
    curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl2, CURLOPT_HTTPHEADER, $postFields);
    curl_setopt($curl2, CURLOPT_POSTFIELDS, "a");
    curl_setopt($curl2, CURLOPT_POST, true);

    $body2 = curl_exec($curl2);
    curl_close($curl2);
    echo "<a href='".$body2."'>Click here to download video ".$i."</a>";

    echo "<p>";
}

?>