<?php
    include("../../includes.php");

    echo "Na aplicação webhook bee da BK";

    file_put_contents("logs/log.txt", print_r($_POST, true));

    if($_POST['webhook']){



        // {
        //     "deliveryId": "88566", // Bee delivery entrega ID
        //     "externalId": "18238", // empresa integrada pedido ID
        //     "status": "GOING_TO_ORIGIN",
        //     "statusDate": "2019-02-01T03:45:27+00:00", // formato Iso 8601
        //     "desName": "beedelivery",
        //     "worker": {
        //         "name": "RAMON SARMENTO",
        //         "phone": "(84) 123456789"
        //     }
        // }

    }