<?php

namespace App\Integration\Core\Enum;

enum RequestMethod {
    case GET;
    case POST;
    case PUT;
    case PATCH;
    case DELETE;
}