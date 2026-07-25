<?php
if (isset($_POST['Proses'])) {
    $Saran = nl2br($_POST['Saran']);
    echo "<b>Kritik / Saran Anda Adalah</b> : <br>";
    echo "<font color=blue><b>$Saran</b></font>";
}
?>