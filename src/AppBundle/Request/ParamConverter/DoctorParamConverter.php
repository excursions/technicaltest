<?php

namespace AppBundle\Request\ParamConverter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

use AppBundle\Entity\Doctor;
use AppBundle\Repository\DoctorRepository;

class DoctorParamConverter implements ParamConverterInterface
{
    /** @var DoctorRepository */
    private $doctorRepository;

    /**
     * @param DoctorRepository $doctorRepository
     */
    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $name = $configuration->getName();
        $objectId = $request->attributes->get('doctor_id');

        if (null === $objectId) {
            throw new \InvalidArgumentException('Route attribute is missing');
        }

        $object = $this->doctorRepository->selectById($objectId);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('%s object not found.', $configuration->getClass()));
        }

        $request->attributes->set($name, $object);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        if (null === $configuration->getClass()) {
            return false;
        }

        $class = $configuration->getClass();
        return $class === Doctor::class;
    }
}
