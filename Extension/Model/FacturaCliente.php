<?php

declare(strict_types=1);

namespace FacturaScripts\Plugins\FastPresupuesto\Extension\Model;

use Closure;
use FacturaScripts\Core\Tools;
use FacturaScripts\Plugins\FastPresupuesto\Init;
use FacturaScripts\Plugins\FastPresupuesto\Lib\TransKeys;

class FacturaCliente
{
    public function saveBefore(): Closure
    {
        return function () {
            /** @var \FacturaScripts\Dinamic\Model\FacturaCliente $this */
            if ($this->codcliente !== Init::TECHNICAL_CUSTOMER_CODE) {
                return true;
            }

            if ($this->getStatus()->editable) {
                return true;
            }

            Tools::log()->warning(TransKeys::STATUS_BLOCKED);
            return false;
        };
    }
}
