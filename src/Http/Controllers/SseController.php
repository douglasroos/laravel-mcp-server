<?php

namespace OPGG\LaravelMcpServer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use OPGG\LaravelMcpServer\Server\MCPServer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SseController extends Controller
{
    public function handle(Request $request)
    {
        $server = app(MCPServer::class);
        
        $sessionId = $request->query('sessionId');
        if ($sessionId) {
            $server->setClientId($sessionId);
        }

        return new StreamedResponse(fn () => $server->connect(), headers: [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }
}
