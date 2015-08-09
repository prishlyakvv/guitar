<?php

namespace src\Controllers\Backend;

use src\Controllers\Backend\Component\NotifyComponent;
use src\Controllers\Backend\Component\TopMenuComponent;
use src\Form\LoginFormType;
use src\Models\Users;

class DefaultBackendController extends MainBackendController {

    public function indexAction() {

        $component = new TopMenuComponent($this);
        $componentResp = $component->toString();

        $componentNotify = new NotifyComponent($this);
        $componentNotifyResp = $componentNotify->toString();

        $sess = $this->getApp()->getSession();

        if ($this->getRequestParam('exit', false)) {
            $sess->set('login_id', null);
            $sess->set('login_name', null);
            $this->redirect('backend_index');
        }

        $username = '';
        if (!$sess->getByName('login_id') || !$sess->getByName('login_name')) {
            $formUser = new LoginFormType($this->getApp(), $this);
            if ($_POST) {
                if ($formUser->fillAndIsValid()) {
                    $tblUser = new Users($this->getApp());
                    $login = $tblUser->login($formUser->getData());
                    if (isset($login['id']) && isset($login['name'])) {
                        $sess->set('login_id', $login['id']);
                        $sess->set('login_name', $login['name']);
                        $this->redirect('backend_index');
                    } else {
                        $formUser->addError('Неверные данные');
                    }
                }
            }
            $formLogin = $formUser->render();
        } else {
            $formLogin = false;
            $username = $sess->getByName('login_name');
        }



        $this->render(array(
            'componentMenu' => $componentResp,
            'formLogin' => $formLogin,
            'username' => $username,
            'componentNotify' => $componentNotifyResp,
        ), 'Backend/Default/index.html');

    }

} 