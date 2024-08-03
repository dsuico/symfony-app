<?php

namespace App\Factory;

use App\Integration\RandomUser\RandomUserHttp;
use App\Service\DataImporterService;
use App\Service\RandomUserService;
use Exception;

class DataImporterFactory implements DataImporterFactoryInterface {
  public function makeService(string $name): DataImporterService {
    switch ($name) {
      case 'random_user':
        return new RandomUserService(new RandomUserHttp('https://randomuser.me/api'));
      default:
        throw new Exception('no data importer for: ' . $name);
    }
  }
}