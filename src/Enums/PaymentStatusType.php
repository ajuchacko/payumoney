<?php

namespace Ajuchacko\Payu\Enums;

use MyCLabs\Enum\Enum;

class PaymentStatusType extends Enum
{
    const STATUS_FAILED = 'Failed';
    const STATUS_PENDING = 'Pending';
    const STATUS_TAMPERED = 'Tampered';
    const STATUS_COMPLETED = 'Completed';
}
