<!DOCTYPE html>
<html>
<head>
	<title>Enlace con PHP</title>
</head>
<body>
	<?php
		
        $celular = "67418809";
        $message2 = "Vamos a pistear x3!!!";
		$url = "https://api.whatsapp.com/send?phone=+591 $celular&text=$message2";
	?>

	<!-- Creamos un enlace usando la etiqueta "a" -->
	<a href="<?php echo $url; ?>">Enviar whatsapp</a>
</body>
</html>
