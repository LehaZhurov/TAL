<?

namespace TAL;

class TAL{


	public function __construct($key){
		$this->key 			= $key;
		$this->tg_url 		= 'https://api.telegram.org/bot'.$key;
		
	}	
	//Получение BotKey
	public function GetKey(){
		return $this->key;
	}
	//Получеие URL
	public function GetTGUrl(){
		return $this->tg_url;
	}
	//Получение текста сообщения 
	public function getText(){
		return $this->text;
	}
	//Получение id сообщения 
	public function getMessageId(){
		return $this->message_id;
	}
	//Получене ChatId
	public function getChatId(){
		return $this->chat_id;
	}
	//Функция для получения 
	public function GetUpdate(){
		$data = $this->TGRequest('getUpdates');
		//Если удлаось получить обновления то возврощате результат , а если нет то весь объект с ошибкой
		if(!$data['ok']){
			$this->data = $data;
            echo 'Ошибка получения данных';
            exit();
		}else{
			$this->data = $data = array_pop($data['result']);
		}
	}
	//Получение данных котрые присылает телеграм по фебхуку
	public function getWebhookUpdates()
    {
        $body = json_decode(file_get_contents('php://input'), true);
        $this->data = $body;
    }
	// Получение всех данных колбек запроса
	public function GetCallbackQuery(){
		return $this->data['callback_query'];
	}
	//Получене callback_data
	public function GetCallbackData(){
		return $this->data['callback_query']['data'];
	}
    //возврощает чат id чата из которого был вызван колбек
    public   function    GetCallbackChatId(){
        return $this->data['callback_query']['from']['id'];
    }
	//метод возврощает данные сообщения 
    public function GetData(){
    	return $this->data;
    }
    //служебный метод ля выполнения запросов к телеграму 
	private function TGRequest($method, $data = array()){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$this->tg_url.'/'.$method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); 
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 
        $out = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return $out;
    }
   	//отпрака сообещия с клавиатурой снизу
    public function SendMessageAndInlineKeyboard($chat_id,$text,$keyboard = false){
    	$data=array(
             'chat_id' => $chat_id,
             'text' => $text
        );
        //Если клавиатуру не false то добовляем его в data и отпровляем
    	if($keyboard != false){
        	$data['reply_markup']=json_encode(array('inline_keyboard' => $keyboard));
    	}
    	$result = $this->TGRequest('sendMessage',$data);
    	//Проверка удачноли сообщение отпралвено
    	if($result['ok']){
    		return true;
    	}else{
    		var_dump($result);//Если нет то распечатает объект с ошибкой от телеграмма
    	}
    }
    //Отправка сообещния с клавитурой или без неё
    public function SendMessage($chat_id,$text,$keyboard = false){
    	$data=array(
             'chat_id' => $chat_id,
             'text' => $text
        );
    	if($keyboard != false){
        	$data['reply_markup']=json_encode(array('keyboard' => $keyboard,'resize_keyboard' => true));
    	}
    	$result = $this->TGRequest('sendMessage',$data);
    	//Проверка удачноли сообщение отпралвено
    	if($result['ok']){
    		return true;
    	}else{
    		var_dump($result);//Если нет то вернет объект с ошибекой от телеграмма
    	}
    }
    //Изменить уже отправленное сообщение 
    public function editMessage($chat_id,$mess_id,$text,$reply_markup = array()){
        $data=array(
             'chat_id' => $chat_id,
             'message_id' => $mess_id,
             'text' => $text
        );
        $data['reply_markup']=json_encode(array('inline_keyboard' => $reply_markup));
        $this->TGRequest('editMessageText', $data); 
        if($result['ok']){
            return true;
        }else{
            var_dump($result);//Если нет то вернет объект с ошибекой от телеграмма
        }
    }
    //перссылка сообщения 
    public function forwardMessage($chat_id,$from_chat_id,$message_id){
    	$data=array(
             'chat_id' => $chat_id,
             'from_chat_id' => $from_chat_id,
             'message_id' => $message_id
        );
    	$result = $this->TGRequest('forwardMessage',$data);
    	//Проверка удачноли сообщение отпралвено
    	if($result['ok']){
    		return true;
    	}else{
    		return $result;//Если нет то вернет объект с ошибекой от телеграмма
    	}
    }
    //копироание текста собщения
    public function copyMessage($chat_id,$from_chat_id,$message_id,$caption = false){
    	$data=array(
             'chat_id' => $chat_id,
             'from_chat_id' => $from_chat_id,
             'message_id' => $message_id,
             'caption'    => $caption
        );
        $result = $this->TGRequest('copyMessage',$data);
    	//Проверка удачноли сообщение отпралвено
    	if($result['ok']){
    		return true;
    	}else{
    		return $result;//Если нет то вернет объект с ошибекой от телеграмма
    	}
    }
    //Отправка фото
    public function sendPhoto($chat_id,$url,$caption = false){
    	$data=array(
             'chat_id' 	  => $chat_id,
             'photo' 	  => $url,
             'caption'    => $caption
        );
        $result = $this->TGRequest('sendPhoto',$data);
    	//Проверка удачно ли сообщение отпралвено
    	if($result['ok']){
    		return true;
    	}else{
    		return $result;//Если нет то вернет объект с ошибкой от телеграмма
    	}
    }
    //Отправка аудио
    public function sendAudio($chat_id,$url,$caption = false){
    	$data=array(
             'chat_id' 	  => $chat_id,
             'audio' 	  => $url,
             'caption'    => $caption
        );
        $result = $this->TGRequest('sendAudio',$data);
    	//Проверка удачноли сообщение отпралвено
    	if($result['ok']){
    		return true;
    	}else{
    		return $result;//Если нет то вернет объект с ошибкой от телеграмма
    	}
    }
    //Отправка файла
    public function sendFile($chat_id,$url,$caption = false){
    	$data=array(
             'chat_id' 	  => $chat_id,
             'document' 	  => $url,
             'caption'    => $caption
        );
        $result = $this->TGRequest('sendDocument',$data);
    	//Проверка удачноли сообщение отпралвено
    	if($result['ok']){
    		return true;
    	}else{
    		return $result;//Если нет то вернет объект с ошибкой от телеграмма
    	}
    }
    //Отправка видео
    public function sendVideo($chat_id,$url,$caption = false){
    	$data=array(
             'chat_id' 	  => $chat_id,
             'video' 	  => $url,
             'caption'    => $caption
        );
        $result = $this->TGRequest('sendDocument',$data);
    	//Проверка удачноли сообщение отпралвено
    	if($result['ok']){
    		return true;
    	}else{
    		return $result;//Если нет то вернет объект с ошибкой от телеграмма
    	}
    }
    //Отправка GIF
    public function sendAnimation($chat_id,$url,$caption = false){
    	$data=array(
             'chat_id' 	  => $chat_id,
             'animation' 	  => $url,
             'caption'    => $caption
        );
        $result = $this->TGRequest('sendAnimation',$data);
    	//Проверка удачноли сообщение отпралвено
    	if($result['ok']){
    		return true;
    	}else{
    		return $result;//Если нет то вернет объект с ошибкой от телеграмма
    	}
    }
    //Отправка группы картинок или аудио или видео
    public function SendMediaGroup($chat_id,$array_media,$caption = false){
    	$data=array(
             'chat_id' 	  => $chat_id,
             'media' 	  => json_encode($array_media),
             'caption'    => $caption
        );
        $result = $this->TGRequest('sendMediaGroup',$data);
    	//Проверка удачноли сообщение отпралвено
    	if($result['ok']){
    		return true;
    	}else{
    		return $result;//Если нет то вернет объект с ошибкой от телеграмма
    	}
    }
    //Отправка списка команд
    public function setBotCommands($command_array){
        $data = array(
            'commands' => json_encode($command_array)
        );
        $result = $this->TGRequest('setMyCommands',$data);
        if($result['ok']){
            return true;
        }else{
            return $result;//Если нет то вернет объект с ошибкой от телеграмма
        }
    }
    //Удаление списка команд
    public function deleteBotCommands(){
        $result = $this->TGRequest('deleteMyCommands');
         if($result['ok']){
            return true;
        }else{
            return $result;//Если нет то вернет объект с ошибкой от телеграмма
        }
    }
    //Устанавливает меню бота 
    public function setBotMenu($chat_id,$menu_button = array()){
        $data = array(
            'chat_id' => $chat_id,
            'menu_button' => $menu_button
        );
        $result = $this->TGRequest('setChatMenuButton',$data);
        if($result['ok']){
            return true;
        }else{
            return $result;//Если нет то вернет объект с ошибкой от телеграмма
        }
    }
    public function deleteBotMenu($chat_id){
        $result = $this->TGRequest('deleteMyCommands');
         if($result['ok']){
            return true;
        }else{
            return $result;//Если нет то вернет объект с ошибкой от телеграмма
        }
    }
    //Сохранение присланое пользователем фото 
    //Принимает значение от 0 до 3 , в соотвестви размера фото 0 самое мальнькое а 3 самое большое 
    public function SaveUserPhoto($size_num,$dir,$name = 'noname',$format = 'jpg'){
		//Сыллка на получение путя к файлу
		$img_id = $this->data['message']['photo'][$size_num]['file_id'];
        $telegram_link          = 'https://api.telegram.org/bot' .$this->getKey(). '/getFile?file_id='.$img_id;
        //Получение пути к файлу
        $file_path              = json_decode(file_get_contents($telegram_link))->result->file_path;
        //Соствленая ссылка на сам файл на сервере телеграм
        $photo_link_telegram    = 'https://api.telegram.org/file/bot'.$this->getKey().'/'.$file_path;
        //Путь где должен хранится файл на сервере
        //Сохранение файла
        $file_path = $dir.'/'.$name.'.'.$format;
        file_put_contents($file_path, file_get_contents($photo_link_telegram));
        return $file_path;    	
    }
    //сохраняет файл прислаый пользователем в указанную директорию
    public function SaveUserDocument($dir){
		//Сыллка на получение путя к файлу
		$doc_id = $this->data['message']['document']['file_id'];
        $telegram_link          = 'https://api.telegram.org/bot' .$this->getKey(). '/getFile?file_id='.$doc_id;
        //Получение пути к файлу
        $file_path              = json_decode(file_get_contents($telegram_link))->result->file_path;
        //Соствленая ссылка на сам файл на сервере телеграм
        $doc_link_telegram      = 'https://api.telegram.org/file/bot'.$this->getKey().'/'.$file_path;
        //Путь где должен хранится файл на сервере
        //Сохранение файла
        $file_path = $dir."/".$this->data['message']['document']['file_name'];
        file_put_contents($file_path, file_get_contents($doc_link_telegram));
       	return $file_path;    	
    }
    //Сохроняте аудиофайл присланый пользователем
    public function SaveUserAudio($dir){
        //Сыллка на получение путя к файлу
        $audio_id = $this->data['message']['audio']['file_id'];
        $telegram_link          = 'https://api.telegram.org/bot' .$this->getKey(). '/getFile?file_id='.$audio_id;
        //Получение пути к файлу
        $file_path              = json_decode(file_get_contents($telegram_link))->result->file_path;
        //Соствленая ссылка на сам файл на сервере телеграм
        $doc_link_telegram      = 'https://api.telegram.org/file/bot'.$this->getKey().'/'.$file_path;
        //Путь где должен хранится файл на сервере
        //Сохранение файла
        $file_path = $dir."/".$this->data['message']['audio']['file_name'];
        file_put_contents($file_path, file_get_contents($doc_link_telegram));
        return $file_path;      
    }
}



?>