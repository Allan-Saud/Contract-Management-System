


<?php
require 'vendor/autoload.php';

// Replace the 'sk_test_your_stripe_test_key' with your actual Stripe test secret key
\Stripe\Stripe::setApiKey('sk_test_51OydIfSHM3AlAItsNpxdNhishaq7ChL7XfERCxwcpKmTb85HepGfPt5UnwVpmTFhn89IA1rfLDn9zgatzaYI4nwg00A2LxU24I');

$TOKEN = $_POST['token'];

$charge = \Stripe\Charge::create([
    'amount' => 1000, // Set the amount of the charge
    'currency' => 'usd',
    'source' => $TOKEN,
    'description' => 'Payment description',
]);

http_response_code(200);

$response = [
    'success' => true,
    'message' => 'Payment successful',
    'charge' => $charge,
];

echo json_encode($response);

?>