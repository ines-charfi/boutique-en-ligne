<?php
require_once  ' vendor/autoload.php';

class PaiementController {
    public function process() {
        \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET']);
        
        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $this->calculateTotal(),
                'currency' => 'eur',
                'metadata' => [
                    'user_id' => $_SESSION['user']['id']
                ]
            ]);

            echo json_encode(['clientSecret' => $paymentIntent->client_secret]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    
    
        private function calculateTotal() {
            $total = 0;
            foreach ($_SESSION['panier'] as $item) {
                $total += $item['prix'] * $item['quantite'];
            }
            return $total * 100; // Convert to cents
        }
    }