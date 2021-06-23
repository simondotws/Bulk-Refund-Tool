<?php
function completedArray($payment_id, $refund_id, $amount, $result, $message){
  Global $completed;
  $arr = [
    "payment_id" => $payment_id,
    "refund_id" => $refund_id,
    "result" => $result,
    "amount" => $amount,
    "message" => $message
  ];
  $completed[] = $arr;
}
?>
