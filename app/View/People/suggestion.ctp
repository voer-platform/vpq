<div class = 'suggestion' id = 'container'>
	<div id = "performance" class = "sugesstion">
            <p class = 'hint'>Your overall performance: </p>
            <p id = 'performance_value'>66%</p>
            <p>You do not performed well on these...</p>
            <table align="center">
            <?php
            	echo $this->HTML->tableHeaders(array('Grade', 'Category', 'SubCategory', 'Performance'));
            	echo $this->HTML->tableCells(array('10', 'Physics', 'Classic Mechanics', '30%'));
            	echo $this->HTML->tableCells(array('11', 'Physics', 'Optics', '42%'));
            	echo $this->HTML->tableCells(array('10', 'Physics', 'Thermodynamics', '52%'));
            	echo $this->HTML->tableCells(array('10', 'Physics', 'Newton\'s Laws', '58%'));
            	echo $this->HTML->tableCells(array('12', 'Physics', 'Faraday\'s Law', '65%'));
            ?>
            </table>

    <div id = 'material' style="float:left;width:50%;"> 
    <p>Try to read these material</p>
    <table align="center" style="width;100%">
   	<?php
    echo $this->HTML->tableHeaders(array('Source', 'Category', 'Tags', 'Name'));
	echo $this->HTML->tableCells(array('VOER', 'Physics', 'Classic Mechanics, grade 10, beginner', 'College Physics, chapter 4'));
    echo $this->HTML->tableCells(array('VOER', 'Physics', 'Classic Mechanics, grade 10, beginner', 'College Physics, chapter 4'));
    echo $this->HTML->tableCells(array('VOER', 'Physics', 'Classic Mechanics, grade 10, beginner', 'College Physics, chapter 4'));
    echo $this->HTML->tableCells(array('VOER', 'Physics', 'Classic Mechanics, grade 10, beginner', 'College Physics, chapter 4'));  
    ?>     
    </table>  
    </div>
    <p>Try to do these test</p>
   	<table align="center" style="width = 100%;">
   	<?php
    echo $this->HTML->tableHeaders(array('Grade', 'Category', 'SubCategory', 'Difficulty', 'TestID'));
	echo $this->HTML->tableCells(array('10', 'Physics', 'Classic Mechanics', 'Fair', '11020399'));
	echo $this->HTML->tableCells(array('10', 'Physics', 'Classic Mechanics', 'hard', '11020399'));
	echo $this->HTML->tableCells(array('10', 'Physics', 'Classic Mechanics', 'Insane', '11020399'));
	echo $this->HTML->tableCells(array('10', 'Physics', 'Optics', 'Intermidiate', '11020399'));
	echo $this->HTML->tableCells(array('10', 'Physics', 'Classic Mechanics', 'Fair', '11020399'));
    ?>     
    </table>   	  
    <div id = 'tests' style="">        
    </div>
    
</div>