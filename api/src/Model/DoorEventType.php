<?php

namespace App\Model;

enum DoorEventType: string
{
    case Ingress = 'ingress';
    case Egress = 'egress';
}
