<?php

    function createJWT($payloadParam){
        //hago header
        $header=json_encode(['typ'=>'JWT','alg'=>'HSC256']);
        //json payload
        $payload=json_encode($payloadParam);

        //lo paso a base64 y reemplazo caracteres
        $header=base64_encode($header);
        $header=replaceStr($header);
        $payload=base64_encode($payload);
        $payload=replaceStr($payload);

        //creo la firma
        $signature=hash_hmac('sha256',$header . '.' . $payload,'firmado',true);
        $signature=base64_encode($signature);
        $signature=replaceStr($signature);

        //token
        $jwt=$header . '.' . $payload . '.' . $signature;
        return $jwt;
    }

    function validateJwt($jwt){
        //verifico que tenga un header,payload,signature
        $jwt=explode('.',$jwt);
        if(count($jwt)!=3)
            return null;

        $header=$jwt[0];
        $payload=$jwt[1];
        $signature=$jwt[2];

        //creo la signatura con lo que trae del token
        $validateSignature=hash_hmac('sha256',$header . '.' . $payload,'firmado',true);
        $validateSignature=base64_encode($validateSignature);
        $validateSignature=replaceStr($validateSignature);

        //compruebo si coincide con mi firmas
        if($validateSignature!=$signature)
            return null;

        $payload=base64_decode($payload);
        $payload=json_decode($payload);

        //verifico si su expiracion es menor al time actual,por si esta vencido
        if($payload->expiracion < time())
            return null;

        return $payload;
    }

    function replaceStr($string){
        $text=str_replace(['+','/','='],['-','_',''],$string);
        return $text;
    }