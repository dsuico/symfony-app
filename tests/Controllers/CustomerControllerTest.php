<?php

namespace App\Tests\Controllers;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\DataFixtures\CustomerFixture;

class CustomerControllerTest extends ApiTestCase
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

    public function testItGetsCustomers(): void
    {
        $response = static::createClient()->request('GET', '/api/customers');
        $this->assertResponseIsSuccessful();
        $responseData = $response->toArray();
        $this->assertSame('customer1@example.com', $responseData[0]['email']);
    }

    public function testItGetsCustomerDetail(): void
    {
        $response = static::createClient()->request('GET', '/api/customers/1');
        $this->assertResponseIsSuccessful();
        $responseData = $response->toArray();
        $this->assertSame('customer1@example.com', $responseData['email']);
    }

    public function testItReturnsUnprocessableEntityIfCustomerNotFound(): void
    {
        $response = static::createClient()->request('GET', '/api/customers/3');
        $this->assertResponseStatusCodeSame(422);
    }
}
