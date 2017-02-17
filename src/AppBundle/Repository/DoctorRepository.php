<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Doctor;

class DoctorRepository implements RepositoryInterface
{
    /**
     * @param $id
     *
     * @return Doctor
     */
    public function selectById($id)
    {
        $doctor = new Doctor();
        $doctor->setName("Michael Phelps");

        return $doctor;
    }
}
