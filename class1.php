<?php 
	class Person
	{
    	public int $Id;
    	public string $Name;
    	public string $Surname;
    	public string $BirthDate;
    	public bool $Gender;
    	public string $CityOfBirth;

        public function __construct(int $Id)
        {
            include "DB.php";

            if (func_num_args()>1) {

                $this->Id = $Id;
                $this->Name = func_get_arg(1);
                $this->Surname = func_get_arg(2);
                $this->BirthDate = func_get_arg(3);
                $this->Gender = func_get_arg(4);
                $this->CityOfBirth = func_get_arg(5);

                if (preg_match("/[0-9]/", $this->Name)) {
                    echo "Name mustn't contain numbers";
                }
                else if (preg_match("/[0-9]/", $this->Surname)) {
                    echo "Surname mustn't contain numbers";
                }
                else if (!preg_match("/^\d{4}.\d{2}.\d{2}$/", $this->BirthDate)) {
                    echo "Birth day format must be yyyy.mm.dd";
                }
                elseif (preg_match("/[0-9]/", $this->CityOfBirth)) {
                    echo "City mustn't contain numbers";
                }
                else
                {
                    if ($this->Gender) 
                    {
                        $query=mysqli_query($connection,"insert into person values ($this->Id, '$this->Name', '$this->Surname', '$this->BirthDate', true, '$this->CityOfBirth');");
                    }
                    else
                    {
                        $query=mysqli_query($connection,"insert into person values ($this->Id, '$this->Name', '$this->Surname', '$this->BirthDate', false, '$this->CityOfBirth');");
                    }
                }
            }
            else
            {
                $result = mysqli_query($connection, "SELECT id, name, surname, birthday_date, gender, city_of_birth FROM person where id=$Id");
                $row = mysqli_fetch_array($result);
                $this->Id = $row['id'];
                $this->Name = $row['name'];
                $this->Surname = $row['surname'];
                $this->BirthDate = $row['birthday_date'];
                $this->Gender = $row['gender'];
                $this->CityOfBirth = $row['city_of_birth'];
            }
        }

    	public function insert() 
        {
            include "DB.php";

        	$query=mysqli_query($connection,"insert into person values ($this->Id, '$this->Name', '$this->Surname', '$this->BirthDate', $this->Gender, '$this->CityOfBirth');");
    	}

        public function delete(int $id)
        {
            include "DB.php";

            $query=mysqli_query($connection,"delete from Person where Id = $id");
        }

        public static function getAge(string $BirthDate)
        {
            $dateTimeBirthday = date_create_from_format('Y.m.d', $BirthDate);
            $dateTimeNow = new DateTime('now');
            $interval = $dateTimeNow->diff($dateTimeBirthday);

            return $interval->y;
        }

        public static function convertGeneder(bool $gender)
        {
            if ($gender) {
                return 'man';
            }
            else
            {
                return 'woman';
            }
        }

        public function formatting(bool $genderBoolOrString, bool $birthDateAgeOrDate)
        {
            $formattedPerson = new stdClass();
            
            $formattedPerson->Name = $this->Name;
            $formattedPerson->Surname = $this->Surname;
            if ($birthDateAgeOrDate) 
            {
                $formattedPerson->Age = Person::getAge($this->BirthDate);
            } 
            else 
            {
                $formattedPerson->BirthDate = $this->BirthDate;
            }
            if ($genderBoolOrString) 
            {
                $formattedPerson->Gender = Person::convertGeneder($this->Gender); 
            }
            else
            {
                $formattedPerson->Gender = $this->Gender;
            }
            $formattedPerson->CityOfBirth = $this->CityOfBirth;
            return $formattedPerson;
        }
	}
 ?>