<?php

declare(strict_types=1);

namespace App\Enums;

enum ChangesActionEnum : string
{
    case Add = 'add';

    case Edit = 'edit';

    case Cut = 'cut';
}
