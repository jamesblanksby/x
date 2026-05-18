<?php

namespace Platform\Module\Admin\Controller;

use Framework\Http\Response\Response;
use Platform\Controller\AdminController;
use Platform\Domain\Service\UserService;

class UserController extends AdminController
{
    /** @var UserService */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function list(): Response
    {
        $users = $this->userService->all();

        return $this->render('admin/template/user/user.list', [
            'users' => $users,
        ]);
    }

    // @TODO insert/update

    public function delete(string $user): Response
    {
        $user = $this->userService->get($user, 'uid');
        $this->userService->delete($user);

        return $this->respond([
            'success' => true,
            'message' => 'User successfully deleted',
            'reload' => true,
        ]);
    }
}
