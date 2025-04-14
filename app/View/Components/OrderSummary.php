<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OrderSummary extends Component
{
    public $item;
    public $showTaxRate;

    /**
     * Create a new component instance.
     *
     * @param mixed $item Cart o Order con propiedades de totales
     * @param bool $showTaxRate Mostrar tasa de impuesto
     */
    public function __construct($item, $showTaxRate = true)
    {
        $this->item = $item;
        $this->showTaxRate = $showTaxRate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.order-summary');
    }
}
