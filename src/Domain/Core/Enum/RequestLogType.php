<?php

namespace Domain\Core\Enum;

enum RequestLogType: string
{
    case REQUEST = "REQUEST";
    case RESPONSE = "RESPONSE";
}
