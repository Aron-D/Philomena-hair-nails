<?php
namespace _PhpScoper5e55118e73ab9;
include './database.php';
/*
 * How to prepare an iDEAL payment with the Mollie API.
 */
try {
    /*
     * Initialize the Mollie API library with your API key.
     *
     * See: https://www.mollie.com/dashboard/developers/api-keys
     */
    require "initialize.php";
    /*
     * First, let the customer pick the bank in a simple HTML form. This step is actually optional.
     */
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        $method = $mollie->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers"]);
        echo '<form method="post">Select your bank: <select name="issuer">';
        foreach ($method->issuers() as $issuer) {
            echo '<option value=' . \htmlspecialchars($issuer->id) . '>' . \htmlspecialchars($issuer->name) . '</option>';
        }
        echo '<option value="">or select later</option>';
        echo '</select><button>OK</button></form>';
        exit;
    }
    /*
     * Generate a unique order id for this example. It is important to include this unique attribute
     * in the redirectUrl (below) so a proper return page can be shown to the customer.
     */
    $orderId = \time();
    /*
     * Determine the url parts to these example files.
     */
    $protocol = isset($_SERVER['HTTPS']) && \strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
    $hostname = $_SERVER['HTTP_HOST'];
    $path = \dirname(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']);
    /*
     * Payment parameters:
     *   amount        Amount in EUROs. This example creates a € 27.50 payment.
     *   method        Payment method "ideal".
     *   description   Description of the payment.
     *   redirectUrl   Redirect location. The customer will be redirected there after the payment.
     *   webhookUrl    Webhook location, used to report when the payment changes state.
     *   metadata      Custom metadata that is stored with the payment.
     *   issuer        The customer's bank. If empty the customer can select it later.
     */

    session_start();
    $appointmentId = $_SESSION['appointment_id'];
    $amountprice = 0;
    $totalprice = 0;

    //Eerste stmt
    $stmt = $database->prepare("SELECT * FROM appointment WHERE id = $appointmentId");
    $stmt->execute();
    $row = $stmt->fetch(\PDO::FETCH_OBJ);

    //Tweede stmt
    $stmt2 = $database->prepare("SELECT categories, amount, duration, products, price 
    FROM appointment_details ad 
    INNER JOIN services se ON se.id = ad.sid 
    WHERE appointment_id = $appointmentId");
    $stmt2->execute();
    $row2 = $stmt2->fetch(\PDO::FETCH_OBJ);
    $totalprice += $row2->price;

    
    $payment = $mollie->payments->create([
    "amount" =>  
    [
    "currency" => "EUR", 
    "value" => "$totalprice"
    ], 
    "method" => \Mollie\Api\Types\PaymentMethod::IDEAL, 
    "description" => "Order #{$row->id}", 
    "redirectUrl" => "{$protocol}://{$hostname}/philomena_hair&nails/payments-success.php", 
    "webhookUrl" => "{$protocol}://{$hostname}{$path}/payments/webhook.php", 
    "metadata" => ["order_id" => $row->id], 
    "issuer" => !empty($_POST["issuer"]) ? $_POST["issuer"] : null]);
    /*
     * In this example we store the order with its payment status in a database.
     */
    \_PhpScoper5e55118e73ab9\database_write($row->id, $payment->status);
    /*
     * Send the customer off to complete the payment.
     * This request should always be a GET, thus we enforce 303 http response code
     */
    \header("Location: " . $payment->getCheckoutUrl(), \true, 303);
} catch (\Mollie\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . \htmlspecialchars($e->getMessage());
}




