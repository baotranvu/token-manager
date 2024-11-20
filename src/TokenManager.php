<?php
namespace BaoTran\TokenManager;

use Exception;

class TokenManager
{
    protected $secretKey;

    public function __construct(string $secretKey)
    {
        
        $this->secretKey = $secretKey;
    }

    public function generateToken(array $payload, int $expiry): string
    {
        $payload['exp'] = time() + $expiry;
        $token = base64_encode(json_encode($payload));
        return hash_hmac('sha256', $token, $this->secretKey) . '.' . $token;
    }

    public function validateToken(string $token): bool
    {
        [$hash, $payload] = explode('.', $token, 2);
        $validHash = hash_hmac('sha256', $payload, $this->secretKey);
        if (!hash_equals($validHash, $hash)) {
            throw new Exception('Invalid token signature.');
        }

        $data = json_decode(base64_decode($payload), true);
        if (time() > $data['exp']) {
            throw new Exception('Token has expired.');
        }

        return true;
    }
}
