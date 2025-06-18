<?php


$password = '12345';


$passwordHasheado = password_hash($password, PASSWORD_BCRYPT);

echo json_encode($passwordHasheado);


// Supongamos que esta es la contraseña que el usuario ingresó
// $password = '12345';

// // Supongamos que este es el hash que tienes guardado en la base de datos
// $passwordHasheado = '$2y$10$yP68cM/w/neT8CW29ZDKXejLeiMOvbyfIgXa//SzPzWCL5OrcR5yS'; // Este es un ejemplo

// // Verificamos si la contraseña ingresada coincide con el hash
// if (password_verify($password, $passwordHasheado)) {
//      var_dump("contraseña es válida");
// } else {
//     var_dump("La contraseña es incorrecta");
// }
