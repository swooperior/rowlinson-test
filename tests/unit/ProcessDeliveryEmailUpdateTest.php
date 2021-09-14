<?php

use PHPUnit\Framework\TestCase;
use \TechnicalTest\OrderStatus\ProcessOrderStatus;

class ProcessDeliveryEmailUpdateTest extends TestCase
{
    protected $orderStatusStorageMock = null;

    protected $processEmailOrderStatus = null;

    protected $emailMock = null;

    protected function setUp(): void
    {
        $this->orderStatusStorageMock = $this->createMock('TechnicalTest\OrderStatus\OrderStatusStorageInterface');
        $this->emailMock = $this->createMock('TechnicalTest\Email\EmailInterface');

        $this->processEmailOrderStatus = new ProcessOrderStatus($this->orderStatusStorageMock);
    }

    public function testParseAcceptedA(): void
    {
        // Load in sample email content
        $emailRaw = file_get_contents('tests/fixtures/shipper-accepted-parcel-a.txt');

        $this->emailMock->method('getEmail')
            ->willReturn($emailRaw);

        $this->orderStatusStorageMock->expects($this->once())
            ->method('store')
            ->with('701188855246861', 'Accepted', new \DateTime('2021-05-25 08:38'));

        $this->processEmailOrderStatus->extractOrderStatus($this->emailMock);
    }

    public function testParseAcceptedB(): void
    {
        // Load in sample email content
        $emailRaw = file_get_contents('tests/fixtures/shipper-accepted-parcel-b.txt');

        $this->emailMock->method('getEmail')
            ->willReturn($emailRaw);

        $this->orderStatusStorageMock->expects($this->once())
            ->method('store')
            ->with('701188855344862', 'Accepted', new \DateTime('2021-04-21 16:49'));

        $this->processEmailOrderStatus->extractOrderStatus($this->emailMock);
    }

    public function testParseDelivered(): void
    {
        // Load in sample email content
        $emailRaw = file_get_contents('tests/fixtures/shipper-delivered-parcel-a.txt');

        $this->emailMock->method('getEmail')
            ->willReturn($emailRaw);

        $this->orderStatusStorageMock->expects($this->once())
            ->method('store')
            ->with('701188855246861', 'Delivered', new \DateTime('2021-05-25 09:55'));

        $this->processEmailOrderStatus->extractOrderStatus($this->emailMock);
    }

    public function testParseDeliveryFailed(): void
    {
        // Load in sample email content
        $emailRaw = file_get_contents('tests/fixtures/shipper-missed-parcel-a.txt');

        $this->emailMock->method('getEmail')
            ->willReturn($emailRaw);

        $this->orderStatusStorageMock->expects($this->once())
            ->method('store')
            ->with('701188855246861', 'Delivery Failed', new \DateTime('2021-05-25 09:55'));

        $this->processEmailOrderStatus->extractOrderStatus($this->emailMock);
    }
    //ToDo;
    public function testParseOtherSender(): void
    {
        // Load in sample email content
        $emailRaw = file_get_contents('tests/fixtures/shipper-missed-parcel-a.txt');

        $this->emailMock->method('getEmail')
            ->willReturn($emailRaw);

        $this->orderStatusStorageMock->expects($this->once())
            ->method('store')
            ->with('701188855246861', 'Delivery Failed', new \DateTime('2021-05-25 09:55'));

        $this->processEmailOrderStatus->extractOrderStatus($this->emailMock);
    }

}
