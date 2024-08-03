<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Enum\Gender;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $customer1 = new Customer();
        $customer1->setPassword('password');
        $customer1->setUsername('customer1');
        $customer1->setFirstName('customer1');
        $customer1->setLastName('last');
        $customer1->setGender(Gender::MALE);
        $customer1->setEmail('customer1@example.com');
        $customer1->setPhone('123');
        $customer1->setCity('city');
        $customer1->setCountry('country');
        $manager->persist($customer1);

        $customer2 = new Customer();
        $customer2->setPassword('password');
        $customer2->setUsername('customer2');
        $customer2->setFirstName('customer2');
        $customer2->setLastName('last');
        $customer2->setGender(Gender::MALE);
        $customer2->setEmail('customer2@example.com');
        $customer2->setPhone('456');
        $customer2->setCity('city');
        $customer2->setCountry('country');
        $manager->persist($customer2);

        $manager->flush();
    }
}
