<?php
namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHelper
{
    public static function createToken($userId, $userEmail)
    {
        $key = env('JWT_KEY'); // Retrieve JWT_KEY from the .env file
        $payload = [
            'iss' => 'pos-learning-pos',  // Issuer
            'aud' => 'pos-learning-pos',  // Audience
            'iat' => now()->timestamp,    // Issued at
            'exp' => now()->addHour()->timestamp,  // Expiration (1 hour from now)
            'user_id' => $userId,         // User ID
            'user_email' => $userEmail    // User Email
        ];

        $encoded_data = JWT::encode($payload, $key, 'HS256');
        return $encoded_data;
    }


    public static function resetPasswordCreateToken($userId, $userEmail)
    {
        $key = env('JWT_KEY'); // Retrieve JWT_KEY from the .env file
        $payload = [
            'iss' => 'pos-learning-pos',  // Issuer
            'aud' => 'pos-learning-pos',  // Audience
            'iat' => now()->timestamp,    // Issued at
            'exp' => now()->addMinutes(55)->timestamp,  // Expiration (1 hour from now)
            'user_id' => $userId,         // User ID
            'user_email' => $userEmail    // User Email
        ];

        $encoded_data = JWT::encode($payload, $key, 'HS256');

        return $encoded_data;

    }



    public static function verifyToken($token): string|object
    {

        try{
            if( $token == null){
                return 'unauthorised';
            }
            $key = env('JWT_KEY'); // Retrieve JWT_KEY from the .env file
            $decoded_data = JWT::decode($token, new Key($key, 'HS256'));
            return $decoded_data;
        }catch( Exception $e ){
            return 'unauthorised';
        }

    }

}