<?php


class UserController
{
	public function httpGetMethod(Http $http)
	{

        $userSession = new UserSession();
        if($userSession->getAdmin() != 33)
        {
           $http->redirectTo('/user/login');
        }
        /*$userSession = new UserSession();
        if($userSession->isAuthenticated() == false)
        {
            // On ne peut pas réserver sans être connecté !
            $http->redirectTo('/user/login');
        }*/
        $userSession = new UserModel();
        $users = $userSession->selectAll();
		return [
         'users' => $users,   
         '_form' => new AdminUserForm() 
         ];
	}

	public function httpPostMethod(Http $http, array $formFields)
	{
        $userSession = new UserSession();
        if($userSession->getAdmin() != 33)
        {
           $http->redirectTo('/user/login');
        }

		try
		{
            /*$userSession = new UserSession();
            if($userSession->isAuthenticated() == false)
            {
                // On ne peut pas réserver sans être connecté !
                $http->redirectTo('/user/login');
            }*/

			// Inscription de l'utilisateur en tant qu'administrateur.
            $userAccountModel = new UserAccountModel();
            $userAccountModel->create
			(
				$formFields['email'],
				$formFields['password']
			);

            // Redirection vers le panneau d'administration.
            $http->redirectTo('/admin');
		}
		catch(DomainException $exception)
		{
            // Réaffichage du formulaire avec un message d'erreur.
            $form = new AdminUserForm();
            $form->bind($formFields);
            $form->setErrorMessage($exception->getMessage());

			return [ '_form' => $form ];
		}
	} 
}