<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePdcAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        return (new EnsureRole)->handle($request, $next, 'pdc_admin', 'admin', 'pdc admin', 'admin.pdc');
    }
}
