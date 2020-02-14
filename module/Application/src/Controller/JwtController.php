<?php

namespace Application\Controller;

use Application\Entity\User;
use DateInterval;
use DateTime;


class JwtController
{


    /**
     * @param User $user
     * @return string
     * @throws \Exception
     */
    public static function generateJwt(User $user)
    {
        $signingKey = "123456";
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);



        $payload = json_encode([
            'exp' => time(),
            'id_u' => (int)$user->getId(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getEmail(),
            'date_de_naissance' => $user->getDateDeNaissance(),
            'image' => $user->getImage(),
            'points' => (int)$user->getPoints(),
            'parties_gagnees' => (int)$user->getPartiesGagnees(),
            'parties_perdues' => (int)$user->getPartiesPerdues(),
            'pourcentage_reussite' => (int)$user->getPourcentageReussite(),
            'etat' => (int)$user->getEtat()
        ]);

        $base64Header = JwtController::UrlEncode($header);
        $base64Payload = JwtController::UrlEncode($payload);

        $signature = hash_hmac('sha256', $base64Header . "." . $base64Payload, $signingKey, true);
        $base64Signature = JwtController::UrlEncode($signature);

        return $base64Header . "." . $base64Payload . "." . $base64Signature;
    }

    /**
     * @param string $jwt
     * @return bool
     */
    public static function verifyJwt($jwt)
    {
        $signingKey = "123456";
        list($encodedHeader, $encodedPayload, $encodedSignature) = explode('.', $jwt);

        $decodedPayload = json_decode(JwtController::UrlDecode($encodedPayload));
        $signature = JwtController::UrlDecode($encodedSignature);
        $jwtData = $encodedHeader . '.' . $encodedPayload;

        $newSignature = hash_hmac('sha256', $jwtData, $signingKey, true);

        $now = new DateTime();
        //$expiry = new DateTime('@' . $decodedPayload->exp);

        return hash_equals($signature, $newSignature) /**&& ($now < $expiry)**/;
    }

    /**
     * @param $jwt
     * @return array
     */
    public static function deconstructJwt($jwt)
    {
        $parts = explode('.', $jwt);
        $header = json_decode(base64_decode($parts[0]));
        $payload = json_decode(base64_decode($parts[1]));

        return [
            'header' => $header,
            'payload' => $payload
        ];
    }

    /**
     * @return int
     * @throws \Exception
     */
    private function getExpiry()
    {
        $dt = new DateTime();
        $dt->add(new DateInterval('PT15M'));

        return $dt->getTimestamp();
    }

    /**
     * @param array $jwtConfig
     * @return $this
     */
    public function setJwtConfig(array $jwtConfig)
    {
        $this->jwtConfig = $jwtConfig;
        return $this;
    }

    /**
     * @return array
     */


    static public function UrlEncode($data)
    {
        $encodedData = base64_encode($data);
        $safeData = strtr($encodedData, '+/', '-_');
        return rtrim($safeData, '=');
    }

    static public function UrlDecode($data)
    {
        $unsafeData = strtr($data, '-_', '+/');
        $paddedData = str_pad($unsafeData, strlen($data) % 4, '=', STR_PAD_RIGHT);
        return base64_decode($paddedData);
    }
}