<?php
$quiz = $_SESSION["quiz"];
?>
<script type="text/javascript">
    function onFinishAnswerdedAllQuestions() {
        return confirm("Wollen Sie Ihr Fahrschulquiz beenden?");
    }

    function onFinishAnswerdedNotAllQuestions() {
        return confirm("Sie haben noch einige Fragen zu beantworten, wollen Sie Ihr Fahrschulquiz trotzdem beenden?");
    }

    function questionLink(questionnumber, navigateToNumber, finish, allQuestionMessage){
        wasTrue = false;
        if(finish==true){
        	wasTrue=true;
            finish = allQuestionMessage ? onFinishAnswerdedAllQuestions():onFinishAnswerdedNotAllQuestions();
        }
        if(!wasTrue||(wasTrue && finish)){
       	 	document.quizform.questionNumber.value = questionnumber;
        	document.quizform.navNumber.value = navigateToNumber;
        	document.quizform.finished.value = finish;
        	document.quizform.submit();
        }
        return false;
     }
    
</script>

<h1>Fahrschulquiz</h1>

<?php if(!isset($_SESSION["loginUsername"]))
        echo " <h4 align=\"center\" style=\"color:red \">Ihre Antworten werden nicht abgespeichert. Loggen Sie sich ein, wenn Sie das Quiz durchführen und auswerten lassen möchten!</h4>";
        ?>
        
       

        
<form method="post" name="quizform" action="../index.php?id=2"
	enctype="multipart/form-data">

	<input type="hidden" name="questionNumber"> 
	<input type="hidden"
		name="navNumber"> 
		<input type="hidden" name="finished">
	<table style="border: hidden; width: 100%">
		<tr>
			<td><input type="button" name="finish" value="Quiz ferigstellen" 
				onclick="<?php
    echo "return questionLink(" . $quiz->getActualQuestionNumber() . "," . $quiz->getActualQuestionNumber() . "," . true . "," . ($quiz->getNumberAnsweredQuestions() == Quiz::QUESTIONS_COUNT) . ")";
    ?> " <?php if(!isset($_SESSION["loginUsername"]))
        echo "disabled=\"disabled\"";
        ?>></td>
			<td>
				<table style="border: hidden;">
					<tr>
						<td>
		Beantwortet:
		<?php
if ($quiz->getNumberAnsweredQuestions() > 0) {
    foreach ($quiz->getQuestions() as $key => $value) {
        if ($value->getAnswered() === true) {
            echo "<a href = \"\" onclick=\"return questionLink(" . $quiz->getActualQuestionNumber() . "," . $key . "," . false . ") \" >" . ($key + 1) . "" . "</a> ";
        }
    }
} else {
    echo "Keine Beantwortete Fragen vorhanden";
}
?>
		</td>
					</tr>
					<tr>
						<td>
		Nicht Beantwortet:
		<?php
if ($quiz->getNumberUnansweredQuestions() > 0) {
    foreach ($quiz->getQuestions() as $key => $value) {
        if ($value->getAnswered() === false) {
            echo "<a href = \"\" onclick=\"return questionLink(" . $quiz->getActualQuestionNumber() . "," . $key . "," . false . ") \" >" . ($key + 1) . "" . "</a> ";
        }
    }
} else {
    echo "Sie haben alle Fragen beantwortet";
}
?>
		</td>
					</tr>
				</table>
			</td>
			<td align="right"><input type="button" name="previous"
				value="Vorige Frage"
				<?php if(!$quiz->getHasPreviousQuestion()) echo "disabled=\"disabled\"" ?>
				onclick="return questionLink(<?php echo $quiz->getActualQuestionNumber().",". ($quiz->getActualQuestionNumber()-1).",".false?>)">
				<input type="button" name="next " value="Nächste Frage"
				<?php if(!$quiz->getHasNextQuestion()) echo "disabled=\"disabled\"" ?>
				onclick="return questionLink(<?php echo $quiz->getActualQuestionNumber().",". ($quiz->getActualQuestionNumber()+1).",".false?>) "></td>
		</tr>
	</table>
	<hr color="black">
	<table style="border: hidden; width: 100%">
		<tr>
			<td style="font-weight: bold">
<?php echo "Frage ". ($quiz->getActualQuestionNumber()+1).""." von 10"?>
</td>
			<td align="right"><img
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
			<td>Antworten</td>
			<td align="right">Richtig</td>
			<td align="right">Falsch</td>
		</tr>
		<?php for($i=0;$i<Quiz::ANSWERS_COUNT;$i++){?>
		<tr>
			<td><?php echo ($quiz->getActualQuestion()->getAnswers()[$i]->getAnswerText())?></td>
			<td align="right"><input type="radio" name=<?php echo"answer".$i?>
				value="t"
				<?php
    if ($quiz->getActualQuestion()->getAnswers()[$i]->getAnswerSelected() && $quiz->getActualQuestion()->getAnswers()[$i]->getAnswered()) {
        echo "checked=\"checked\"";
    }
    ?>></td>
			<td align="right"><input type="radio" name=<?php echo"answer".$i?>
				value="f"
				<?php
    if (! $quiz->getActualQuestion()->getAnswers()[$i]->getAnswerSelected() && $quiz->getActualQuestion()->getAnswers()[$i]->getAnswered()) {
        echo "checked=\"checked\"";
    }
    ?>></td>
		</tr>
	<?php }?>
	</table>
	<hr color="black">
</form>
