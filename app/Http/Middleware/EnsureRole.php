<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/** Usage: ->middleware('role:admin') or 'role:admin,staff' */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();

        if (! $user || ! $user->isActive()) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Your account is inactive.']);
        }

        if ($roles && ! in_array($user->role, $roles, true)) {
            if ($request->expectsJson()) {
                return response()->json(['status' => false, 'message' => 'You do not have permission for this action.'], 403);
            }
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to open that page.');
        }

        return $next($request);
    }
}
