<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPrivilege
{
    public function handle(Request $request, Closure $next, $module, $action = 'view')
    {
        $user = auth()->user();

        // If user is not logged in or has no privileges
        if (!$user || !$user->privileges()->exists()) {
            return $this->deny($request);
        }

        // Get user privileges as array
        $privileges = $user->privileges
            ->pluck('actions', 'module')
            ->map(fn($a) => json_decode($a, true))
            ->toArray();

        // Check if user has the required action for the module
        if (!isset($privileges[$module]) || !in_array($action, $privileges[$module])) {
            return $this->deny($request);
        }

        return $next($request);
    }

    /**
     * Handle unauthorized access
     */
    private function deny(Request $request)
    {
        // AJAX / JSON request
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You do not have permission to perform this action.'
            ], 403);
        }

        // Normal request, redirect back with flash message
        return redirect()->back()->with('t-error', 'You do not have permission to perform this action.');
    }
}
