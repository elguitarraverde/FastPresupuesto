<?php

declare(strict_types=1);

namespace FacturaScripts\Plugins\FastPresupuesto\Extension\Model;

use Closure;
use FacturaScripts\Core\Tools;
use FacturaScripts\Plugins\FastPresupuesto\Init;
use FacturaScripts\Plugins\FastPresupuesto\Lib\TransKeys;

/**
 * @mixin \FacturaScripts\Dinamic\Model\PresupuestoCliente
 */
#[\AllowDynamicProperties]
class PresupuestoCliente
{
    public function testBefore(): Closure
    {
        return function (): bool {
            if ($this->codcliente !== Init::TECHNICAL_CUSTOMER_CODE) {
                return true;
            }

            $this->nombrecliente = Tools::noHtml($this->nombrecliente);
            $this->contacto_telefono = Tools::noHtml((string)($this->contacto_telefono ?? ''));
            $this->contacto_email = Tools::noHtml((string)($this->contacto_email ?? ''));

            if ('' === $this->nombrecliente) {
                Tools::log()->warning(TransKeys::NAME_REQUIRED);
                return false;
            }

            $this->provincia = $this->contacto_telefono;
            $this->direccion = $this->contacto_email;

            return true;
        };
    }
}
