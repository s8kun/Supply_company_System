<?php

namespace App\Listeners;

use App\Events\OrderCancelled;
use App\Models\Customer;
use App\Services\CreditService;

class RestoreCustomerCredit
{
    /**
     * Inject credit service to restore balances.
     */
    public function __construct(private CreditService $creditService)
    {
    }

    /**
     * Restore customer credit after an order is cancelled.
     */
    public function handle(OrderCancelled $event): void
    {
        $order = $event->order->refresh();

        $customer = Customer::query()
            ->where('customer_id', $order->customer_id)
            ->lockForUpdate()
            ->first();

        if (!$customer) {
            return;
        }

        $this->creditService->creditCustomer($customer, (float) $order->total_price);
    }
}
