<?php

namespace TechnicalTest\Email;

interface EmailInterface
{
    /**
     * Returns a string of the raw plain text email
     * @return string
     */
    public function getEmail(): string;
}
