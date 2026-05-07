<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFinanceRole
{
    public function handle(Request $request, Closure $next): Response
    {
        return (new EnsureRole)->handle($request, $next, 'finance');
    }
}
