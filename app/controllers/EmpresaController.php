 <?php

 require_once '../models/Empresa.php';


//  if (isset($_SERVER['REQUEST_METHOD'])){
//     header('Content-Type: application/json; charset=utf-8');

//     $empresa = new Empresa();

//     switch ($_SERVER['REQUEST_METHOD']){
        
//         case 'POST':
//             $input = file_get_contents('php://input');
//             $dataJSON = json_decode($input);

//             if ($dataJSON === null && json_last_error() !== JSON_ERROR_NONE){

//                 echo json_encode([
//                     "status" => "error",
//                     "message" => "Error al decodificar los datos JSON."
//                 ]);
//                 break;
//             }
//             $registro = [
//                 'nombrecomercial' => htmlspecialchars($dataJSON['nombrecomercial'] ??''),
//                 'direccion'=> htmlspecialchars($dataJSON['direccion'] ??''),
//                 'ruc'=> htmlspecialchars($dataJSON['ruc'] ?? ''),
//                 'razonsocial'=> htmlspecialchars($dataJSON['razonsocial'] ?? '')
//             ];

//             try {
//                 $result = $empresa->add($registro);
//                 echo json_encode([
//                     'status'=> 'success',
//                     'message'=> 'Empresa agregada correctamente'
                
//                 ]);
//             } catch (Exception $e) {
//                 echo json_encode([
//                     'status'=> 'error',
//                     'message'=> $e->getMessage()
//                 ]);
//             }
//             break;




//  }
// }