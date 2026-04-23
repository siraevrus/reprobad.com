<?php

namespace App\Http\Controllers\WellKnown;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BotAuthController
{
    /**
     * Serve the Web Bot Auth key directory per draft-meunier-http-message-signatures-directory.
     *
     * Publishes a JWKS (JSON Web Key Set) at /.well-known/http-message-signatures-directory
     * and signs the response with the site's Ed25519 private key so receiving sites can verify
     * that the directory is authentic. Verifiers follow RFC 9421 (HTTP Message Signatures).
     */
    public function signaturesDirectory(Request $request): Response
    {
        $secretKeyEncoded = config('services.webbot.signing_key');

        if (empty($secretKeyEncoded)) {
            abort(503, 'WEBBOT_SIGNING_KEY is not configured.');
        }

        $secretKey = base64_decode($secretKeyEncoded);
        $publicKey = sodium_crypto_sign_publickey_from_secretkey($secretKey);

        // Build JWK public key (OKP / Ed25519, RFC 8037)
        $x = rtrim(strtr(base64_encode($publicKey), '+/', '-_'), '=');

        // JWK thumbprint: SHA-256 of JSON with lexicographically sorted required members (RFC 8037 §A.3)
        $thumbprintJson = '{"crv":"Ed25519","kty":"OKP","x":"' . $x . '"}';
        $thumbprint     = rtrim(strtr(base64_encode(hash('sha256', $thumbprintJson, true)), '+/', '-_'), '=');

        $jwks = json_encode(
            ['keys' => [['kty' => 'OKP', 'crv' => 'Ed25519', 'x' => $x]]],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );

        // --- RFC 9421 response signature ---
        $now    = time();
        $expires = $now + 600; // 10-minute validity window
        $host   = $request->getHost();
        $nonce  = base64_encode(random_bytes(48));

        // Signature-Input inner value (no label prefix)
        $sigInputParams = '("@authority";req)'
            . ';alg="ed25519"'
            . ';keyid="' . $thumbprint . '"'
            . ';nonce="' . $nonce . '"'
            . ';tag="http-message-signatures-directory"'
            . ';created=' . $now
            . ';expires=' . $expires;

        // Signature base string (RFC 9421 §2.5): one quoted component line, then @signature-params
        $sigBase = '"@authority";req: ' . $host . "\n"
                 . '"@signature-params": ' . $sigInputParams;

        $rawSig = sodium_crypto_sign_detached($sigBase, $secretKey);

        return response($jwks, 200, [
            'Content-Type'    => 'application/http-message-signatures-directory+json',
            'Signature-Input' => 'sig1=' . $sigInputParams,
            'Signature'       => 'sig1=:' . base64_encode($rawSig) . ':',
            'Cache-Control'   => 'no-store',
        ]);
    }
}
