<?php

namespace App\ThirdParty;

use Exception;
/*
 * class name: firebaseRDB
 * version: 1.0
 * author: Devisty
 */

class firebaseRDB extends Exception {
	
	public $url = "https://pruebas-php-1b41d-default-rtdb.firebaseio.com";

	function __construct($url=null) {
		if(isset($url) || !is_null($this->url)){
			if (isset($url)){
				$this->url = $url;
			}
		}else{
			throw new Exception("Database URL must be specified");
		}
	}

	public function grab($url, $method, $par=null){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if(isset($par)){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $par);
		}
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$html = curl_exec($ch);
		return $html;
		curl_close($ch);
	}

	public function insert($table, $data = null){
		$path = $this->url."/$table.json";
		$data = is_null($data) ? null : json_encode($data);
		$grab = $this->grab($path, "POST", $data);
		return $grab;
	}

	public function update($table, $uniqueID, $data){
		$path = $this->url."/$table";
		$path .= (!is_null($uniqueID) ? "/{$uniqueID}" : "") . ".json";
		$grab = $this->grab($path, "PATCH", json_encode($data));
		return $grab;
	}

	public function delete($table, $uniqueID = null){
		$path = $this->url."/$table";
		$path .= (!is_null($uniqueID) ? "/{$uniqueID}" : "") . ".json";
		$grab = $this->grab($path, "DELETE");
		return $grab;
	}

	public function retrieve($dbPath, $queryKey=null, $queryType=null, $queryVal =null){
		if(isset($queryType) && isset($queryKey) && isset($queryVal)){
			$queryVal = urlencode($queryVal);
			if($queryType == "EQUAL"){
					$pars = "orderBy=\"$queryKey\"&equalTo=\"$queryVal\"";
			}elseif($queryType == "LIKE"){
					$pars = "orderBy=\"$queryKey\"&startAt=\"$queryVal\"";
			}
		}
		$pars = isset($pars) ? "?$pars" : "";
		$path = $this->url."/$dbPath.json$pars";
		$grab = $this->grab($path, "GET");
		$grab = json_decode($grab);
		if (isset($grab->error)) {
			if ($grab->error == "Permission denied")
				$grab->error = "No tiene permisos para acceder a firebase";
		}
		return $grab;
	}

}
