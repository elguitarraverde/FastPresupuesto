<?php

declare(strict_types=1);

namespace FacturaScripts\Plugins\FastPresupuesto;

use FacturaScripts\Core\Lib\AjaxForms\SalesHeaderHTML;
use FacturaScripts\Core\Request;
use FacturaScripts\Core\Template\InitClass;
use FacturaScripts\Dinamic\Model\Cliente;
use FacturaScripts\Plugins\FastPresupuesto\Mod\SalesHeaderHTMLMod;

class Init extends InitClass
{
    public const TECHNICAL_CUSTOMER_CODE = 'FASTPRES';

    public function init(): void
    {
        $this->loadExtension(new Extension\Controller\ListPresupuestoCliente());
        $this->loadExtension(new Extension\Model\FacturaCliente());
        $this->loadExtension(new Extension\Model\PresupuestoCliente());
        SalesHeaderHTML::addMod(new SalesHeaderHTMLMod());

        $request = Request::createFromGlobals();
        if ($request->query->has('action') && $request->query->get('action') === 'rebuild') {
            $this->crearClienteTecnico();
        };
    }

    public function uninstall(): void
    {
        //
    }

    public function update(): void
    {
        $this->crearClienteTecnico();
    }

    private function crearClienteTecnico(): void
    {
        $customer = new Cliente();
        if ($customer->load(self::TECHNICAL_CUSTOMER_CODE)) {
            return;
        }

        $customer->codcliente = self::TECHNICAL_CUSTOMER_CODE;
        $customer->cifnif = '';
        $customer->nombre = 'Cliente rápido';
        $customer->razonsocial = 'Cliente rápido';
        $customer->save();
    }
}
