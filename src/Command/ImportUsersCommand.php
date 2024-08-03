<?php

namespace App\Command;

use App\Entity\Customer;
use App\Enum\Gender;
use App\Factory\DataImporterFactoryInterface;
use App\Integration\Core\Object\QueryParameters;
use App\Repository\CustomerRepositoryInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(name: 'app:import-users')]
class ImportUsersCommand extends Command
{
    public function __construct(
        private DataImporterFactoryInterface $factory,
        private CustomerRepositoryInterface $customerRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $importer = $this->factory->makeService('random_user');
            $query = new QueryParameters;
            $query->add('nat', 'au');
            $query->add('results', 100);
            $res = $importer->getCustomers($query);
            foreach($res->getResult()['results'] as $info) {
                $customer = $this->customerRepository->findOneByEmail($info['email']);
                if(!$customer) {
                    $customer = new Customer;
                }
                $hashedPassword = $this->passwordHasher->hashPassword(
                    $customer,
                    $info['login']['password']
                );
                $customer->setPassword($hashedPassword);
                $customer->setUsername($info['login']['username']);
                $customer->setFirstName($info['name']['first']);
                $customer->setLastName($info['name']['last']);
                $customer->setGender(Gender::from($info['gender']));
                $customer->setEmail($info['email']);
                $customer->setPhone($info['phone']);
                $customer->setCity($info['location']['city']);
                $customer->setCountry($info['location']['country']);
                $this->customerRepository->save($customer);
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}