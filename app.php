<?php
  // The global $_POST variable allows you to access the data sent with the POST method by name
  // To access the data sent with the GET method, you can use $_GET
  $option = htmlspecialchars($_POST['option']);
  $offset  = htmlspecialchars($_POST['offset']);
  $message  = htmlspecialchars($_POST['message']);

  $encode_option = "1";
  $decode_option = "2";

  $alphabet = [
    '0' => 'a',
    '1' => 'b',
    '2' => 'c',
    '3' => 'd',
    '4' => 'e',
    '5' => 'f',
    '6' => 'g',
    '7' => 'h',
    '8' => 'i',
    '9' => 'j',
    '10' => 'k',
    '11' => 'l',
    '12' => 'm',
    '13' => 'n',
    '14' => 'o',
    '15' => 'p',
    '16' => 'q',
    '17' => 'r',
    '18' => 's',
    '19' => 't',
    '20' => 'u',
    '21' => 'v',
    '22' => 'w',
    '23' => 'x',
    '24' => 'y',
    '25' => 'z'];

  if (strcmp($option, $encode_option) !== 0 && strcmp($option, $decode_option) !== 0) {
    exit ("Las opciones validas son " . $encode_option . " (cifrar) y " . $decode_option . " (descifrar).");
  }

  if ($offset <= 0) {
    exit("El desplazamiento debe ser mayor a cero.");
  }

  if (empty($message)) {
    exit("El mensaje no debe estar vacio.");
  }

  // Comprueba que el mensaje de entrada solo contenga letras en minuscula y espacios en blanco
  if (!preg_match("/^[a-z\s]+$/", $message)) {
    exit("No se permiten letras mayusculas, caracteres numericos, caracteres de puntuacion ni caracteres especiales (tilde, dieresis, arroba, etc.). Solo se permiten letras minusculas y espacios en blanco. La letra ñ no esta permitida.");
  }

  // Si la opcion ingresada es 1, se ejecuta el cifrado Cesar
  if (strcmp($option, $encode_option) == 0) {
    // La funcion trim() elimina los espacios en blanco del principio y el final de un string
    encode($alphabet, $offset, trim($message));
  }

  // Si la opcion ingresada es 2, se ejecuta el descifrado Cesar
  if (strcmp($option, $decode_option) == 0) {
    // La funcion trim() elimina los espacios en blanco del principio y el final de un string
    decode($alphabet, $offset, trim($message));
  }

  /**
  * Realiza el cifrado Cesar del mensaje de entrada
  *
  * @param array $alphabet
  * @param integer $offset clave (desplazamiento)
  * @param string $message mensaje de entrada
  */
  function encode($alphabet, $offset, $message) {
    // Obtiene un arreglo de caracteres pertenecientes al mensaje de entrada
    $array_message = getCharsMessageArray($message);

    $alphabet_size = count($alphabet);
    $encrypted_message;
    $index;

    foreach ($array_message as $key => $current_char) {

      /* Si el caracter actualmente recorrido del mensaje no es un espacio,
      calcula el caracter de cifrado */
      if ($current_char !== " ") {
        /* Obtiene el indice, en el alfabeto, de un caracter no cifrado del mensaje */
        $index = getIndex($alphabet, $current_char);

        /* Calcula el valor de la posicion del caracter de cifrado
        correspondiente al caracter actualmente recorrido */
        $index = ($index + $offset) % $alphabet_size;

        // Agrega el caracter cifrado al resultado
        $encrypted_message .= $alphabet[$index];
      }

      /* Si el caracter actualmente recorrido del mensaje es un espacio,
      agrega un espacio al resultado */
      if ($current_char == " ") {
        $encrypted_message .= " ";
      }

    }

    echo $encrypted_message;
  }

  /**
  * Realiza el descifrado Cesar del mensaje de entrada
  *
  * @param array $alphabet
  * @param integer $offset clave (desplazamiento)
  * @param string $message mensaje de entrada
  */
  function decode($alphabet, $offset, $message) {
    // Obtiene un arreglo de caracteres pertenecientes al mensaje de entrada
    $array_message = getCharsMessageArray($message);

    $alphabet_size = count($alphabet);
    $decrypted_message;
    $index;

    foreach ($array_message as $key => $current_char) {

      /* Si el caracter actualmente recorrido del mensaje no es un espacio,
      calcula el caracter de descifrado */
      if ($current_char !== " ") {
        /* Obtiene el indice, en el alfabeto, de un caracter cifrado del mensaje */
        $index = getIndex($alphabet, $current_char);

        /* Calcula el valor de la posicion del caracter de descifrado
        correspondiente al caracter actualmente recorrido */
        if ($index - $offset < 0) {
          $index = $alphabet_size + ($index - $offset);
        } else {
          $index = ($index - $offset) % $alphabet_size;
        }

        // Agrega el caracter descifrado al resultado
        $decrypted_message .= $alphabet[$index];
      }

      /* Si el caracter actualmente recorrido es un espacio, agrega un espacio
      al resultado */
      if ($current_char == " ") {
        $decrypted_message .= " ";
      }

    }

    echo $decrypted_message;
  }

  /**
  * Obtiene el valor que tiene la posicion de un caracter en el alfabeto
  *
  * @param array $alphabet
  * @param char $char_message un caracter del mensaje de entrada
  * @return integer el valor que tiene la posicion de un caracter del mensaje
  * de entrada en el alfabeto
  */
  function getIndex($alphabet, $char_message) {

    while ($current_char = current($alphabet)) {

      /* Si el caracter de la posicon actual del alfabeto es igual al caracter del mensaje, retorna
      el valor que tiene la posicion del caracter dentro del alfabeto */
      if ($current_char == $char_message) {
        return key($alphabet);
      }

      next($alphabet);
    }

  }

  /**
  * Convierte una cadena de caracteres (string) en un arreglo
  *
  * @param string $message contiene el mensaje de entrada encriptado
  * @return array que contiene todos los caracteres del mensaje de entrada encriptado
  */
  function getCharsMessageArray($message) {
    return str_split($message);
  }

?>
