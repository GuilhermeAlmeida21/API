<?php

require_once '../model/operacao.php';

function  isTheseParametersAvailable($params){
$avalilable = true;
$missingparams = "";

foreach($params as $param){
    if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
        $avalilable = false;
        $missingparams = $missingparams. ", ".$param;
    }
}
if(!$avalilable){
    $response = array();
    $response['error'] = true;
    $response['message'] = 'parameters '.substr($missingparams, 1,strlen($missingparams)).'missing';

    echo json_encode($response);

    die();
}
}

$response = array();

if(isset($_GET['apicall'])){
    switch($get['apicall']){

        case 'createFruta':
            isTheseParametersAvailable(array('campo_2','campo_3','campo_4'));

            $db = new operacao();

            $result = $db->createFruta(
                $_POST['campo_2'],
                $_POST['campo_3'],
                $_POST['campo_4'],

            );

            if($result){
                $response['error'] = false;
                $response['message'] = 'Dados inseridos com sucesso.';
                $response['dadoscreate'] = $db->getFrutas();
            }

        break;
        case 'updateFrutas':
            $db= new operacao();
            $response['error'] = false;
            $response['message'] = 'Dados listados com sucesso.';
            $response['dadoslista'] = $db->getFrutas();

        break;
        case 'getFrutas':
            isTheseParametersAvailable(array('campo_1,campo_2','campo_3','campo_4'));

            $db = new operacao();

            $result = $db->updateFrutas(
                $_POST['campo_1'],
                $_POST['campo_2'],
                $_POST['campo_3'],
                $_POST['campo_4']
            );

            if($result){
                $response['error'] = false;
                $response['message'] = "Dados alterados com sucesso.";
                $response['dadosalterar'] = $db->getFrutas();
            }else{
                $response['error'] = true;
                $response['message'] = "Dados n??o alterados.";
            }

        break;
        case 'deleteFrutas':
            if(isset($_GET['campo_1'])){
                $db = new operacao();
                if($db->deleteFrutas($_GET['campo_1'])){
                    $response['error'] = false;
                    $response['message'] = "Dados excluidos com sucesso";
                    $response['deleteFrutas'] = $db->getFrutas();

                }else{
                    $response['error'] = true;
                    $response['message'] = "algo deu errado";
                }
            }else{
                $response['error'] = true;
                $response['message'] = "Dados n??o apagados.";
            }
        break;

    }
}else{
    $response['error'] = true;
    $response['message'] = "Chamada de Api com defeito";
}

echo json_encode($response);