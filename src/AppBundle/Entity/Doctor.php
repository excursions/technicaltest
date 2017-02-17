<?php

namespace AppBundle\Entity;

class Doctor
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var Hospital */
    private $hospital;

    /** @var array|Patient[] */
    protected $patients;

    public function __construct()
    {
        $this->patients = [];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Patient[]|array
     */
    public function getPatients()
    {
        return $this->patients;
    }

    /**
     * @param Patient[]|array $patients
     */
    public function setPatients(array $patients)
    {
        $this->patients = $patients;
    }

    /**
     * @param Patient $patient
     *
     * @return $this
     */
    public function addPatient(Patient $patient)
    {
        if (in_array($patient, $this->patients)) {
            $this->patients[] = $patient;
        }

        return $this;
    }

    /**
     * @return Hospital
     */
    public function getHospital()
    {
        return $this->hospital;
    }

    /**
     * @param Hospital $hospital
     */
    public function setHospital(Hospital $hospital)
    {
        $this->hospital = $hospital;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
