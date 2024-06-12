<?php 
class Answer
{
	private $answerText = null;
	private $correct = false;
	private $answerSelected = false;
	private $answered = false;
	
	public function __construct($answerText, $correct) {
		$this->answerText = $answerText;
		$this->correct = $correct;
	}
	
	public function getAnswerText(){
		return $this->answerText;
	}
	
	public function getCorrect() {
		return $this->correct;
	}
	
	public function setAnswerSelected($answerSelected) {
	    if(!isset($answerSelected))
	        $answerSelected=false;
		$this->answerSelected = $answerSelected;
		$this->answered = true;
	}
	
	public function getAnswered() {
	  return $this->answered;
	}
	
	public function getAnswerSelected() {
		return $this->answerSelected;
	}
	
	public function getPoints() {
		return $this->answered && $this->correct == $this->answerSelected ? 1 : 0;
	}
}
