<?php
class dataTableComponent extends Component {
	
	public function initialize(Controller $controller) {
	    $this->controller = $controller;
	}

	//função apenas para exemplificar, claro
	public function check_filtro($field, $type) {


		if ( !isset($this->controller->request->data[$field]) )
			return "";

		if ( $this->controller->request->data[$field] == "" )
			return "";
			
		if ($type == "date"){
			if ( !explode("/",$this->controller->request->data[$field]) )
				return false;
			if ( count(explode("/",$this->controller->request->data[$field])) != 3 )
				return false;
			$data_list = explode("/",$this->controller->request->data[$field]);
			if (!checkdate($data_list[1], $data_list[0], $data_list[2]))
				return false;
		}
			
		if ($type == "datetime"){
			if ( !explode(" - ",$this->controller->request->data[$field]) )
				return false;

			list( $data, $hora ) = explode(" - ", $this->controller->request->data[$field]);
			
			if ( count(explode("/", $data)) != 3 )
				return false;
			$data_list = explode("/", $data);
			if (!checkdate($data_list[1], $data_list[0], $data_list[2]))
				return false;
		}

		
		if ($type == "numeric"){
			if ( !is_numeric($this->controller->request->data[$field]) )
				return false;
		}
			
		if ($type == "text"){
			$this->controller->request->data[$field] == trim(strip_tags($this->controller->request->data[$field]));
		}
		
		if ($type == "float"){
			if(!is_float($this->controller->request->data[$field])) {
				$float = str_replace('.','',$this->controller->request->data[$field]);
				$this->controller->request->data[$field] = str_replace(",",".",$float);
				$this->controller->request->data[$field] = floatval($this->controller->request->data[$field]);
			}
		}
		
		return true;
    }
}