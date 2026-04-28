<?php

declare(strict_types=1);

namespace FacturaScripts\Plugins\FastPresupuesto\Lib;

final class TransKeys
{
    public const NEW = 'fastpresupuesto-new';
    public const PHONE = 'fastpresupuesto-contact-phone';
    public const EMAIL = 'fastpresupuesto-contact-email';
    public const NAME_REQUIRED = 'fastpresupuesto-contact-name-required';
    public const MISSING_CUSTOMER = 'fastpresupuesto-missing-technical-customer';
    public const STATUS_BLOCKED = 'fastpresupuesto-official-status-blocked';

    private function __construct()
    {
    }
}
