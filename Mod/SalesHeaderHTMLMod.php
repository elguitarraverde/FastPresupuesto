<?php

declare(strict_types=1);

namespace FacturaScripts\Plugins\FastPresupuesto\Mod;

use FacturaScripts\Core\Contract\SalesModInterface;
use FacturaScripts\Core\Model\Base\SalesDocument;
use FacturaScripts\Core\Tools;
use FacturaScripts\Plugins\FastPresupuesto\Init;
use FacturaScripts\Plugins\FastPresupuesto\Lib\TransKeys;

class SalesHeaderHTMLMod implements SalesModInterface
{
    public function apply(SalesDocument &$model, array $formData): void
    {
        if ('PresupuestoCliente' !== $model->modelClassName()) {
            return;
        }

        if ($model->codcliente === Init::TECHNICAL_CUSTOMER_CODE) {
            $model->nombrecliente = Tools::noHtml((string)($formData['nombrecliente'] ?? $model->nombrecliente));
            $model->contacto_telefono = Tools::noHtml((string)($formData['contacto_telefono'] ?? $model->contacto_telefono));
            $model->contacto_email = Tools::noHtml((string)($formData['contacto_email'] ?? $model->contacto_email));
            $model->provincia = $model->contacto_telefono;
            $model->direccion = $model->contacto_email;
        }
    }

    public function applyBefore(SalesDocument &$model, array $formData): void
    {
    }

    public function assets(): void
    {
    }

    public function newBtnFields(): array
    {
        return [];
    }

    public function newFields(): array
    {
        return ['fastpresupuesto_contact_name', 'fastpresupuesto_contact_phone', 'fastpresupuesto_contact_email'];
    }

    public function newModalFields(): array
    {
        return [];
    }

    public function renderField(SalesDocument $model, string $field): ?string
    {
        if ('PresupuestoCliente' !== $model->modelClassName()) {
            return null;
        }

        $isFastCustomer = $model->codcliente === Init::TECHNICAL_CUSTOMER_CODE;

        if ($isFastCustomer && 'fastpresupuesto_contact_name' === $field) {
            return '<div class="col-sm-6 col-md-4 col-lg">'
                . '<div class="mb-2">' . Tools::trans('name')
                . '<input type="text" name="nombrecliente" required="" maxlength="100" autocomplete="off" value="' . Tools::noHtml($model->nombrecliente) . '" class="form-control" style="border:1px solid #dc3545;"/>'
                . '</div>'
                . '</div>';
        }

        if ($isFastCustomer && 'fastpresupuesto_contact_phone' === $field) {
            return '<div class="col-sm-6 col-md-4 col-lg">'
                . '<div class="mb-2">' . Tools::lang()->trans(TransKeys::PHONE)
                . '<input type="text" name="contacto_telefono" maxlength="20" autocomplete="off" value="' . Tools::noHtml((string)$model->contacto_telefono) . '" class="form-control" style="border:1px solid #dc3545;"/>'
                . '</div>'
                . '</div>';
        }

        if ($isFastCustomer && 'fastpresupuesto_contact_email' === $field) {
            return '<div class="col-sm-6 col-md-4 col-lg">'
                . '<div class="mb-2">' . Tools::lang()->trans(TransKeys::EMAIL)
                . '<input type="email" name="contacto_email" maxlength="150" autocomplete="off" value="' . Tools::noHtml((string)$model->contacto_email) . '" class="form-control" style="border:1px solid #dc3545;"/>'
                . '</div>'
                . '</div>';
        }

        return null;
    }
}
