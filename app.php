<?php
  // The global $_POST variable allows you to access the data sent with the POST method by name
  // To access the data sent with the GET method, you can use $_GET
  $option = htmlspecialchars($_POST['option']);
  $offset  = htmlspecialchars($_POST['offset']);
  $message  = htmlspecialchars($_POST['message']);

  $encode_option = "1";
  $decode_option = "2";
  $result_message = "";

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

  /* Si la opcion ingresada es 1, se ejecuta la codificacion Cesar */
  if (strcmp($option, $encode_option) == 0) {
    encode($alphabet, $offset, $message);
  }

  /* Si la opcion ingresada es 2, se ejecuta el descifrado Cesar */
  if (strcmp($option, $decode_option) == 0) {
    decode($alphabet, $offset, $message);
  }

  function encode($alphabet, $offset, $message) {
    /* Obtiene un arreglo de caracteres pertenecientes al mensaje */
    $array_message = get_array_message($message);

    $alphabet_size = count($alphabet);
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

        /* Agrega el caracter cifrado al resultado */
        $result_message .= $alphabet[$index];
      }

      /* Si el caracter actualmente recorrido del mensaje es un espacio,
      agrega un espacio al resultado */
      if ($current_char == " ") {
        $result_message .= " ";
      }

    }

    echo $result_message;
  }

  function decode($alphabet, $offset, $message) {
    /* Obtiene un arreglo de caracteres pertenecientes al mensaje */
    $array_message = get_array_message($message);

    $alphabet_size = count($alphabet);
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

        /* Agrega el caracter descifrado al resultado */
        $result_message .= $alphabet[$index];
      }

      /* Si el caracter actualmente recorrido es un espacio, agrega un espacio
      al resultado */
      if ($current_char == " ") {
        $result_message .= " ";
      }

    }

    echo $result_message;
  }

  /* Obtiene el valor de la posicion de un caracter dentro de un mapa implementado con un arreglo */
  function getIndex($given_array, $char_message) {

    while ($current_char = current($given_array)) {

      /* Si el caracter de la posicon actual del arreglo es igual al caracter del mensaje, retorna
      el valor de la posicion del caracter del arreglo */
      if ($current_char == $char_message) {
        return key($given_array);
      }

      next($given_array);
    }

  }

  /* Retorna el mensaje convertido en arreglo */
  function get_array_message($message) {
    return str_split($message);
  }

?>
