<?php
$token = "5920320499:AAFavxSuyHr4gDi1IY4SEhAkWt0Er7kcQlM";
$chat_id = "1485650745"; //numero de telegram del destinatario  1088662697
$message = "Nos sacaremos la mierda :)";
$chat_id2 = "1088662697";
$grupo = "-848439578";

$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$grupo&text=$message";
//$url = "https://api.telegram.org/chat_id=$chat_id2/sendMessage?chat_id=$chat_id&text=$message";

$response = file_get_contents($url);

if ($response === FALSE) {
  echo "Error al enviar el mensaje.";
} else {
  echo "El mensaje ha sido enviado correctamente.";
}

//  WhatsApp
/*$celular = "+591 67418809"; //numero del destinatario
$message2 = "Vamos a pistear wachoooooooooo";

$url2 = "https://api.whatsapp.com/send?phone=$celular&text=$message2";

        

$response2 = file_get_contents($url2);

if ($response2 === FALSE) {
  echo "Error al enviar el mensaje.";
} else {
  echo "El mensaje ha sido enviado correctamente.";
}*/


?>
