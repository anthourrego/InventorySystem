<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (! function_exists('sendEmail')) {
  function sendEmail($mConfiguracion, $destinatarios, $subject, $body = '') {


    $respM['success'] = false;
		$respM['msj'] = 'No fue posible enviar el correo';

    $files = ['hostEnvioEmpresa', 'emailEnvioEmpresa', 'passEnvioEmpresa', 'puertoEnvioEmpresa', 'tipoCEnvioEmpresa', 'nombreEmpresa'];
		$datos = $mConfiguracion->select("valor, campo")->whereIn('campo', $files)->get()->getResult();

		$result = (object) array();
		foreach($datos as $field) {
			$result->{$field->campo} = $field->valor;
		}

    if (!isset($result->hostEnvioEmpresa) || $result->hostEnvioEmpresa == 'N/A') {
			$respM['msj'] = "No se ha definido el host del correo electrónico.";
			return $respM;
		}

    $email = isset($result->emailEnvioEmpresa) ? $result->emailEnvioEmpresa : '';
		if ($email == '' || strpos($email, '@') === false || strpos($email, '.') === false) {
			$respM['msj'] = "No se ha definido un correo electrónico valido.";
			return $respM;
		}

    if (!isset($result->puertoEnvioEmpresa) || $result->puertoEnvioEmpresa == '') {
      $result->{'puertoEnvioEmpresa'} = 587;
    } else if ($result->tipoCEnvioEmpresa == 'H') {
      $result->puertoEnvioEmpresa = 25;
    }

		if (!isset($result->passEnvioEmpresa) || $result->passEnvioEmpresa == '') {
			$respM['msj'] = "No se ha definido la contraseña del correo electrónico.";
			return $respM;
		}

    if (is_null($subject) || $subject == '') {
			$respM['msj'] = "No se ha definido el asunto de envio.";
			return $respM;
    }

    if (!is_array($destinatarios) || count($destinatarios) == 0) {
      $respM['msj'] = "La lista de destinatarios no valida o se encuentra vacia.";
			return $respM;
    }

		$mail = new PHPMailer;
		try {
			$mail->isSMTP();  
			$mail->Host         = $result->hostEnvioEmpresa; // 'smtp.hostinger.com';
			$mail->SMTPAuth     = true;     
			$mail->Username     = $email; // 'no-reply@apparqueo.com';  
			$mail->Password     = $result->passEnvioEmpresa; // 'Apparqueo123*-+';
			$mail->SMTPSecure   = 'tls';  
			$mail->Port         = $result->puertoEnvioEmpresa;  
			$mail->Subject      = $subject;
			$mail->Body         = $body;
			$mail->setFrom($email, $result->nombreEmpresa);
			
      foreach ($destinatarios as $value) {
        $mail->addAddress($value); 
      }
			$mail->isHTML(true);

			if($mail->send()) {
				$respM['msj'] = "Correo enviado satisfactoriamente.";
				$respM['success'] = true;
			}
		} catch (Exception $e) {
			$respM['msj'] = "Correo enviado satisfactoriamente. " . $mail->ErrorInfo;
		}
		return $respM;
  }
}
