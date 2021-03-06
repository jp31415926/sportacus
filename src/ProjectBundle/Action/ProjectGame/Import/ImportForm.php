<?php
namespace Cerad\Bundle\ProjectBundle\Action\ProjectGame\Import;

use Psr\Http\Message\ServerRequestInterface as Request;

class ImportForm
{
  protected $data;
  protected $valid  = false;
  protected $posted = false;

  public function setData($data)
  {
    $this->data = $data;
  }
  public function getData()
  {
    return $this->data;
  }
  public function isValid() {
    return $this->valid;
  }
  public function handleRequest(Request $request)
  {
    if ($request->getMethod() !== 'POST') {
      return;
    }
    $this->posted = true;

    $post = $request->getParsedBody();
    $this->data['project'] = $post['project'];
    $this->data['update']  = isset($post['update']) ? true : false;

    $files = $request->getUploadedFiles();

    $this->data['file'] = isset($files['file']) ?  $files['file'] : null;
  //print_r($_FILES);die();
    if (!$this->data['file']) return;

    $this->valid = true;
  }
  public function render()
  {
    return <<<TYPEOTHER
<form action="/project-game/import" method="POST" enctype="multipart/form-data">
<label>Project
  <select name="project">
    <option value="20" selected>Fall 2015</option>
  </select>
</label><br/>
<label>Update Database
  <input type="checkbox" name="update"/>
</label><br/>
<label>Games
  <input type="file" name="file" required/>
</label><br/>
  <input type="submit" value="Import" name="import"/>
</form>
TYPEOTHER;
  }
}