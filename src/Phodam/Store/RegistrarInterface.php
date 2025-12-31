<?php

// This file is part of Phodam
// Copyright (c) Chris Bouchard <chris@upliftinglemma.net>
// Licensed under the MIT license. See LICENSE file in the project root.
// SPDX-License-Identifier: MIT

declare(strict_types=1);

namespace Phodam\Store;

use Phodam\Types\TypeDefinition;
use Phodam\Provider\ProviderInterface;

interface RegistrarInterface
{
    /**
     * @return $this
     */
    public function withType(string $type);

    /**
     * @return $this
     */
    public function withName(string $name);

    /**
     * @return $this
     */
    public function overriding();

    /**
     * @param ProviderInterface | class-string<ProviderInterface> $providerOrClass
     */
    public function registerProvider($providerOrClass): void;

    /**
     * @param TypeDefinition $definition
     */
    public function registerDefinition(TypeDefinition $definition): void;
}
