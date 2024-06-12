<?php
$quiz = $_SESSION["quiz"];
$quiz->setCompleted(true);
?>


<h1>Fahrschulquiz</h1>
<table style="border: hidden; width: 100%">
	<tr>
		<td><h3>Auswertung</h3></td>
		<td align="right">
			<button onclick="location.href='index.php'">Neues Quiz erstellen</button>
		</td>

	</tr>
	<tr>
		<td>
		<?php
$max = $quiz->getMaximalPoints();
$userResult = $quiz->getPoints();
$userPercent = $quiz->getPointsInPercent();
$notpassedText = "";
if ($quiz->getPassed() == false)
    $notpassedText = " nicht";
echo "Von " . $max . " möglichkeiten haben Sie " . $userResult . " erreicht. Das sind " . $userPercent . " prozent. Sie haben den test" . $notpassedText . " bestanden."?>
		</td>
		<td align="right"></td>
	</tr>
</table>
<hr color="black">

<?php
$max = $quiz->getNumberQuestions();
for ($i = 0; $i < $max; $i ++) {
    ?>
<table style="border: hidden; width: 100%">
	<tr>
		<td style="font-weight: bold">
<?php echo "Frage ".($i+1)." von 10"?>
</td>
		<td align="right"><img alt=""
			src="<?php echo ($quiz->getActualQuestion()->getImageFilename())?>"></td>
	</tr>
	<tr>
		<td>
<?php echo ($quiz->getActualQuestion()->getQuestionText())?>
</td>
		<td align="right">
<?php echo ($quiz->getActualQuestion()->getImageText())?>
</td>
	</tr>

</table>
<hr color="black">
<table style="border: hidden; width: 100%">
	<tr>
		<td rowspan="2">Antworten</td>
		<td align="right" colspan="2">Ihre Antworten</td>
		<td align="right" colspan="2">Richtige Antworten</td>
		<td align="right" rowspan="2">Punkte</td>
	</tr>
	<tr>
		<td align="right">Richtig</td>
		<td align="right">Falsch</td>
		<td align="right">Richtig</td>
		<td align="right">Falsch</td>
	</tr>

	<tr>
			<?php for($j=0;$j<Quiz::ANSWERS_COUNT;$j++){?>
			<td><?php echo ($quiz->getQuestions()[$i]->getAnswers()[$j]->getAnswerText())?></td>
		<td align="right"><input type="radio"
			name="questionOne<?php echo $i.$j?>" value="true" disabled="disabled"
			<?php
			if ($quiz->getQuestions()[$i]->getAnswers()[$j]->getAnswerSelected()&& $quiz->getQuestions()[$i]->getAnswers()[$j]->getAnswered())
            echo "checked=\"checked\"";
        ?>></td>
		<td align="right"><input type="radio"
			name="questionOne<?php echo $i.$j?>" value="false" disabled="disabled"
			<?php
			if (! $quiz->getQuestions()[$i]->getAnswers()[$j]->getAnswerSelected()&& $quiz->getQuestions()[$i]->getAnswers()[$j]->getAnswered())
            echo "checked=\"checked\"";
        ?>></td>
		<td align="right"><input type="radio"
			name="questionOneRight<?php echo $i.$j?>" value="true"
			disabled="disabled"
			<?php
if ($quiz->getQuestions()[$i]->getAnswers()[$j]->getCorrect()||true)
            echo "checked=\"checked\"";
        ?>></td>
		<td align="right"><input type="radio"
			name="questionOneRight<?php echo $i.$j?>" value="false"
			disabled="disabled"
			<?php
if (! $quiz->getQuestions()[$i]->getAnswers()[$j]->getCorrect())
            echo "checked=\"checked\"";
        ?>></td>
		<td align="right"><?php
        echo $quiz->getQuestions()[$i]->getAnswers()[$j]->getPoints()?></td>
	</tr>
		<?php }?>		
	</table>
<hr color="black">
<?php }?>