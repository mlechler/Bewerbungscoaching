<?php

namespace App\Widgets;

use Anouar\Paypalpayment\Facades\PaypalPayment as PaypalPayment;
use Arrilot\Widgets\AbstractWidget;
use PayPal\Api\Payment;

class PaypalTransactions extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    private $_apiContext;

    public function __construct(array $config = [])
    {
        $this->_apiContext = PaypalPayment::apiContext(config('paypal_payment.Account.ClientId'), config('paypal_payment.Account.ClientSecret'));

        parent::__construct($config);
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $paymentsIDs = PaypalPayment::getAll(['count' => 5], $this->_apiContext);
        $payments2IDs = PaypalPayment::getAll(['count' => 5,'start_index' => 6], $this->_apiContext);
        $payments = [];
        $payments2 = [];

        for($i = 0; $i<5; $i++){
            array_push($payments, PaypalPayment::getById($paymentsIDs->payments[$i]->id, $this->_apiContext));
            array_push($payments2, PaypalPayment::getById($payments2IDs->payments[$i]->id, $this->_apiContext));
        }

        return view("backend.widgets.paypal_transactions", [
            'config' => $this->config,
        ], compact('payments', 'payments2'));
    }
}