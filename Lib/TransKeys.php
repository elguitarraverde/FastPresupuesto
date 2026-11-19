<?php

declare(strict_types=1);

namespace FacturaScripts\Plugins\FastPresupuesto\Lib;

final class TransKeys
{
    public const string NEW = 'fastpresupuesto-new';
    public const string PHONE = 'fastpresupuesto-contact-phone';
    public const string EMAIL = 'fastpresupuesto-contact-email';
    public const string NAME_REQUIRED = 'fastpresupuesto-contact-name-required';
    public const string MISSING_CUSTOMER = 'fastpresupuesto-missing-technical-customer';
    public const string STATUS_BLOCKED = 'fastpresupuesto-official-status-blocked';

    private function __construct()
    {
    }
}
