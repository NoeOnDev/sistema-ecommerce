<div class="space-y-2">
    <div class="flex justify-between mb-2">
        <span class="font-medium">Subtotal:</span>
        <span>{{ $item->formatted_subtotal }}</span>
    </div>

    <div class="flex justify-between mb-2">
        <span class="font-medium">
            Impuestos{{ $showTaxRate && isset($item->tax_rate) ? ' ('.$item->tax_rate.'%)' : '' }}:
        </span>
        <span>{{ $item->formatted_tax_amount }}</span>
    </div>

    <div class="flex justify-between text-lg font-bold">
        <span>Total:</span>
        <span>{{ $item->formatted_total }}</span>
    </div>
</div>
