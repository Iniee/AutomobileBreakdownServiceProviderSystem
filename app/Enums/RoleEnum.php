<?php

namespace App\Enums;

enum RoleEnum: string
{
    case CLIENT = 'client';
    case ADMIN = 'admin';
    case AGENT = 'agent';
    case PROVIDER = 'provider';
}