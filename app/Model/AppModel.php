<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public $recursive = -1;
	public $actsAs = array('Linkable');

	protected function currencyToFloat($currency) {
		// return (float) preg_replace('/\D/', '', $currency) / 100;
		if (!is_float($currency) && preg_match('/\D/', $currency)) {
			return (float) preg_replace('/\D/', '', $currency) / 100;
		}
		return $currency;
	}

	public function dateBrEn( $data ) {
		$data = explode("/",$data);
		if (isset($data[0]) && isset($data[1]) && isset($data[2])) {
			$data = $data[2]."-".$data[1]."-".$data[0];
		} else {
			$data = $data[0];
		}

		$data = date("Y-m-d", strtotime($data));
		return $data;
	}

	public function dateEnBr( $data ) {
		$data = date("d/m/Y", strtotime($data));
		return $data;
	}

	public function moneyBrEn($data = null) {
		if ( empty($data) )
			return 0;

        $data = str_replace('R$','',$data);
        $data = str_replace(' ','',$data);
        $data = str_replace('.','',$data);
        $data = str_replace(',','.',$data);
        return $data;
	}

	public function dateTimeEnBr( $data ) {
		$data = date("d/m/Y H:i:s", strtotime($data));
		return $data;
	}

	public function dateTimeBrEn( $data_tempo ) {
		list($data,$hora) = explode(" ",$data_tempo);
		list($dia,$mes,$ano) = explode('/',$data);
		return $ano."-".$mes."-".$dia." ".$hora;
	}

	public function horaParaMinuto( $hora ) {
		$tempo = explode(':', $hora);
		$minutos = $tempo[0] * 60;
		$minutos+= $tempo[1];
		return $minutos;
	}

	public function validateDate($date, $format = 'Y-m-d H:i:s') {
    	$d = DateTime::createFromFormat($format, $date);
    	return $d && $d->format($format) == $date;
    }
    
}
