<?php

declare(strict_types=1);

namespace FacturaScripts\Plugins\FastPresupuesto\Extension\Controller;

use Closure;
use FacturaScripts\Core\Tools;
use FacturaScripts\Dinamic\Model\Cliente;
use FacturaScripts\Dinamic\Model\PresupuestoCliente;
use FacturaScripts\Plugins\FastPresupuesto\Init;
use FacturaScripts\Plugins\FastPresupuesto\Lib\TransKeys;

/**
 * @mixin \FacturaScripts\Dinamic\Controller\ListPresupuestoCliente
 */
#[\AllowDynamicProperties]
class ListPresupuestoCliente
{
    public function createViews(): Closure
    {
        return function (): void {
            $this->addButton('ListPresupuestoCliente', [
                'action' => 'create-fast-presupuesto',
                'icon' => 'fa-solid fa-bolt',
                'label' => TransKeys::NEW,
                'type' => 'modal'
            ]);
        };
    }

    public function execPreviousAction(): Closure
    {
        return function ($action): bool {
            if ('create-fast-presupuesto' !== $action) {
                return true;
            }

            if (false === $this->validateFormToken()) {
                return false;
            }

            $nombre = (string)$this->request->input('fastpresupuesto_nombre');
            if ('' === trim($nombre)) {
                Tools::log()->warning(TransKeys::NAME_REQUIRED);
                return false;
            }
            $telefono = (string)$this->request->input('fastpresupuesto_telefono');
            $email = (string)$this->request->input('fastpresupuesto_email');

            $doc = new PresupuestoCliente();
            $doc->clear();
            $doc->setAuthor($this->user);
            $customer = new Cliente();
            if (false === $customer->load(Init::TECHNICAL_CUSTOMER_CODE)) {
                Tools::log()->warning(TransKeys::MISSING_CUSTOMER);
                return false;
            }
            $doc->setSubject($customer);
            $doc->nombrecliente = $nombre;
            $doc->contacto_telefono = $telefono;
            $doc->contacto_email = $email;
            $doc->provincia = $telefono;
            $doc->direccion = $email;

            if (false === $doc->save()) {
                return false;
            }

            $this->redirect($doc->url() . '&action=save-ok');
            return false;
        };
    }
}
