<?php

class User
{
    private $id_employee;
    private $id_user;
    private $type_user;
    private $name_employee;
    private $lastName_employee;
    private $jobTitle_employee;
    private $departament_employee;
    private $isBoss_employee;
    private $isDirector_employee;


    // constructor
    public function __construct($id_employee, $id_user, $type_user, $name_employee, $lastName_employee, $jobTitle_employee, $departament_employee, $isBoss_employee, $isDirector_employee)
    {
        $this->id_employee = $id_employee;
        $this->id_user = $id_user;
        $this->type_user = $type_user;
        $this->name_employee = $name_employee;
        $this->lastName_employee = $lastName_employee; 
        $this->jobTitle_employee = $jobTitle_employee; 
        $this->departament_employee = $departament_employee; 
        $this->isBoss_employee = $isBoss_employee; 
        $this->isDirector_employee = $isDirector_employee;
    }

    // getters
    public function getIdEmployee()
    {
        return $this->id_employee;
    }
    public function getIdUser()
    {
        return $this->id_user;
    }
    public function getIdUserType()
    {
        return $this->type_user;
    }
    public function getNameEmployee()
    {
        return $this->name_employee;
    }
    public function getLastNameEmployee()
    {
        return $this->lastName_employee;
    }
    public function getJobTitleEmployee()
    {
        return $this->jobTitle_employee;
    }
    public function getDepartamentEmployee()
    {
        return $this->departament_employee;
    }
    public function getIsBossEmployee()
    {
        return $this->isBoss_employee;
    }
    public function getIsDirectorEmployee()
    {
        return $this->isDirector_employee;
    }


    // setters
    public function setIdEmployee($id_employee)
    {
        $this->id_employee = $id_employee;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function setIdUserType($type_user)
    {
        $this->type_user = $type_user;
    }

    public function setNameEmployee($name_employee)
    {
        $this->name_employee = $name_employee;
    }

    public function setLastNameEmployee($lastName_employee)
    {
        $this->lastName_employee = $lastName_employee;
    }
    public function setJobTitleEmployee($jobTitle_employee)
    {
        $this->jobTitle_employee = $jobTitle_employee;
    }
    public function setDepartamentEmployee($departament_employee)
    {
        $this->departament_employee = $departament_employee;
    }
    public function setIsBossEmployee($isBoss_employee)
    {
        $this->isBoss_employee = $isBoss_employee;
    }
    public function setIsDirectorEmployee($isDirector_employee)
    {
        $this->isDirector_employee = $isDirector_employee;
    }

}
?>