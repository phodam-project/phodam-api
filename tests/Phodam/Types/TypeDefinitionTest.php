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
use Phodam\Types\TypeDefinition;
use PhodamTests\Fixtures\SimpleType;
use PhodamTests\Phodam\PhodamBaseTestCase;

#[CoversClass(TypeDefinition::class)]
#[CoversFunction(TypeDefinition::class . '::__construct')]
#[CoversFunction(TypeDefinition::class . '::getField')]
#[CoversFunction(TypeDefinition::class . '::getFields')]
#[CoversFunction(TypeDefinition::class . '::setFields')]
#[CoversFunction(TypeDefinition::class . '::addField')]
#[CoversFunction(TypeDefinition::class . '::getFieldNames')]
class TypeDefinitionTest extends PhodamBaseTestCase
{
    #[Test]
    #[TestDox('Default constructor creates empty definition')]
    public function testDefaultConstructor(): void
    {
        $def = new TypeDefinition();

        $this->assertIsArray($def->getFields());
        $this->assertEmpty($def->getFields());
        $this->assertIsArray($def->getFieldNames());
        $this->assertEmpty($def->getFieldNames());
    }

    #[Test]
    #[TestDox('Constructor with fields sets fields in definition')]
    public function testConstructorWithFields(): void
    {
        $field1 = new FieldDefinition(SimpleType::class);
        $field2 = new FieldDefinition(SimpleType::class);
        $fields = [
            'field1' => $field1,
            'field2' => $field2
        ];

        $def = new TypeDefinition($fields);

        $this->assertIsArray($def->getFields());
        $this->assertCount(2, $def->getFields());
        $this->assertEquals($fields, $def->getFields());
        $this->assertSame($field1, $def->getFields()['field1']);
        $this->assertSame($field2, $def->getFields()['field2']);
    }

    #[Test]
    #[TestDox('Set fields sets fields in definition')]
    public function testSetFields(): void
    {
        $def = new TypeDefinition();

        $field1 = new FieldDefinition(SimpleType::class);
        $field2 = new FieldDefinition(SimpleType::class);
        $fields = [
            'field1' => $field1,
            'field2' => $field2
        ];

        $result = $def->setFields($fields);

        $this->assertInstanceOf(TypeDefinition::class, $result);
        $this->assertSame($def, $result);
        $this->assertCount(2, $def->getFields());
        $this->assertEquals($fields, $def->getFields());
    }

    #[Test]
    #[TestDox('Add field adds field to definition')]
    public function testAddField(): void
    {
        $def = new TypeDefinition();

        $field1 = new FieldDefinition(SimpleType::class);
        $field2 = new FieldDefinition(SimpleType::class);

        $result1 = $def->addField('field1', $field1);
        $result2 = $def->addField('field2', $field2);

        $this->assertInstanceOf(TypeDefinition::class, $result1);
        $this->assertInstanceOf(TypeDefinition::class, $result2);
        $this->assertSame($def, $result1);
        $this->assertSame($def, $result2);
        $this->assertCount(2, $def->getFields());
        $this->assertSame($field1, $def->getFields()['field1']);
        $this->assertSame($field2, $def->getFields()['field2']);
    }

    #[Test]
    #[TestDox('Get field names returns array of field names when fields are added')]
    public function testGetFieldNames(): void
    {
        $def = new TypeDefinition();

        $this->assertIsArray($def->getFieldNames());
        $this->assertEmpty($def->getFieldNames());

        $field1 = new FieldDefinition(SimpleType::class);
        $field2 = new FieldDefinition(SimpleType::class);
        $field3 = new FieldDefinition(SimpleType::class);

        $def->addField('field1', $field1);
        $def->addField('field2', $field2);
        $def->addField('field3', $field3);

        $fieldNames = $def->getFieldNames();
        $this->assertIsArray($fieldNames);
        $this->assertCount(3, $fieldNames);
        $this->assertContains('field1', $fieldNames);
        $this->assertContains('field2', $fieldNames);
        $this->assertContains('field3', $fieldNames);
    }

    #[Test]
    #[TestDox('Get field returns field when field exists')]
    public function testGetField(): void
    {
        $field1 = new FieldDefinition(SimpleType::class);
        $field2 = new FieldDefinition(SimpleType::class);
        $fields = [
            'field1' => $field1,
            'field2' => $field2
        ];

        $def = new TypeDefinition($fields);

        $this->assertSame($field1, $def->getField('field1'));
        $this->assertSame($field2, $def->getField('field2'));
    }

    #[Test]
    #[TestDox('Get field throws exception when field not found')]
    public function testGetFieldThrowsExceptionWhenFieldNotFound(): void
    {
        $def = new TypeDefinition();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unable to find field by name: nonexistent');

        $def->getField('nonexistent');
    }
}

