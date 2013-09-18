<?php

namespace BattleRattle\Doorman\KeyGeneration;

interface KeyGeneratorInterface
{
    /**
     * @return string
     */
    public function generateKey();
}