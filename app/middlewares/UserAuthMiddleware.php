<?php

namespace app\middlewares;

use app\utils\Helper;
use flight\Engine;

class UserAuthMiddleware
{
    protected Engine $app;

    public function __construct(Engine $app)
    {
        $this->app = $app;
    }

    public function before(array $params): void
    {
        // `Authorization: Bearer TVC66rtXnv7pw3jge4EtyC7qtyKKPxjjGyVUi4K2D`
        $rawToken = $this->app->request()->header('Authorization');

        $token = str_replace('Bearer ', '', $rawToken);

        if (empty($token)) {
            $this->app->jsonHalt($this->json(401,'Unauthorized'), 401);
        }

        $cacheUid = $this->app->cache()->get($token);
        $this->app->logger()->debug('cacheUid from cache:', ['cacheUid' => $cacheUid]);

        if ($cacheUid) {
            $this->app->set('authUid', $cacheUid);
            return;
        }

        $tokenData = $this->app->db()->get('tm_tokens', '*', [
            'token' => $token,
            'expire_at[>]' => time()
        ]);
        $this->app->logger()->debug('find token from db:', ['tokenData' => $tokenData]);

        if ($tokenData) {
            $this->app->set('authUid', $tokenData['uid']);
        } else {
            $this->app->jsonHalt($this->json(403, 'illegal or incorrect credentials.'), 403);
        }
    }

    private function json(int $code, string $msg)
    {
        return [
            'code' => $code,
            'msg' => $msg,
            'data' => null,
        ];
    }
}