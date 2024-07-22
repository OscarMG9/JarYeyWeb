<?php
if ($_FILES['imagen']['name']) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://api.remove.bg/v1.0/removebg");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array('image_file' => new CURLFILE($_FILES['imagen']['tmp_name']), 'size' => 'auto'));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'X-Api-Key: FaYWLWC3a7UoTmoeBDHekEfs'
    ));

    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    header('Content-Type: image/png');
    echo $response;
}
?>
