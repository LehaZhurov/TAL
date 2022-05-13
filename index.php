<?
require 'TAL.php';
use TAL\TAL;

$tal = New TAL('ВАш ключ');
$tal->getWebhookUpdates();
$text 		= $tal->data['message']['text'];
$message_id	= $tal->data['message']['message_id'];
$chat_id    = $tal->data['message']['chat']['id'];


//Ответ на call-back кнопки
if($tal->GetCallbackQuery()){
	$tal->SendMessage($tal->GetCallbackChatId(),$tal->GetCallbackData());
	exit();
}
//Сохранение присланых фото
if($tal->data['message']['photo']){
	$result = $tal->SaveUserPhoto(0,'photos',$tal->data['message']['message_id']);
	$file_path = $_SERVER['DOCUMENT_ROOT']."/".$result;
	$tal->sendMessage($chat_id,"Файл cохранен в ".$file_path);
	exit();
}
//Сохранение присланых документов
if($tal->data['message']['document']){
	$result = $tal->SaveUserDocument('documents');
	$file_path = $_SERVER['DOCUMENT_ROOT']."/".$result;
	$tal->sendMessage($chat_id,"Файл cохранен в ".$file_path);
}
//Сохранение присланых фото
if($tal->data['message']['audio']){
	$result = $tal->SaveUserAudio('audio');
	$file_path = $_SERVER['DOCUMENT_ROOT']."/".$result;
	$tal->sendMessage($chat_id,"Файл cохранен в ".$file_path);
}

$method_list = [
['SendMessage'],['SendMessageAndInlineKeyboard'],['editMessage'],['forwardMessage'],['copyMessage'],['sendPhoto'],
['sendFile'],['sendVideo'],['sendAnimation'],['sendMediaGroup'],['setBotCommands'],['deleteBotCommands'],['SaveUserPhoto'],
['SaveUserDocument'],['SaveUserAudio']
];

if($text == '/start'){
	$text = 'Привет я бот,который раскажет тебе о классе TALPHP.Выбери метод чтоб узнать больше';
	$tal->SendMessage($chat_id,$text,$method_list);
}elseif($text == 'SendMessage'){
	$text = 
	'Метод SendMessage , принимает 3 аргумента'."\r\n".
	'1)$chat_id - чат куда отправить сообщение(обязательный,числовой)'."\r\n".
	'2)$text- текст сообщения (обязательный,строка)'."\r\n".
	'3)$keyboard - клавиатура которая будет под полем ввода(необязательный,массив в массиве)';
	$tal->SendPhoto($chat_id,'https://prnt.sc/gFoxLyD5bLYk',$text);
}elseif($text == 'SendMessageAndInlineKeyboard'){
	$text = 
	'Метод SendMessageAndInlineKeyboard , принимает 3 аргумента'."\r\n".
	'1)$chat_id - чат куда отправить сообщение(обязательный,числовой)'."\r\n".
	'2)$text- текст сообщения (обязательный,строка)'."\r\n".
	'3)$keyboard - клавиатура которая будет под сообщением(необязательный,массив в массиве с массивом)'."\r\n".
	'Отличие это метода в том что он поддерживает отправку сообщения с клавиатурой';
	$tal->SendPhoto($chat_id,'https://prnt.sc/Wh_pUr8-SerD',$text);
	//Отправка примера клавиатуры
	$keyboard = array(array(array('text'=>'Алекс' ,'callback_data'=>'["id" => "2","name" => "Alex"]')),array(array('text'=>'Светлана','callback_data'=>'["id" => "2","name" => "Svetlana"]')));
	$tal->SendMessageAndInlineKeyboard($chat_id,'У меня есть клавиатура',$keyboard);
}elseif($text == 'editMessage'){
	$text = 
	'Метод editMessage , принимает 4 аргумента.Это метод изменятет уже отправленное сообщение'."\r\n".
	'1)$chat_id - чат где нужно изменить сообщение(обязательный,числовой)'."\r\n".
	'2)$mess_id - id сообщения которое нужно изменить(обязательный,числовой)'."\r\n".
	'3)$text- текст сообщения (обязательный,строка)'."\r\n".
	'4)$keyboard - клавиатура которая будет под сообщением(необязательный,массив в массиве с массивом)'."\r\n";
	$tal->SendPhoto($chat_id,'https://prnt.sc/cog_jeHwtSbQ',$text);
}elseif($text == 'forwardMessage'){
	$text = 
	'Метод forwardMessage, принимает 3 аргумента.Это метод перессылает сообщение.'."\r\n".
	'1)$chat_id - куда отправить сообщение (обязательный,числовой)'."\r\n".
	'2)$from_chat_id - откуда отправить сообщение (обязательный,числовой)'."\r\n".
	'3)$message_id - id сообщения которое нужно переслать (обязательный,числовой)'."\r\n";
	$tal->SendPhoto($chat_id,'https://prnt.sc/CpAg_hP8PQTH',$text);
}elseif($text == 'copyMessage'){
	$text = 
	'Метод copyMessage, принимает 3 аргумента.Это копирует текст сообщения отпровляет его.'."\r\n".
	'1)$chat_id - куда отправить сообщение (обязательный,числовой)'."\r\n".
	'2)$from_chat_id - откуда копировать текст сообщения (обязательный,числовой)'."\r\n".
	'3)$message_id - id сообщения которое нужно копировать (обязательный,числовой)'."\r\n";
	$tal->SendPhoto($chat_id,'https://prnt.sc/01_Vo3gY7U8A',$text);
}elseif($text == 'sendPhoto'){
	$text = 
	'Метод sendPhoto, принимает 3 аргумента.Отпровляет фото в чат.'."\r\n".
	'1)$chat_id - куда отправить фото (обязательный,числовой)'."\r\n".
	'2)$url 	- ссылка на фото (обязательный,строковый)'."\r\n".
	'3)$caption - подпись(необязательный,строковый)';
	$tal->SendPhoto($chat_id,'https://prnt.sc/mGxSGNLLhQoW',$text);
}elseif($text == 'sendAudio'){
	$text = 
	'Метод sendPhoto, принимает 3 аргумента.Отпровляет аудио в чат.'."\r\n".
	'1)$chat_id - куда отправить аудио (обязательный,числовой)'."\r\n".
	'2)$url 	- ссылка на аудио (обязательный,строковый)'."\r\n".
	'3)$caption - подпись(необязательный,строковый)';
	$tal->SendPhoto($chat_id,'https://prnt.sc/mGxSGNLLhQoW',$text);
}elseif($text == 'sendFile'){
	$text = 
	'Метод sendFile, принимает 3 аргумента.Отпровляет файл в чат.'."\r\n".
	'1)$chat_id - куда отправить файл (обязательный,числовой)'."\r\n".
	'2)$url 	- ссылка на файл (обязательный,строковый)'."\r\n".
	'3)$caption - подпись(необязательный,строковый)';
	$tal->SendPhoto($chat_id,'https://prnt.sc/GuK-Os3tPq5F',$text);
}elseif($text == 'sendVideo'){
	$text = 
	'Метод sendVideo, принимает 3 аргумента.Отпровляет видео в чат.'."\r\n".
	'1)$chat_id - куда отправить файл (обязательный,числовой)'."\r\n".
	'2)$url 	- ссылка на файл (обязательный,строковый)'."\r\n".
	'3)$caption - подпись(необязательный,строковый)';
	$tal->SendPhoto($chat_id,'https://prnt.sc/qlTXWgMJunIO',$text);
}elseif($text == 'sendAnimation'){
	$text = 
	'Метод sendAnimation, принимает 3 аргумента.Отпровляет gif-ку в чат.'."\r\n".
	'1)$chat_id - куда отправить файл (обязательный,числовой)'."\r\n".
	'2)$url 	- ссылка на файл (обязательный,строковый)'."\r\n".
	'3)$caption - подпись(необязательный,строковый)';
	$tal->SendPhoto($chat_id,'https://prnt.sc/aLXywxZ4WXnV',$text);
}elseif($text == 'sendMediaGroup'){
	$text = 
	'Метод sendMediaGroup, принимает 3 аргумента.Отпровляет групированные картинки или видео,на примере идет отправка группы картинок.'."\r\n".
	'1)$chat_id - куда отправить файл (обязательный,числовой)'."\r\n".
	'2)$array_media 	- массив с типом и ссылкой на отпровляемое медиа (обязательный,строковый)'."\r\n".
	'3)$caption - подпись(необязательный,строковый)';
	$tal->SendPhoto($chat_id,'https://prnt.sc/8tOcu4KSQ-fb',$text);
}elseif($text == 'setBotCommands'){
	$text = 'Метод setBotCommands, принимает 1 аргумент.Устанвливает команды для бота'."\r\n".
	'1)$command_array - массив команд (обязательный,массив с объектами)'."\r\n";
	$tal->SendPhoto($chat_id,'https://prnt.sc/ogNlymEuXi7Z',$text);
}elseif($text == 'deleteBotCommands'){
	$text = 'Метод deleteBotCommands просто удаляет команды бота , которые вы могли устновить рание'."\r\n".
	'1)$command_array - массив команд (обязательный,массив с объектами)'."\r\n";
	$tal->SendMessage($chat_id,$text);
}elseif($text == 'SaveUserPhoto'){
	$text = 'Метод SaveUserPhoto сохранить фото или группу фото,которые прислал пользователь боту'."\r\n".
	'1)$size_num - Принимает значение от 0 до 3 , в соотвестви размера фото 0 самое мальнькое а 3 самое большое (обязательный,числовой)'."\r\n".
	'2)$dir - название или путь до директории(обязательный,строковый)'."\r\n".
	'3)$name - название файла(обезательный,строковый)'."\r\n".
	'4)$format - расширение файла((обезательный,строковый),по умолчанию = jpg)';
	$tal->sendPhoto($chat_id,'https://prnt.sc/5o2Tel_Fa3ok',$text);
}elseif($text == 'SaveUserDocument'){
	$text = 'Метод SaveUserDocument сохранить документ или группу документов,которые прислал пользователь боту'."\r\n".
	'1)$dir - название или путь до директории(обязательный,строковый)'."\r\n";
	$tal->SendPhoto($chat_id,'https://prnt.sc/EJRUgpQrGPtz',$text);
}elseif($text == 'SaveUserAudio'){
	$text = 'Метод SaveUserAudio сохранить аудио или группу аудио,которые прислал пользователь боту'."\r\n".
	'2)$dir - название или путь до директории(обязательный,строковый)'."\r\n";
	$tal->SendPhoto($chat_id,'https://prnt.sc/BXO0VQFTVBm1',$text);
}else{
	$text = 'Лалалалалалал я вас не понимаю';
	$tal->sendMessage($chat_id,$text);
}





?>
