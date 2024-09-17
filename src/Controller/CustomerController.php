<?php declare(strict_types=1);

namespace App\Controller;

use App\Model\Message;
use App\Service\Messenger;
use App\EntityRepository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class CustomerController extends AbstractController
{
    private $customerRepository;
    private $messenger;

    public function __construct(CustomerRepository $customerRepository, Messenger $messenger)
    {
        $this->customerRepository = $customerRepository;
        $this->messenger = $messenger;
    }

    /**
     *
     * @Route("/api/customer/{code}/notifications", name="customer_notifications", methods={"POST"})
     */
    public function notifyCustomer(string $code, Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset($requestData)) {
            return new Response('Invalid request data', Response::HTTP_BAD_REQUEST);
        }

        $customer = $this->customerRepository->findOneBy(['code' => $code]);

        if (!$customer) {
            return new Response('Customer not found', Response::HTTP_NOT_FOUND);
        }

        $message = new Message();
        $message->setBody($requestData['body']);
        $message->setType($customer->getNotificationType());

        $this->messenger->send($message);

        return new Response('Notification sent', Response::HTTP_OK);
    }
}