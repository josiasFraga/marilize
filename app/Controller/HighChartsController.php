<?php
class HighChartsController extends AppController {


    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('generate_image');
    }

    public function generate_image() {
        if (isset($this->request->query['data']) && count($this->request->query['data']) > 0) {
            foreach($this->request->query['data'] as $key => $dado){
                $this->request->query['data'][$key]['y'] = (float)$this->request->query['data'][$key]['y'];

            }

        }


        $optionsStr = [
            //'async' => 'true',
            'type' => 'jpeg',
            'width' => '1400',
            'infile' => [
              "chart" => [
                "plotBackgroundColor" => null,
                "plotBorderWidth" => null,
                "plotShadow" => false,
                "type" => "pie"
              ],
              "title" => [
                "text" => $this->request->query['titulo']
              ],
              "subtitle" => [
                "text" => $this->request->query['subtitle']
              ],
              "tooltip" => [
                "pointFormat" => "{series.name}: <b>{point.percentage:.1f}%</b>"
              ],
              "accessibility" => [
                "point" => [
                  "valueSuffix" => "%"
                ]
              ],
              "plotOptions" => [
                "pie" => [
                  "allowPointSelect" => true,
                  "cursor" => "pointer",
                  "dataLabels" => [
                    "enabled" => true,
                    "format" => "<b>{point.name}</b> - {point.percentage:.1f} %"
                  ]
                ]
              ],
              "series" => [
                [
                  "name" => "Brands",
                  "colorByPoint" => true,
                  "data" => $this->request->query['data']
                ]
              ]
            ]
        ];
        $optionsStr = json_encode($optionsStr);
        //$optionsStr = json_encode($optionsStr);

        //debug($this->curl_postfields_flatten($optionsStr));
        //debug($optionsStr); 
        //$optionsStr = serialize($optionsStr);
        //debug($optionsStr); 
        //debug(http_build_query($optionsStr)); 
        //die();

        
        $url = "http://export.highcharts.com/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen( $optionsStr ), 'Accept: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $optionsStr);
        curl_setopt($ch, CURLOPT_HEADER, 0 );
        curl_setopt($ch, CURLOPT_POST, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $filename = time() . '.jpeg';
        file_put_contents( $filename, $response);
        return new CakeResponse( array( 'type' => 'json', 'body' => json_encode( array( 'status' => 'ok', 'data' => $filename))));

    }
    function curl_postfields_flatten($data, $prefix = '') {
        if (!is_array($data)) {
          return $data; // in case someone sends an url-encoded string by mistake
        }
      
        $output = array();
        foreach($data as $key => $value) {
          $final_key = $prefix ? "{$prefix}[{$key}]" : $key;
          if (is_array($value)) {
            // @todo: handle name collision here if needed
            $output += $this->curl_postfields_flatten($value, $final_key);
          }
          else {
            $output[$final_key] = $value;
          }
        }
        return $output;
      }
}