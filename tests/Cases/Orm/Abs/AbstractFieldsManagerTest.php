<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @date 10/04/16 10:14
 */

namespace Phact\Tests\Cases\Orm\Abs;

use Modules\Test\Models\Note;
use Modules\Test\Models\NoteThesis;
use Phact\Orm\Fields\AutoField;
use Phact\Orm\Fields\CharField;
use Phact\Orm\Fields\ForeignField;
use Phact\Orm\FieldsManager;
use Phact\Tests\Templates\DatabaseTest;

abstract class AbstractFieldsManagerTest extends DatabaseTest
{
    public function testGetters()
    {
        $note = new Note();
        $fieldsManager = $note->getFieldsManager();
        $has = $fieldsManager->hasField('name');
        $field = $fieldsManager->getField('name');

        $this->assertInstanceOf(FieldsManager::class, $fieldsManager);
        $this->assertTrue($has);
        $this->assertInstanceOf(CharField::class, $field);
    }
    
    public function testAliases()
    {
        $thesis = new NoteThesis();
        $manager = $thesis->getFieldsManager();
        $this->assertInstanceOf(ForeignField::class, $manager->getField('note'));
        $this->assertInstanceOf(ForeignField::class, $manager->getField('note_id'));
    }

    public function testValue()
    {
        $thesis = new NoteThesis();
        $thesis->note_id = 1;
        $this->assertEquals(1, $thesis->note_id);
        $this->assertNull($thesis->getAttribute('note'));
        $this->assertEquals(1, $thesis->getAttribute('note_id'));

        $this->assertNull($thesis->name);
        $this->assertNull($thesis->getAttribute('name'));

        $thesis->name = 'foo';

        $this->assertEquals('foo', $thesis->name);
        $this->assertEquals('foo', $thesis->getAttribute('name'));
    }

    public function testAutoField()
    {
        $note = new Note();
        $manager = $note->getFieldsManager();
        $this->assertTrue($manager->has('id'));
        $this->assertInstanceOf(AutoField::class, $manager->getField('id'));
    }
}