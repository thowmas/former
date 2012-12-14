<?php
class FileTest extends FormerTests
{
  // Matchers ------------------------------------------------------ /

  public function matchFile($accept = null)
  {
    return array(
      'tag' => 'input',
      'id' => 'foo',
      'attributes' => array(
        'type' => 'file',
        'name' => 'foo',
        'accept' => $accept,
      ),
    );
  }

  public function matchHidden($size)
  {
    return array(
      'tag' => 'input',
      'attributes' => array(
        'type' => 'hidden',
        'name' => 'MAX_FILE_SIZE',
        'value' => $size,
      ),
    );
  }

  // Tests --------------------------------------------------------- /

  public function testCanCreateAFileField()
  {
    $file = $this->former->file('foo')->__toString();

    $this->assertControlGroup($file);
    $this->assertHTML($this->matchFile(), $file);
  }

  public function testCanCreateAMultipleFilesField()
  {
    $file = $this->former->files('foo')->__toString();
    $matcher = $this->controlGroup(
      '<input multiple="true" type="file" name="foo[]" id="foo[]">',
      '<label for="foo[]" class="control-label">Foo</label>');

    $this->assertEquals($matcher, $file);
  }

  public function testCanCustomizeAcceptedFormats()
  {
    $file = $this->former->file('foo')->accept('video', 'image', 'audio', 'jpeg', 'image/gif')->__toString();

    $this->assertControlGroup($file);
    $this->assertHTML($this->matchFile('video/*|image/*|audio/*|image/jpeg|image/gif'), $file);
  }

  public function testCanSetMaxSizeInKilobytes()
  {
    $file = $this->former->file('foo')->max(1, 'KB')->__toString();

    $this->assertControlGroup($file);
    $this->assertHTML($this->matchFile(), $file);
    $this->assertHTML($this->matchHidden('1024'), $file);
  }

  public function testCanSetMaxSizeInMegabytes()
  {
    $file = $this->former->file('foo')->max(2, 'MB')->__toString();

    $this->assertControlGroup($file);
    $this->assertHTML($this->matchFile(), $file);
    $this->assertHTML($this->matchHidden('2097152'), $file);
  }

  public function testCanSetMaxSizeInGigabytes()
  {
    $file = $this->former->file('foo')->max(1, 'GB')->__toString();

    $this->assertControlGroup($file);
    $this->assertHTML($this->matchFile(), $file);
    $this->assertHTML($this->matchHidden('1073741824'), $file);
  }

  public function testCanSetMaxSizeInBits()
  {
    $file = $this->former->file('foo')->max(1, 'Mb')->__toString();

    $this->assertControlGroup($file);
    $this->assertHTML($this->matchFile(), $file);
    $this->assertHTML($this->matchHidden('131072'), $file);
  }

  public function testCanSetMaxSizeInOctets()
  {
    $file = $this->former->file('foo')->max(2, 'Mo')->__toString();

    $this->assertControlGroup($file);
    $this->assertHTML($this->matchFile(), $file);
    $this->assertHTML($this->matchHidden('2097152'), $file);
  }
}