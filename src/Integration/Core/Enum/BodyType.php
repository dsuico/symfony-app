<?php

namespace App\Integration\Core\Enum;

enum BodyType: string {
    case JSON           = 'json';
    case FORM_PARAMS    = 'form_params';
    case BODY           = 'body';
    case MULTIPART      = 'multipart';
}