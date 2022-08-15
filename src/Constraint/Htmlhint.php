<?php

namespace PHPUnitHmtlhint\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

class Htmlhint extends Constraint
{
    protected function matches($other): bool
    {
        return ! $other->hasErrors();
    }

    public function toString(): string
    {
        return 'is valid html';
    }

    protected function failureDescription($other): string
    {
        return $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        return implode("\n", $other->getStdouts());
    }
}
