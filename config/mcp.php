<?php

use Wizcoders\Mcp\Auth\NullAuthorizer;
use Wizcoders\Mcp\Tools\Introspection\DatabaseSchemaTool;
use Wizcoders\Mcp\Tools\Introspection\PackagesTool;
use Wizcoders\Mcp\Tools\Introspection\RoutesTool;
use Wizcoders\Mcp\Tools\WhoAmITool;

return [

    /*
    |--------------------------------------------------------------------------
    | Server identity
    |--------------------------------------------------------------------------
    |
    | Reported to the client during the initialize handshake, and shown in the
    | client's UI. Keep it recognisable — a developer with three MCP servers
    | connected needs to tell them apart.
    |
    */

    'server_name' => env('MCP_SERVER_NAME', 'laravel-mcp'),

    'server_version' => env('MCP_SERVER_VERSION', '1.0.0'),

    /*
    |--------------------------------------------------------------------------
    | Acting user
    |--------------------------------------------------------------------------
    |
    | Every tool call runs as a real application user so the authorizer decides
    | what is visible — the assistant never gets a wider view of the data than
    | the person driving it. `php artisan mcp:serve --user=` overrides this.
    |
    | There is deliberately no "run as admin" fallback: an unset user means no
    | permission-gated tool is listed at all.
    |
    */

    'default_user_id' => env('MCP_USER_ID'),

    /*
    | Auth guard used to look the user up. Null uses the default guard from
    | config/auth.php.
    */

    'guard' => env('MCP_GUARD'),

    /*
    |--------------------------------------------------------------------------
    | Authorizer
    |--------------------------------------------------------------------------
    |
    | Maps Tool::permission() onto your application's permission model.
    |
    |   NullAuthorizer  — denies everything gated (safe default)
    |   GateAuthorizer  — resolves through Laravel's Gate; works with policies
    |                     and with spatie/laravel-permission
    |   <your class>    — implement Wizcoders\Mcp\Contracts\Authorizer
    |
    */

    'authorizer' => NullAuthorizer::class,

    /*
    |--------------------------------------------------------------------------
    | Introspection permission
    |--------------------------------------------------------------------------
    |
    | Permission required by the bundled introspection tools (db_schema,
    | app_packages, app_routes). They expose schema, dependencies and routing —
    | structure, never row data.
    |
    | Null (ungated) is reasonable for a local stdio server, where the client
    | already had to be able to launch a PHP process and so already has database
    | and filesystem access. Set a permission before exposing this server over
    | HTTP, where that assumption stops holding.
    |
    */

    'introspection_permission' => env('MCP_INTROSPECTION_PERMISSION'),

    /*
    |--------------------------------------------------------------------------
    | Tools
    |--------------------------------------------------------------------------
    |
    | Resolved through the container, so tools may declare constructor
    | dependencies. Packages can also register their own at runtime:
    |
    |     $this->app->make(Wizcoders\Mcp\ToolRegistry::class)->register(new MyTool);
    |
    | Note this list REPLACES the package default when you publish the config,
    | so keep WhoAmITool here unless you mean to drop it.
    |
    */

    'tools' => [
        WhoAmITool::class,

        // Project-insight tools. Comment these out if you do not want an
        // assistant able to read your schema and routing table.
        DatabaseSchemaTool::class,
        PackagesTool::class,
        RoutesTool::class,

         \App\Mcp\Tools\ConsultarEstadoEquipoTool::class,
            \App\Mcp\Tools\HistorialEquipoTool::class,
            \App\Mcp\Tools\ListarGeocercasTool::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Result size guard
    |--------------------------------------------------------------------------
    |
    | Tool results are billed as input tokens on the model's next turn, so an
    | unbounded list is both slow and expensive. Tools should clamp their own
    | limits to this ceiling.
    |
    */

    'max_rows' => 200,

];
