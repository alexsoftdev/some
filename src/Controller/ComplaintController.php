<?php

namespace App\Controller;

use App\DTO\ShortComplaintDto;
use App\Entity\Complaint;
use App\UseCase\CreateComplaint\CreateComplaintDto;
use App\UseCase\CreateComplaint\CreateComplaintHandler;
use App\UseCase\TakeComplaint\TakeComplaintDto;
use App\UseCase\TakeComplaint\TakeComplaintHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/complaint", name="complaint_")
 */
class ComplaintController extends AbstractFOSRestController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $clientId = $request->query->get('client_id');
        $offset = $request->query->get('offset');
        $limit = $request->query->get('limit');

        /** @var Complaint[] $complaints */
        $complaints = $em->getRepository(Complaint::class)->findBy(
            ['client' => $clientId],
            ['id'=>'desc'],
            $limit,
            $offset);

        $result = [];
        foreach( $complaints as $complaint ) {
            $result[] = ShortComplaintDto::fromComplaint($complaint);
        }

        return $this->handleView($this->view($result,Response::HTTP_CREATED));
    }


    /**
     * @Route("/{complaint}", name="show", methods={"GET"})
     * @param Complaint $complaint
     * @return Response
     */
    public function show(Complaint $complaint): Response
    {
        return $this->handleView($this->view(ShortComplaintDto::fromComplaint($complaint),Response::HTTP_ACCEPTED));
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     *
     * @param CreateComplaintHandler $handler
     * @param CreateComplaintDto $dto
     *
     * @return Response
     *
     * @ParamConverter("dto", converter="fos_rest.request_body")
     */
    public function create(CreateComplaintHandler $handler, CreateComplaintDto $dto): Response
    {
        $complaint = $handler->handle($dto);
        return $this->handleView($this->view(ShortComplaintDto::fromComplaint($complaint),Response::HTTP_CREATED));
    }

    /**
     * @Route("/{complaint}/take", name="take", methods={"POST"})
     * @param Complaint $complaint
     * @param TakeComplaintHandler $handler
     * @return Response
     */
    public function take(Complaint $complaint, TakeComplaintHandler $handler): Response
    {
        $dto = new TakeComplaintDto();
        $dto->setComplaint($complaint);
        $complaint = $handler->handle($dto);
        return $this->handleView($this->view(ShortComplaintDto::fromComplaint($complaint),Response::HTTP_ACCEPTED));
    }

}
