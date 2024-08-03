<?php

namespace App\Factory;

use App\Service\DataImporterService;

interface DataImporterFactoryInterface {
  public function makeService(string $name): DataImporterService;
}