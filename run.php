<?php
require_once './vendor/autoload.php';
require_once './lib/functions.php';

if(!file_exists(".env")){
  echo "ERROR: Create your .env file";
  exit();
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); //Location of .env file
$dotenv->safeLoad();

$access_token = $_ENV['GC_ACCESS_TOKEN']; //Name of .env variable
$client = new \GoCardlessPro\Client(array(
  'access_token' => $access_token,
  'environment'  => \GoCardlessPro\Environment::SANDBOX //SANDBOX or PRODUCTION
));

$raw = file_get_contents("data.json");
$data = json_decode($raw, true);

if(!empty($data)){
  foreach($data as $record){
      sleep($_ENV['INTERVAL']);
      try {
        $result = $client->refunds()->create([
          "params" => [
            "amount" => $record['amount'],
            "total_amount_confirmation" => $record['total_amount_confirmation'],
            "links" => [
              "payment" => $record['payment_id']
            ]
          ]
        ]);
        if($result->id){
          completedArray($record['payment_id'],$result->id,$result->amount,"SUCCESS",null);
        } else {
          completedArray($record['payment_id'],null,null,"ERROR","UNKNOWN");
        }
      } catch (\GoCardlessPro\Core\Exception\ApiException $e) {
        completedArray($record['payment_id'],null,null,"ERROR", $e->getMessage());
      } catch (\GoCardlessPro\Core\Exception\MalformedResponseException $e) {
        completedArray($record['payment_id'],null,null,"ERROR", $e->getMessage());
      } catch (\GoCardlessPro\Core\Exception\ApiConnectionException $e) {
        completedArray($record['payment_id'],null,null,"ERROR", $e->getMessage());
      }
  }

  $fp = fopen('completed.json', 'w');
  fwrite($fp, json_encode($completed, JSON_PRETTY_PRINT));
  fclose($fp);

  header('Content-Type: application/json');
  echo json_encode($completed);

} else {
  echo "ERROR: No Data Available";
  exit();
}


?>
