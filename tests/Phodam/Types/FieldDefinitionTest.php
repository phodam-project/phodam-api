<?php

// This file is part of Phodam
// Copyright (c) Andrew Vehlies <avehlies@gmail.com>
// Licensed under the MIT license. See LICENSE file in the project root.
// SPDX-License-Identifier: MIT

declare(strict_types=1);

namespace PhodamTests\Phodam\Types;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Phodam\Types\FieldDefinition;
use PhodamTests\Fixtures\SimpleType;
use PhodamTests\Phodam\PhodamBaseTestCase;

#[CoversClass(FieldDefinition::class)]
#[CoversFunction(FieldDefinition::class . '::__construct')]
#[CoversFunction(FieldDefinition::class . '::fromArray')]
#[CoversFunction(FieldDefinition::class . '::setName')]
#[CoversFunction(FieldDefinition::class . '::setConfig')]
#[CoversFunction(FieldDefinition::class . '::setOverrides')]
#[CoversFunction(FieldDefinition::class . '::setNullable')]
#[CoversFunction(FieldDefinition::class . '::setArray')]
#[CoversFunction(FieldDefinition::class . '::getType')]
#[CoversFunction(FieldDefinition::class . '::getName')]
#[CoversFunction(FieldDefinition::class . '::getConfig')]
#[CoversFunction(FieldDefinition::class . '::getOverrides')]
#[CoversFunction(FieldDefinition::class . '::isNullable')]
#[CoversFunction(FieldDefinition::class . '::isArray')]
class FieldDefinitionTest extends PhodamBaseTestCase
{
    #[Test]
    #[TestDox('Default constructor creates field definition')]
    public function testDefaultConstructor(): void
    {
        $type = SimpleType::class;
        $def = new FieldDefinition($type);

        $this->assertEquals($type, $def->getType());
        $this->assertNull($def->getName());
        $this->assertIsArray($def->getConfig());
        $this->assertEmpty($def->getConfig());
        $this->assertIsArray($def->getOverrides());
        $this->assertEmpty($def->getOverrides());
        $this->assertFalse($def->isNullable());
        $this->assertFalse($def->isArray());
    }

    #[Test]
    #[TestDox('Getters and setters work as expected')]
    public function testGettersSetters(): void
    {
        $type = SimpleType::class;
        $name = 'MyName';
        $overrides = ['a' => 'b'];
        $config = ['c' => 'd'];
        $nullable = true;
        $array = true;

        $def = (new FieldDefinition($type))
            ->setName($name)
            ->setOverrides($overrides)
            ->setConfig($config)
            ->setNullable($nullable)
            ->setArray($array);

        $this->assertInstanceOf(FieldDefinition::class, $def);
        $this->assertEquals($type, $def->getType());
        $this->assertEquals($name, $def->getName());
        $this->assertIsArray($def->getOverrides());
        $this->assertEquals($type, $def->getType());
        $this->assertIsArray($def->getConfig());
        $this->assertTrue($def->isNullable());
        $this->assertTrue($def->isArray());
    }

    #[Test]
    #[TestDox('From array creates field definition')]
    public function testFromArray()
    {
        $type = SimpleType::class;
        $name = 'MyName';
        $overrides = ['a' => 'b'];
        $config = ['c' => 'd'];
        $nullable = true;
        $array = true;

        $defArray = [
            'type' => $type,
            'name' => $name,
            'overrides' => $overrides,
            'config' => $config,
            'nullable' => $nullable,
            'array' => $array
        ];

        $def = FieldDefinition::fromArray($defArray);
        $this->assertInstanceOf(FieldDefinition::class, $def);
        $this->assertEquals($type, $def->getType());
        $this->assertEquals($name, $def->getName());
        $this->assertIsArray($def->getOverrides());
        $this->assertEquals($type, $def->getType());
        $this->assertIsArray($def->getConfig());
        $this->assertTrue($def->isNullable());
        $this->assertTrue($def->isArray());
    }
}
