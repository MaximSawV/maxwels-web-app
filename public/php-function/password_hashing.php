<?php
    function hashing ($password, $salt)
    {
        $passwordHash = hash('sha256', $password);
        $password = substr_replace($passwordHash, $salt, 32);

        $passwordHash = hash('haval128,5', $password);
        $password = substr_replace($passwordHash, $salt, 8);

        $passwordHash = hash('gost', $password);
        $password = substr_replace($passwordHash, $salt, 57);

        $passwordHash = hash('md5', $password);
        $password = substr_replace($passwordHash, $salt, 13);

        $passwordHash = hash('sha512', $password);
        $password = substr_replace($passwordHash, $salt, 19);

        $passwordHash = hash('ripemd256', $password);
        $password = substr_replace($passwordHash, $salt, 4);

        $passwordHash = hash('snefru', $password);
        $password = substr_replace($passwordHash, $salt, 32);

        $passwordHash = hash('crc32b', $password);
        $password = substr_replace($passwordHash, $salt, 7);

        $passwordHash = hash('adler32', $password);
        $password = substr_replace($passwordHash, $salt, 32);

        $passwordHash = hash('whirlpool', $password);
        $password = substr_replace($passwordHash, $salt, 13);

        $passwordHash = hash('crc32b', $password);
        $password = substr_replace($passwordHash, $salt, 1);

        $passwordHash = hash('haval128,5', $password);
        $fullyHashedPassword = $passwordHash;
        return $fullyHashedPassword;
    }
?>