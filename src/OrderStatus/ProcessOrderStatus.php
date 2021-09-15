<?php


namespace TechnicalTest\OrderStatus;

use TechnicalTest\Email\EmailInterface;

class ProcessOrderStatus implements ProcessOrderStatusInterface
{
    /**
     * @var OrderStatusStorageInterface
     */
    protected $orderStatusStorage = null;

    public function __construct(OrderStatusStorageInterface $orderStatusStorage)
    {
        $this->orderStatusStorage = $orderStatusStorage;
    }

    /**
    *   Use Regex to parse and extract necissary data from emails.
    *   
    *   @param EmailInterface $email    The email object to parse
    *   @return true    if email is parsed and store method is called successfully.
    *   @return false   if sender is invalid or email is not properly parsed.
    */

    public function extractOrderStatus(EmailInterface $email) : bool
    {
        $emailBody = $email->getEmail();

        //Extract sender
        preg_match('/From: Deliverx <donotreply@deliverx.co.uk>/', $emailBody, $senderMatches);
        if($senderMatches == null){
            return false;
        }
        $sender = $senderMatches[0];
        //Check sender is valid
        if($sender === 'From: Deliverx <donotreply@deliverx.co.uk>')
        {
            //Regex to parse order id, status and updatedate
            preg_match("/Tracking number\n(\d+)/",$emailBody, $idMatches);
            $trackingID = $idMatches[1];

            preg_match("/(delivering|successfully delivered|attempted)/",$emailBody, $statusMatches);
            $orderStatus = $statusMatches[1];

            //Correct order status with predefined statuses
            switch($orderStatus)
            {
                case 'delivering':
                    $orderStatus = 'Accepted';
                    break;
                case 'successfully delivered':
                    $orderStatus = 'Delivered';
                    break;
                case 'attempted':
                    $orderStatus = 'Delivery Failed';
                    break;
                default:
                    $orderStatus = 'Null';
                    break;
            }

            preg_match("/Date: (.+):\d* /", $emailBody, $dateMatches);
            $orderUpdateDate = $dateMatches[1];
            
            $alreadyDelivered = $this->orderStatusStorage->getCurrentStatus($trackingID) === 'Delivered';

            if(!$alreadyDelivered)
            {
                $this->orderStatusStorage->store($trackingID, $orderStatus, new \DateTime($orderUpdateDate));
                return true;
            }
        }
        return false;
    }
}
