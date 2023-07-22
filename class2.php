<?php 
	include 'class1.php';

	if (!class_exists('Person')) {
		echo "Class Person doesn't exist";
		exit();
	}

	class Persons
	{
		public $personsId = array();

		public function __construct(array $conditions)
        {
        	include 'DB.php';
        	$sql = "select id from person where 1";

        	foreach ($conditions as $condition => $value) 
        	{
        		$sql .= " and $condition";
        		if ($value[0] == ">") 
        		{
        			$sql .= " > '";
        			$sql .= mb_substr($value, 1);
        		}
        		else if($value[0] == "<")
        		{
					$sql .= " < '";
					$sql .= mb_substr($value, 1);
        		}
        		else if($value[0] == "!" && $value[1] == "=")
        		{
        			$sql .= " != '";
        			$sql .= mb_substr($value, 2);
        		}
        		else
        		{
        			$sql .= " = '".$value;
        		}
        		$sql .= "'";
        	}

        	$result=mysqli_query($connection, $sql);
        	while ($row = mysqli_fetch_array($result))
    		{
    			array_push($this->personsId, $row['id']);
    		}
		}

		public function getArrayOfPersons()
		{
			$personsArray = array();

			foreach ($this->personsId as $Id) {
				array_push($personsArray, new Person($Id));
			}

			return $personsArray;
		}

		public function deletingPersons()
		{
			foreach ($this->personsId as $Id) {
				$personForDeleting = new Person($Id);
				$personForDeleting->delete($Id);
			}
		}
	}

	//$conditions = array
	//(
		//"city_of_birth" => "Minsk",
	//);

	//$listOfPersons = new Persons($conditions);
	//$listOfPersons->deletingPersons();
	//print_r($listOfPersons->getArrayOfPersons());
?>