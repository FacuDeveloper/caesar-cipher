<?php
  // The global $_POST variable allows you to access the data sent with the POST method by name
  // To access the data sent with the GET method, you can use $_GET
  $option = htmlspecialchars($_POST['option']);
  $offset  = htmlspecialchars($_POST['offset']);
  $message  = htmlspecialchars($_POST['message']);

  $encode_option = "1";
  $decode_option = "2";
  $result_message = '';

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
    '25' => 'z',
    '26' => ' '];

  if (strcmp($option, $encode_option) !== 0 && strcmp($option, $decode_option) !== 0) {
    echo "Las opciones validas son " . $encode_option . " (cifrar) y " . $decode_option . " (descifrar).";
  }

  if (strcmp($option, $encode_option) == 0) {
    echo "Cifrado en proceso...";
    echo "<br>";
    echo "<br>";
    encode($alphabet, $offset, $message);
  }

  if (strcmp($option, $decode_option) == 0) {
    echo "Descifrado en proceso...";
    echo "<br>";
    echo "<br>";
    decode($offset, $message);
  }

  function encode($alphabet, $offset, $message) {
    displayInputData($offset, $message);

    $array_message = str_split($message);
    $alphabet_size = count($alphabet);
    $index;

    foreach ($array_message as $key => $current_char) {
      /* Obtiene el indice, en el alfabeto, de un caracter del mensaje */
      $index = getIndex($alphabet, $current_char);

      /* Calcula el valor de la posicion del caracter de cifrado
      correspondiente al caracter actualmente recorrido */
      $index = ($index + $offset) % $alphabet_size;

      $result_message .= $alphabet[$index];
    }

    echo "Mensaje cifrado: " . $result_message;
  }

  function displayInputData($offset, $message) {
    echo "Clave: " . $offset;
    echo "<br>";
    echo "Mensaje: " . $message;
    echo "<br>";
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

?>
