<?php

namespace TechnicalTest\OrderStatus;

interface OrderStatusStorageInterface
{
    /**
     * Stores an update to the
     *
     * @param string $trackingId    The tracking identifier of the parcel
     * @param string $status    Current status of the order
     * @param \DateTime $dateTime   Time of order status update
     * @param string $notes optional Any additional notes regarding the order
     * @return bool Success of storing the order
     */
    public function store($trackingId, string $status, \DateTime $dateTime, string $notes = null): bool;

    /**
     * Takes a tracking ID and returns the current status of the parcel as a string
     * @param $trackingId
     * @return string String of the latest order status update. Accepted, Delivered, Failed
     */
    public function getCurrentStatus($trackingId): string;
}
