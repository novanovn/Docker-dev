<?php
// Create connection to Oracle
$conn = oci_connect("DEVMDDC", "mddc", "10.8.1.180/stormdb");
if (!$conn) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit;
}
else {
   print "Anda telah berhasil koneksi ke DB Oracle STORMDB!";
}
// Close the Oracle connection
oci_close($conn);
?>
