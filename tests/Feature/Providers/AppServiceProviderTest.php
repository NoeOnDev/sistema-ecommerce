<?php

namespace Tests\Feature\Providers;

use Illuminate\Pagination\Paginator;
use Tests\TestCase;

class AppServiceProviderTest extends TestCase
{
    #[Test]
    public function it_uses_tailwind_for_pagination()
    {
        // Verificar que la app está configurada para usar Tailwind para la paginación
        $this->assertEquals('pagination::tailwind', Paginator::$defaultView);
        $this->assertEquals('pagination::simple-tailwind', Paginator::$defaultSimpleView);
    }
}
