<?php

class AdminController
{

    public function httpGetMethod(Http $http)
    {
    	$userSession = new UserSession();
        if($userSession->getAdmin() != 33)
        {
           $http->redirectTo('/user/login');
        }
    	$ordersModel = new OrderModel();
    	$orders = $ordersModel->listAll();
    	return
		[
			'orders' => $orders
		];

    }
}
