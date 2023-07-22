<?php 
	include 'class2.php';

	//Creating instances of the Person class
	$person1 = new Person(1, "Nikita", "Perepelov", "2004.06.04", 1, "Minsk");
	$person2 = new Person(2, "Dmitry", "Ivanov", "2003.10.09", 1, "New York");
	$person3 = new Person(3, "Anna", "Petrova", "2003.12.19", 0, "Minsk");

	echo $person1->Name." ".$person2->Name." ".$person3->Name."<br>";

	//Creating instance of the Person class only by ID
	$person4 = new Person(1);

	echo $person4->Name."<br>";

	//Example of deleting person by ID
	$person1->delete(1);

	//Example of saving fields method into database
	$person1->Id = 1;
	$person1->Name = "Oleg";
	$person1->Surname = "Sidorov";
	$person1->BirthDate = "1990.06.02";
	$person1->gender = 1;
	$person1->CityOfBirth = "Minsk";
	$person1->insert();

	echo $person1->Name."<br>";

	//Example of transforming date into age
	echo Person::getAge("2004.06.04")."<br>";

	//Example of transforming gender from bool to string
	echo Person::convertGeneder(1)."<br>";

	//Example of formatting person 
	echo $person1->formatting(true, false)->Gender."<br>";
    echo $person1->formatting(false, false)->Gender."<br>";
    echo $person1->formatting(false, true)->Age."<br>";
    echo $person1->formatting(false, false)->BirthDate."<br>";

    //Example of instance of the Persons class
    $conditions = array
	(
		"city_of_birth" => "Minsk"
	);

	$listOfPersons = new Persons($conditions);
	print_r($listOfPersons);
	echo "<br>";

	//Example of getting array of instances of Person class
	echo $listOfPersons->getArrayOfPersons()[0]->Name;

	//Example of deleting persons from database by instances of Person class

	$conditions = array
	(
		"name" => "Dmitry"
	);

	$listOfPersonsForDeleting = new Persons($conditions);
	$listOfPersonsForDeleting->deletingPersons();

	//Database clearing
	$conditions = array
	(
		"id" => ">0",
	);
	$listOfPersonsForFullClearing = new Persons($conditions);
	$listOfPersonsForFullClearing->deletingPersons();
?>