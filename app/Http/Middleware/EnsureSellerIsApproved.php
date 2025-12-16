<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Seller;

class EnsureSellerIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'seller') {
            $seller = Seller::find($user->id_user);

            if (!$seller) {
                // Should not happen if data is consistent
                return redirect('/');
            }

            if ($seller->status === 'pending') {
                return redirect()->route('seller.waiting_approval');
            }

            if ($seller->status === 'rejected') {
                return redirect()->route('seller.rejected');
            }
        }

        return $next($request);
    }
}
