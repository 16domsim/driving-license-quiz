<?php 
class Question
{
	private const IMAGE_TEXT = "Abb.";
	
	private $questionText = null;
	private $imageFilename = null;
	private $answers = null;
	
  public function __construct(
    $questionText,
    $imageFilename,
    $answers) {
    $this->questionText = $questionText;
    $this->imageFilename = $imageFilename;
    $this->answers = $answers;
  }

	public function getQuestionText() {
		return $this->questionText;
	}

	public function getImageFilename() {
		return $this->imageFilename;
	}

	public function getAnswers() {
		return $this->answers;
	}
	
	public function getAnswered() {
	  foreach ($this->answers as $key =>$value){
	      if (!$value->getAnswered())
	      return false;
	  }
	  return true;
	}
	
	/**
	 * Liefert den Dateinamen des Bildes ohne Erweiterung zur�ck und erg�nzt ihn 
	 * am Beginn durch das Wort Abb.
	 */
	public function getImageText() {
	  $ret = null;
	  if (isset($this->imageFilename))
	    $ret = self::IMAGE_TEXT . " " . substr($this->imageFilename, 0, strpos($this->imageFilename,".jpg"));
	  return $ret;
	}
}