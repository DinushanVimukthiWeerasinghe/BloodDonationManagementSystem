<?php

namespace Core;

abstract class BaseMiddleware
{
    public const ALLOWED_ROUTES=1;
    public const FORBIDDEN_ROUTES=2;
    abstract public function execute();
}