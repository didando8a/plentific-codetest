<?php

namespace Didando8a\Plentific\Helper;

trait EncoderDecoderHelperTrait
{
    /**
     * @param array<mixed> $message
     */
    private function encodeString(array $message): string
    {
        $messageString = json_encode($message);

        return false === $messageString ? '' : $messageString;
    }
}
