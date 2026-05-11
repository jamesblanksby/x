<?php

namespace Platform\Module\Admin\Controller;

use Framework\Http\Request\Request;
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

    public function new(): Response
    {
        return $this->render('admin/template/user/user.form', [
            'types' => [], // @TODO
        ]);
    }

    public function insert(Request $request): Response
    {
        $input = $request->input->all();

        $user = $this->userService->insert($input);

        $redirect = $this->generateUrl('admin.user.edit', [
            'user' => $user['uid'],
            'redirect' => $request->query->get('redirect'),
        ]);

        return $this->respond([
            'success' => true,
            'text' => 'User successfully created',
            'redirect' => $redirect,
        ]);
    }

    public function edit(string $user): Response
    {
        $user = $this->userService->get($user, 'uid');

        return $this->render('admin/template/user/user.form', [
            'types' => [], // @TODO
            'user' => $user,
        ]);
    }

    public function update(Request $request, string $user): Response
    {
        $input = $request->input->all();

        $user = $this->userService->get($user, 'uid');
        $this->userService->update($user, $input);

        $redirect = $this->generateUrl('admin.user.edit', [
            'user' => $user['uid'],
            'redirect' => $request->query->get('redirect'),
        ]);

        return $this->respond([
            'text' => 'User successfully updated',
            'redirect' => $redirect,
        ]);
    }

    public function delete(string $user): Response
    {
        $user = $this->userService->get($user, 'uid');
        $this->userService->delete($user);

        return $this->respond([
            'success' => true,
            'text' => 'User successfully deleted',
            'reload' => true,
        ]);
    }
}
