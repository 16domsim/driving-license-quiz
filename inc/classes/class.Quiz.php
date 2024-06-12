<?php
require_once 'inc/classes/class.Answer.php';
require_once 'inc/classes/class.Question.php';

class Quiz
{

    /*
     * Konstanten
     */
    public const QUESTIONS_COUNT = 10;

    public const ANSWERS_COUNT = 3;

    public const MINIMUM_PERCENT = 86.6666;

    /**
     * Hier wird die Fragenummer der aktuellen Frage gemerkt.
     * Die Fragen werden
     * mit 0 beginnend nummeriert
     */
    private $actualQuestionNumber = - 1;

    /**
     * Hier wird gemerkt, ob das Quiz fertiggestellt bzw.
     * abgegeben wurde
     */
    private $completed = false;

    /**
     * Enth�lt die f�r das Quiz ausgew�hlten Fragen
     */
    private $questions = null;

    /*
     * Konstruktoren
     */
    /**
     * Legt Quiz an und holt sich dabei Fragen zuf�llig aus der Datenbank
     * und schreibt diese in das Fragen-Array hinein
     */
    public function __construct()
    {
            $this->questions = array();
            $key = - 1;
            $questiontext = null;
            $imageFileName = null;
            $con = new mysqli("localhost", "a", "", "quiz", 8080);
            if ($con->connect_errno) {} else {
                $query = "SELECT *
                        FROM fargen
                        ORDER BY RAND () LIMIT ?";
                $stmp = $con->prepare($query);
                if ($con->errno) {
                    trigger_error($con->error, E_USER_WARNING);
                } else {
                    $questionCount =0;
                    $stmp->bind_param("i", $questionCount);
                    $questionCount= Quiz::QUESTIONS_COUNT;
                    $stmp->execute();
                    $stmp->store_result();
                    $stmp->bind_result($key, $questiontext, $imageFileName);

                    while ($stmp->fetch()) {
                        $answers = array();
                        $keytwo = - 1;
                        $answertext = null;
                        $correct = null;
                        $contwo = new mysqli("localhost", "a", "", "quiz", 8080);
                        if ($contwo->connect_errno) {} else {
                            $query = "SELECT antwortnummer, antworttext, richtig
                        FROM antworten
                        WHERE antwortnummer = ?
                        ORDER BY RAND () LIMIT ?";
                            $stmptwo = $contwo->prepare($query);
                            if ($contwo->errno) {
                                trigger_error($contwo->error, E_USER_WARNING);
                            } else {
                                
                                $answerCount =0;
                    
                                $stmptwo->bind_param("ii", $key, $answerCount);
                                $answerCount=Quiz::ANSWERS_COUNT;
                                $stmptwo->execute();
                                $stmptwo->store_result();
                                $stmptwo->bind_result($keytwo, $answertext, $correct);

                                while ($stmptwo->fetch()) {
                                    $answers[] = new Answer(utf8_encode($answertext), $correct);
                                }
                                $stmptwo->close();
                            }
                            $contwo->close();
                        }
                        $this->questions[] = new Question(utf8_encode($questiontext), $imageFileName, $answers);
                    }
                    $stmp->close();
                }
                $con->close();
            }
    }

    /**
     * Liefert die Nummer der aktuellen Frage zur�ck
     *
     * @return
     */
    public function getActualQuestionNumber()
    {
        return $this->actualQuestionNumber;
    }

    /**
     * Setzt die Nummer der aktuellen Frage
     *
     * @param
     */
    public function setActualQuestionNumber($actualQuestionNumber)
    {
        if ($actualQuestionNumber >= 0 && $actualQuestionNumber < Quiz::QUESTIONS_COUNT)
            $this->actualQuestionNumber = $actualQuestionNumber;
    }

    /**
     * Springt zur n�chsten Frage die zur aktuellen Frage wird
     *
     * @return
     */
    public function nextQuestion()
    {
        if ($this->actualQuestionNumber + 1 < Quiz::QUESTIONS_COUNT)
            $this->actualQuestionNumber ++;
    }

    /**
     * Springt zur vorigen Frage die zur aktuellen Frage wird
     *
     * @return
     */
    public function previousQuestion()
    {
        if ($this->actualQuestionNumber - 1 >= 0)
            $this->actualQuestionNumber --;
    }

    /**
     * Liefert die Anzahl der Fragen des Quiz zur�ck
     *
     * @return
     */
    public function getNumberQuestions()
    {
        return count($this->questions);
    }

    /**
     * Liefert die aktuelle Frage zur�ck
     *
     * @return
     */
    public function getActualQuestion()
    {
        return $this->questions[$this->actualQuestionNumber];
    }

    /**
     * Liefert true zur�ck, falls nach der aktuellen Frage noch eine weitere
     * Frage im Quiz existiert
     *
     * @return
     */
    public function getHasNextQuestion()
    {
        if ($this->actualQuestionNumber + 1 < Quiz::QUESTIONS_COUNT)
            return true;
        return false;
    }

    /**
     * Liefert true zur�ck, falls vor der aktuellen Frage noch eine Frage
     * im Quiz vorhanden ist
     *
     * @return
     */
    public function getHasPreviousQuestion()
    {
        if ($this->actualQuestionNumber - 1 >= 0)
            return true;
        return false;
    }

    /**
     * Liefert die ganzen Fragen des Quiz zur�ck
     *
     * @return
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Liefert die Anzahl der beantworteten Fragen des Quiz zur�ck
     *
     * @return
     */
    public function getNumberAnsweredQuestions()

    {
        $ret = 0;
        foreach ($this->questions as $key => $value) {
            if ($value->getAnswered())
                $ret ++;
        }
        return $ret;
    }

    /**
     * Liefert die Anzahl der nicht beantworteten Fragen des Quiz zur�ck
     *
     * @return
     */
    public function getNumberUnansweredQuestions()
    {
        $ret = 0;
        foreach ($this->questions as $key => $value) {
            if (! $value->getAnswered())
                $ret ++;
        }
        return $ret;
    }

    /**
     * Das Quiz wird fertiggestellt
     *
     * @param
     */
    public function setCompleted($completed)
    {
        if (isset($completed)) {
            $this->completed = $completed;
        }
    }

    /**
     * Kontrolliert ob das Quiz fertiggestellt wurde
     *
     * @return
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Liefert die Anzahl der richtig gesetzten Antwortm�glichkeiten zur�ck.
     * F�r
     * jede richtige Antwort wird ein Punkt vergeben
     *
     * @return
     */
    public function getPoints()
    {
        $ret = 0;
        foreach ($this->questions as $key => $value) {
            foreach ($value->getAnswers() as $keyTwo => $valueTwo)
                $ret += $valueTwo->getPoints();
        }
        return $ret;
    }

    /**
     * Liefert die insgesamt m�glichen Punkte zur�ck.
     * Pro Antwortm�glichkeit wird
     * ein Punkt vergeben
     *
     * @return
     */
    public function getMaximalPoints()
    {
        return Quiz::QUESTIONS_COUNT * Quiz::ANSWERS_COUNT;
    }

    /**
     * Ermittelt die Anzahl der richtig gesetzten Antworten in Prozent gerundet auf 2
     * Kommastellen
     *
     * @return
     */
    public function getPointsInPercent()
    {
        return round(100* $this->getPoints() / $this->getMaximalPoints(), 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Liefert zur�ck ob das Quiz bestanden wurde oder nicht.
     * Ein Quiz kann nur
     * bestanden werden, falls es fertiggestellt wurde und falls MINIMUM_PERCENT
     * der Punkte erzielt werden konnten
     *
     * @return
     */
    public function getPassed()
    {
        if ($this->completed && $this->getPointsInPercent() >= Quiz::MINIMUM_PERCENT)
            return true;
        return false;
    }
}
