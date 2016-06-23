<?php

namespace Sport\Auth\Controllers;

use Sport\Common\Controllers\BaseController as Controller;

use Sport\Auth\Models\User;

class HomeController extends Controller
{
	public function indexAction()
	{
		return $this->response->redirect('auth/home/signin');
	}

	public function signinAction()
	{
		if ($this->request->isPost()) {
			if ($this->security->checkToken()) {
				$username = $this->request->getPost('username');
				$password = $this->request->getPost('password');

				$user = User::findFirstByUsername($username);

				if ($user) {
					if ($this->security->checkHash($password, $user->password)) {
					}
					else
					{
						$this->flash->error("Wrong username or password! Please try again");
						return $this->response->redirect('auth/home/signin');
					}
				}
				else
				{
					$this->security->hash(rand());
				}
			}
		}
		$custom_js = [
			'partial'	=>	'signin_js',
			'params'	=>	[]
		];

		$this->addJavaScript($custom_js);
	}

	public function signUpAction()
	{
		if ($this->request->isPost()) {
			if ($this->security->checkToken()) {
				$user = new User();

				$user->first_name = $this->request->getPost('first_name');
				$user->last_name = $this->request->getPost('last_name');
				$user->email_address = $this->request->getPost('email_address');
				$user->username = $this->request->getPost('username');
				$user->password = $this->security->hash($this->request->getPost('password'));

				if ($user->save() == false) {
					foreach ($user->getMessages() as $message) {
						echo "Message: ", $message->getMessage();
						echo "Field: ", $message->getField();
						echo "Type: ", $message->getType();
					}die;
				}
				else
				{
					return $this->response->redirect('auth/home/completed');
				}
			}
		}

		$custom_js = [
			'partial'=>'signup_js',
			'params' => array()
		];
		$this->addJavaScript($custom_js);
	}

	function completedAction()
	{
		$custom_js = [
			'partial'	=>	'completed_js',
			'params'	=>	[]
		];

		$this->addJavaScript($custom_js);
	}


}