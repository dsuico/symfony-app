<?php

namespace App\Tests\Service;

use App\DataFixtures\CustomerFixture;
use App\Service\CustomerService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CustomServiceTest extends KernelTestCase
{
    public function setUp(): void
    {
      self::bootKernel(
          [
              'environment' => 'test'
          ]
      );
      $this->getEntityManager()->getConnection()->executeQuery("TRUNCATE customers;");
      
      $fixture = new CustomerFixture();
      $fixture->load($this->getEntityManager());
    }

    private function getEntityManager()
    {
      return static::getContainer()->get('doctrine')->getManager();
    }

    public function testItGetsAllCustomers(): void
    {
      /** @var \App\Service\CustomerService */
      $customerService = static::getContainer()->get(CustomerService::class);
      $customers = $customerService->getAll();

      $this->assertEquals(2, count($customers));
      $this->assertEquals($customers[0]['email'], 'customer1@example.com');
    }

    public function testItGetsCustomerDetail(): void
    {
      /** @var \App\Service\CustomerService */
      $customerService = static::getContainer()->get(CustomerService::class);
      $customer = $customerService->getCustomerDetail(2);

      $this->assertEquals($customer['email'], 'customer2@example.com');
    }

    public function testItThrowsExceptionIfCustomerNotFound(): void
    {
      try {
        /** @var \App\Service\CustomerService */
        $customerService = static::getContainer()->get(CustomerService::class);
        $customer = $customerService->getCustomerDetail(3);

      $this->assertEquals($customer['email'], 'customer2@example.com');
      } catch (\Exception $e) {
        $this->assertEquals('customer not found', $e->getMessage());
      }
    }
}