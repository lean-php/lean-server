<?php

namespace App\Controller\Admin;

use App\Service\CustomerRepository;
use Lean\Controller\ControllerTrait;
use Psr\SimpleCache\CacheInterface;

class CustomerController
{
    use ControllerTrait;

    private $customerRepository;
    private $cache;

    public function __construct(CustomerRepository $customerRepository, CacheInterface $cache)
    {
        $this->customerRepository = $customerRepository;
        $this->cache = $cache;
    }

    public function nocache()
    {
        $date = date('d.m.Y H:i:s');
        $customers = $this->customerRepository->getAll();
        $response = $this->render('admin/customer/list', ['customers' => $customers, 'date' => $date]);

        $this->container->get('app.kernel')->addAsyncTask(function () use ($customers) {

            file_put_contents('/tmp/customer.xml', '<customers></customers>');

        });

        $this->container->get('app.kernel')->addAsyncTask(CustomerController::class.'::incRequestCount');
        $this->container->get('app.kernel')->addAsyncTask([$this,'cleanupData']);

        return $response;
    }

    public function datacache()
    {
        $date = $this->cache->get('date', null);
        $customers = $this->cache->get('customers', null);

        if ($date === null) {
            $date = date('d.m.Y H:i:s');
            $this->cache->set('date', $date, 30);
        }
        if ($customers === null) {
            $customers = $this->customerRepository->getAll();
            $this->cache->set('customers', $customers, 30);
        }

        $response = $this->render('admin/customer/list', ['customers' => $customers, 'date' => $date]);

        return $response;
    }

    public function browsercache()
    {
        $date = date('d.m.Y H:i:s');
        $customers = $this->customerRepository->getAll();
        $response = $this->render('admin/customer/list', ['customers' => $customers, 'date' => $date]);

        $response->setPrivate();
        $response->setMaxAge(30);

        return $response;
    }

    public function outputcache()
    {
        $date = date('d.m.Y H:i:s');
        $customers = $this->customerRepository->getAll();
        $response = $this->render('admin/customer/list', ['customers' => $customers, 'date' => $date]);

        $response->setSharedMaxAge(20);
        return $response;
    }

    public function cleanupData()
    {
        file_put_contents('/tmp/log.txt', 'Cleanup', FILE_APPEND);
    }

    public static function incRequestCount() {
        file_put_contents('/tmp/log.txt', 'incRequest', FILE_APPEND);
    }
}
