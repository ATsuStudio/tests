<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1->0">
    <title>Delivery calc</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        #main-wrapper {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .delivery-json {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        h4 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    
<?php
    // php7.1
    // CDEK api service for example
    $API_URL = 'https://api.cdek.ru/';
    abstract class DeliveryModule {
        protected $_base_url;
        protected $_sourceKladr;
        protected $_targetKladr;
        protected $_weight;
        public function __construct($base_url, $sourceKladr, $targetKladr, $weight) {
            $this->_base_url = $base_url;
            $this->_sourceKladr = $sourceKladr;
            $this->_targetKladr = $targetKladr;
            $this->_weight = $weight;
        }
        
        abstract public function Сalculate();
        abstract protected function ApiGetRequest();
        }
    
    class FastDelivery extends DeliveryModule {
        
        public function Сalculate() {
	        $restult = [
                'price'=>'',
                'date' =>'',
                'error'=>''
            ];
            $apiRequest = $this->ApiGetRequest();
            $coefficient = 1;
            $date = date('Y-m-d', strtotime($apiRequest['tariff_codes']['period_min'] . 'days'));
            if(!$apiRequest){
                $restult->error = "error when receiving data from the server";
                return $restult;
            }
            $restult['price'] = $apiRequest['tariff_codes']['delivery_sum'] * $coefficient;
            $restult['date'] = $date;
            return json_encode($restult);
        }
        protected function ApiGetRequest(){
            // Some request to transfer company
            // For example curl_setopt GET REQUEST: https://api.cdek.ru/?id=$api_id&form=$this->_sourceKladr&to=$this->_targetKladr&weight=$this->_weight
            return([
                "tariff_codes"=> [
                        "tariff_code"=> 1,
                        "tariff_name"=> "Экспресс склад-склад",
                        "tariff_description"=> "Классическая экспресс-доставка документов и грузов по всей территории России ...",
                        "delivery_mode"=> 1,
                        "delivery_sum"=> 3135.0,
                        "period_min"=> 2,
                        "period_max"=> 2
                    ]
                ]
            );
        }
    }
    
    class SlowDelivery extends DeliveryModule {
        
        public function Сalculate() {
	        $restult = [
                'price'=>'',
                'date' =>'',
                'error'=>''
            ];
            $apiRequest = $this->ApiGetRequest();
            $coefficient = 1.123;
            $date = date('Y-m-d', strtotime($apiRequest['tariff_codes']['period_min'] . 'days'));
            if(!$apiRequest){
                $restult->error = "error when receiving data from the server";
                return $restult;
            }
            $restult['price'] = $apiRequest['tariff_codes']['delivery_sum'] * $coefficient;
            $restult['date'] = $date;
            return json_encode($restult);
        }
        protected function ApiGetRequest(){
            // Some request to transfer company
            // For example https://api.cdek.ru/?form=$this->_sourceKladr&to=$this->_targetKladr&weight=$this->_weight
            return([
                "tariff_codes"=> [
                        "tariff_code"=> 10,
                        "tariff_name"=> "Экспресс лайт склад-склад",
                        "tariff_description"=> "Отправитель самостоятельно доставляет груз/документы в офис ...",
                        "delivery_mode"=> 2,
                        "delivery_sum"=> 960.0,
                        "period_min"=> 5,
                        "period_max"=> 5
                    ]
                ]
            );
        }
    }

    $fastDel = new FastDelivery($API_URL,"Moscow","Ufa",20);
    $slowDel = new SlowDelivery($API_URL,"Moscow","Ufa",20);

?>
    <div id='main-wrapper'>
        <h3>Delivery from Moscow, to Ufa, weigth 20, transCompanty cdek</h3>
        <div class='delivery-json' id='fast-delivery-json'>
            <h4>Fast Delivery</h4>
            <pre><?php echo json_encode(json_decode($fastDel->Сalculate(), true), JSON_PRETTY_PRINT); ?></pre>
        </div>
        <div class='delivery-json ' id='slow-delivery-json'>
            <h4>Slow Delivery</h4>
            <pre><?php echo json_encode(json_decode($slowDel->Сalculate(), true), JSON_PRETTY_PRINT); ?></pre>
        </div>
    </div>



</body>
</html>
