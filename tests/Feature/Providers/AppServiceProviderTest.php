<?php

namespace Tests\Unit\Providers;

use Illuminate\Pagination\Paginator;
use Tests\TestCase;

class AppServiceProviderTest extends TestCase
{
    /** @test */
    public function it_uses_bootstrap_for_pagination()
    {
        // Verificar que la app está configurada para usar Bootstrap para la paginación
        $this->assertEquals('pagination::bootstrap-4', Paginator::$defaultView);
        $this->assertEquals('pagination::simple-bootstrap-4', Paginator::$defaultSimpleView);
    }
}
