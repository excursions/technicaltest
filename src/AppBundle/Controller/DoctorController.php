<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Patient;
use AppBundle\Form\Type\PatientType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use AppBundle\Entity\Doctor;

/**
 * @Route("/doctor")
 */
class DoctorController extends Controller
{
    /**
     * @Route(
     *     "/{doctor_id}/add",
     *     name="app_doctor_add_patient",
     *     requirements={"doctor_id"="\d+"}
     * )
     * @ParamConverter("doctor", class="AppBundle\Entity\Doctor", converter="doctor_param_converter")
     * @Method({"POST"})
     *
     * @param Request $request
     * @param Doctor $doctor
     * @return JsonResponse
     */
    public function addPatientAction(Request $request, Doctor $doctor = null)
    {
        if (!$doctor) {
            $this->createNotFoundResponse("No such doctor in this hospital");
        }

        $patient = $this->processForm($request);

        if ($patient) {
            $doctor->addPatient($patient);

            return $this->createSuccessResponse($doctor);
        }

        return $this->createInvalidDataResponse();
    }

    /**
     * @param Request $request
     *
     * @return Patient|null
     */
    protected function processForm(Request $request)
    {
        $patient = new Patient();

        if ($request->request->has('hospital_id')) {
            $id = $request->request->get('hospital_id');
            $hospital = $this->get('app.repository.hospital_repository')->selectById($id);
            $patient->setHospital($hospital);
        }

        $form = $this->createForm(PatientType::class);
        $form->setData($patient);

        $submittedData = $request->get($form->getName());
        $form->submit($submittedData);
        
        if ($form->isValid()) {
            return $form->getData();
        }

        return null;
    }

    /**
     * @param string $msg
     *
     * @return JsonResponse
     */
    protected function createNotFoundResponse($msg) {
        return new JsonResponse(['msg' => $msg], 404);
    }

    /**
     * @param Doctor $doctor
     *
     * @return JsonResponse
     */
    protected function createSuccessResponse(Doctor $doctor)
    {
        return new JsonResponse(
            [
                'doctor' => $doctor,
                'patients' => $doctor->getPatients(),
                'msg' => ''
            ]
        );
    }

    /**
     * @return JsonResponse
     */
    protected function createInvalidDataResponse()
    {
        return new JsonResponse(['msg' => 'Cannot add patient to doctor'], 400);
    }
}
