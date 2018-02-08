<?php
/* 
https://api.slack.com/slash-commands
https://api.slack.com/docs/message-formatting
https://api.slack.com/docs/message-attachments
*/

header('Content-Type: application/json; charset=utf-8');

//$valid_tokens = array('PECEF2WJNDcEPf3mqzifPHj9');
$valid_tokens = array();

$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : '';
$itens = isset($_REQUEST['text'])  ? array_map('trim', explode( ",", $_REQUEST['text']))  : false;

$response = array(
	'response_type' => 'in_channel',
	'text' => '...',
	'attachments' => array([
		'text' => '...',
		'color' => '#92ED11',
		'mrkdwn_in' => array("text", "pretext")
	])
);

if( count($valid_tokens)==0 || in_array($token, $valid_tokens) ){

	if ($itens){

		$itens = array_map('trim', $itens);

		$response['text'] = "E o escolhido entre ";
		for($a=0; $a<count($itens); $a++){
			$response['text'] .= ($a==0?'':($a<count($itens)-1?', ':' e '))."`".$itens[$a]."`";
		}
		$response['text'] .= " foi...";

		$response['attachments'][0]['text'] = '*'.strtoupper($itens[array_rand($itens, 1)]).'*';

	}else{

		$response['response_type'] = 'ephemeral';
		$response['text'] = "Digite os itens separados por vírgula.";
		unset($response['attachments']);

	}

}else{

	$response['response_type'] = 'ephemeral';
	$response['text'] = "Invalid command token.";
	unset($response['attachments']);

}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>