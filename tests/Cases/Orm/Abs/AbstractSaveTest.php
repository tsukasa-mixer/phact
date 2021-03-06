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
use Phact\Tests\Templates\DatabaseTest;

abstract class AbstractSaveTest extends DatabaseTest
{
    public function useModels()
    {
        return [
            new Note(),
            new NoteThesis()
        ];
    }

    public function testInsert()
    {
        $note = new Note();
        $note->name = "Test";
        $note->save();

        $noteThesis = new NoteThesis();
        $noteThesis->name = 'Test note thesis';
        $noteThesis->note = $note;
        $noteThesis->save();

        $this->assertInstanceOf(Note::class, $noteThesis->note);
        $this->assertEquals($note->id, $noteThesis->note->id);
        $this->assertEquals("Test", $note->name);
        $this->assertEquals("Test note thesis", $noteThesis->name);
    }

    public function testUpdate()
    {
        $note = new Note();
        $note->name = "Test";
        $note->save();

        $fetched = Note::objects()->filter([
            'id' => $note->id
        ])->get();

        $this->assertEquals("Test", $fetched->name);

        $fetched->name = "New test";
        $fetched->save();

        $updated = Note::objects()->filter([
            'id' => $fetched->id
        ])->get();

        $this->assertEquals("New test", $updated->name);
    }
}