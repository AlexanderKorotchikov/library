<?php

class Controller {

	/**
	 * Валидатор входящих данных $_POST
	 */
	public function validateForm($data){
		if(isset($data['name'])){
			if ($data['name'] != ''){
				$data['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
				if ($data['name'] == "") return false;
			}elseif(isset($data['name'])) return false;	
		}
		
		if(isset($data['surname'])){
			if ($data['surname'] != ''){
				//echo 'surname'. '<br>';
				$data['surname'] = filter_var($data['surname'], FILTER_SANITIZE_STRING);
				if ($data['surname'] == "") return false;
			}elseif(isset($data['surname'])) return false;
		}
		
		if(isset($data['patronymic'])){
			if ($data['patronymic'] != ''){
				//echo 'patronymic'. '<br>';
				$data['patronymic'] = filter_var($data['patronymic'], FILTER_SANITIZE_STRING);
				if ($data['patronymic'] == "") return false;
			}elseif(isset($data['patronymic'])) return false;
		}

		if(isset($data['genre'])){
			if ($data['genre'] != ''){
				$data['genre'] = filter_var($data['genre'], FILTER_SANITIZE_STRING);
				if ($data['genre'] == "") return false;
			}elseif(isset($data['genre'])) return false;
		}
		 if (isset($data['date'])){
			if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$data['date'])) {
				return false;
			}
		}

		if(isset($data['description'])){
			if ($data['description'] != ''){
				$data['description'] = filter_var($data['description'], FILTER_SANITIZE_STRING);
				if ($data['description'] == "") return false;
			}elseif(isset($data['description'])) return false;
		}
		return true;
	}
}

