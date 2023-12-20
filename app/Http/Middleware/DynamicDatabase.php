<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class DynamicDatabase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Get database connection details from the request
        $driver = $request->input('db_driver'); // Possiblities [mysql, pgsql, sqlite, sqlsrv]
        $host = $request->input('db_host');
        $database = $request->input('db_name');
        $username = $request->input('db_username');
        $password = $request->input('db_password');

        // Attempt to switch the database connection
        try {
            $this->validateConnectionDetails($driver, $host, $database, $username, $password);

            DB::purge('dynamic'); // Disconnects the default mysql database connection

            config([
                'database.connections.dynamic.driver' => $driver,
                'database.connections.dynamic.host' => $host,
                'database.connections.dynamic.database' => $database,
                'database.connections.dynamic.username' => $username,
                'database.connections.dynamic.password' => $password,
            ]);

            DB::connection('mysql');
        } catch (\Exception $e) {
            return response("Failed to establish database connection. Error: " . $e->getMessage(), 500);
        }

        return $next($request);
    }

    private function validateConnectionDetails($driver, $host, $database, $username, $password)
    {
        // You can add more sophisticated validation logic here based on your requirements.
        if (!in_array($driver, ['mysql', 'pgsql', 'sqlite', 'sqlsrv'])) {
            throw new \Exception("Invalid database driver.");
        }
    }
}
