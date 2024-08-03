<?php

namespace App\Tests\Command;

use App\Command\ImportUsersCommand;
use App\DataFixtures\CustomerFixture;
use App\Factory\DataImporterFactory;
use App\Integration\Core\Object\Response;
use App\Repository\CustomerRepository;
use App\Service\RandomUserService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class ImportUsersCommandTest extends KernelTestCase
{
    public function setUp(): void
    {
      self::bootKernel(
          [
              'environment' => 'test'
          ]
      );
      $purger = new ORMPurger($this->getEntityManager());
      $purger->purge();
    }

    private function getEntityManager()
    {
      return static::getContainer()->get('doctrine')->getManager();
    }

    public function testItImportsCustomers(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $service = $this->createMock(RandomUserService::class);
        $service->expects(self::once())
            ->method('getCustomers')
            ->willReturn(new Response([
                "results" => [
                        [
                            "gender" => "male", 
                            "name" => [
                            "title" => "Mr", 
                            "first" => "Chester", 
                            "last" => "Andrews" 
                            ], 
                            "location" => [
                                "street" => [
                                    "number" => 1781, 
                                    "name" => "Hickory Creek Dr" 
                                ], 
                                "city" => "Orange", 
                                "state" => "Australian Capital Territory", 
                                "country" => "Australia", 
                                "postcode" => 4960, 
                                "coordinates" => [
                                        "latitude" => "85.4648", 
                                        "longitude" => "-146.2961" 
                                    ], 
                                "timezone" => [
                                        "offset" => "+10:00", 
                                        "description" => "Eastern Australia, Guam, Vladivostok" 
                                        ] 
                            ], 
                            "email" => "chester.andrews@example.com", 
                            "login" => [
                                            "uuid" => "20f25a17-dc6d-494d-a5c6-d9562103efbb", 
                                            "username" => "silvergoose842", 
                                            "password" => "excite", 
                                            "salt" => "ZWA2Ks1k", 
                                            "md5" => "7ce8a0acd2e97972ef8a2d3c2280fdad", 
                                            "sha1" => "54097a11beb8c0f5b52dab52d5c6a539bf17623e", 
                                            "sha256" => "a735cd46e537f055c1348bd92642604b183ed97797e154053dec4306cda871ad" 
                                        ], 
                            "dob" => [
                                                "date" => "1978-12-02T06:29:41.798Z", 
                                                "age" => 45 
                                            ], 
                            "registered" => [
                                                    "date" => "2009-04-14T12:20:25.999Z", 
                                                    "age" => 15 
                                                ], 
                            "phone" => "01-0029-9677", 
                            "cell" => "0495-705-844", 
                            "id" => [
                                                    "name" => "TFN", 
                                                    "value" => "889192762" 
                                                    ], 
                            "picture" => [
                                                        "large" => "https://randomuser.me/api/portraits/men/38.jpg", 
                                                        "medium" => "https://randomuser.me/api/portraits/med/men/38.jpg", 
                                                        "thumbnail" => "https://randomuser.me/api/portraits/thumb/men/38.jpg" 
                                                    ], 
                            "nat" => "AU" 
                        ], 
                        [
                            "gender" => "male", 
                            "name" => [
                                "title" => "Mr", 
                                "first" => "Calvin", 
                                "last" => "Spencer" 
                            ], 
                            "location" => [
                                "street" => [
                                    "number" => 8259, 
                                    "name" => "Poplar Dr" 
                                ], 
                                "city" => "Hervey Bay", 
                                "state" => "Queensland", 
                                "country" => "Australia", 
                                "postcode" => 2783, 
                                "coordinates" => [
                                        "latitude" => "50.3471", 
                                        "longitude" => "160.3036" 
                                    ], 
                                "timezone" => [
                                            "offset" => "+5:45", 
                                            "description" => "Kathmandu" 
                                        ] 
                                ], 
                            "email" => "calvin.spencer@example.com", 
                            "login" => [
                                            "uuid" => "8c19d67c-df2f-44ca-8770-2dcda7738352", 
                                            "username" => "bigdog462", 
                                            "password" => "aisan", 
                                            "salt" => "GowipMgX", 
                                            "md5" => "dc149390aa9466b7c21e686af7f8ef5a", 
                                            "sha1" => "13e1c1b6b9cdac4a3e0283e89d9abc8ac620ee43", 
                                            "sha256" => "dd1ac20ba71ff022430164062afee52aa7b235ea0c31f3511b40b08a01cb1092" 
                                            ], 
                            "dob" => [
                                                "date" => "1953-04-09T14:10:43.090Z", 
                                                "age" => 71 
                                            ], 
                            "registered" => [
                                                    "date" => "2004-05-29T06:10:51.176Z", 
                                                    "age" => 20 
                                                ], 
                            "phone" => "01-9677-3382", 
                            "cell" => "0482-720-114", 
                            "id" => [
                                                        "name" => "TFN", 
                                                        "value" => "502294050" 
                                                    ], 
                            "picture" => [
                                                        "large" => "https://randomuser.me/api/portraits/men/73.jpg", 
                                                        "medium" => "https://randomuser.me/api/portraits/med/men/73.jpg", 
                                                        "thumbnail" => "https://randomuser.me/api/portraits/thumb/men/73.jpg" 
                                                        ], 
                            "nat" => "AU" 
                        ]
                    ], 
                "info" => [
                        "seed" => "51a85109c046abdb", 
                        "results" => 2, 
                        "page" => 1, 
                        "version" => "1.4" 
                    ] 
                ]));

        $factory = $this->createMock(DataImporterFactory::class);
        $factory->expects(self::once())
            ->method('makeService')
            ->willReturn($service);

        $hasher = $this->createMock(UserPasswordHasher::class);
        $hasher
            ->method('hashPassword')
            ->willReturn('asd');

        $repository = $container->get(CustomerRepository::class);

        $application = new Application(self::$kernel);
        $application->add(new ImportUsersCommand($factory, $repository, $hasher));

        $command = $application->find('app:import-users');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();
    }

    public function testItThrowsException(): void
    {
        try {
            self::bootKernel();
            $container = static::getContainer();
            $service = $this->createMock(RandomUserService::class);
            $service->expects(self::once())
                ->method('getCustomers')
                ->willThrowException(new \Exception('test error'));

            $factory = $this->createMock(DataImporterFactory::class);
            $factory->expects(self::once())
                ->method('makeService')
                ->willReturn($service);

            $hasher = $this->createMock(UserPasswordHasher::class);
            $hasher
                ->method('hashPassword')
                ->willReturn('asd');

            $repository = $container->get(CustomerRepository::class);

            $application = new Application(self::$kernel);
            $application->add(new ImportUsersCommand($factory, $repository, $hasher));

            $command = $application->find('app:import-users');
            $commandTester = new CommandTester($command);
            $commandTester->execute([]);
        } catch (\Exception $e) {
            $this->assertSame('test error', $e->getMessage());            
        }        
    }
}