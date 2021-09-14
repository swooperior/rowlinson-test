<?php

namespace TechnicalTest\OrderStatus;

use TechnicalTest\Email\EmailInterface;

interface ProcessOrderStatusInterface
{
    public function __construct(OrderStatusStorageInterface $orderStatusStorage);

    /**
     * Takes an Order Email and extracts shipping information
     * @param EmailInterface $email
     * @return bool
     */
    public function extractOrderStatus(EmailInterface $email) : bool;
}
