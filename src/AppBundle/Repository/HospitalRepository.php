<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Hospital;

class HospitalRepository implements RepositoryInterface
{
	/** @return Hospital */
	public function selectById($id)
	{
		return new Hospital();
	}
}
