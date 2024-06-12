<?php
require_once 'inc/classes/class.Quiz.php';

const MAX_INACTIVITY_SECONDS = 1000;
session_start();
if (isset($_SESSION["lastActivity"]) && (time() - $_SESSION["lastActivity"]) > MAX_INACTIVITY_SECONDS)
    session_destroy();
$_SESSION["lastActivity"] = time();

require_once "scripts/scr.auth.php";
?>
<!DOCTYPE html>
<html>
<body bgcolor="lightgray">
		<?php
if (! isset($_SESSION["loginUsername"])) {
    ?>
    <aside style="float: right">
		<a href="index.php?id=100">Login</a>
	</aside>
	
	<?php } else { ?> 
	  <aside style="float: right">
		<a href="index.php?id=101">Logout</a>
	</aside>
		Sie sind eingeloggt als Benutzer 
		<?php
    echo $_SESSION["loginUsername"];
}
?>

<?php
if (! isset($_SESSION["quiz"]))
    $_SESSION["quiz"] = new Quiz();
$quiz = $_SESSION["quiz"];
if ($quiz->getCompleted()) {
    $_SESSION["quiz"] = new Quiz();
    $quiz = $_SESSION["quiz"];
}
if ($quiz->getActualQuestionNumber() == - 1)
    $quiz->setActualQuestionNumber(0);
$id = 0;
if (isset($_GET["id"]))
    $id = $_GET["id"];
if ($id == "0") {
    require_once 'scripts/src.quiz.php';
} else if ($id == "2") {
    $pos = filter_input(INPUT_POST, "questionNumber", FILTER_SANITIZE_NUMBER_INT);
    $nav = filter_input(INPUT_POST, "navNumber", FILTER_SANITIZE_NUMBER_INT);
    if (isset($_SESSION["loginUsername"])) {
        for ($i = 0; $i < Quiz::ANSWERS_COUNT; $i ++)
            $quiz->getQuestions()[$pos]->getAnswers()[$i]->setAnswerSelected(filter_input(INPUT_POST, "answer" . $i, FILTER_SANITIZE_STRING) == "t");
    }
    $quiz->setActualQuestionNumber($nav);
    if (filter_input(INPUT_POST, "finished", FILTER_SANITIZE_STRING) == "true")
        require_once 'scripts/src.correctansweroverview.php';
    else
        require_once 'scripts/src.quiz.php';
}
?>
</body>
</html>