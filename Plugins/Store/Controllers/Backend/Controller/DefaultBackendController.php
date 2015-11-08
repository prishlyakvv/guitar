<?php

namespace Plugins\Store\Controllers\Backend\Controller;

use Plugins\Store\Controllers\Backend\Component\NotifyComponent;
use Plugins\Store\Controllers\Backend\Component\TopMenuComponent;
use Plugins\Store\Others\Form\LoginFormType;
use Plugins\Store\Models\Users;
use System\App;

class DefaultBackendController extends MainBackendController {

    public function indexAction() {

        $component = new TopMenuComponent($this);
        $componentResp = $component->toString();

        $componentNotify = new NotifyComponent($this);
        $componentNotifyResp = $componentNotify->toString();

        $sess = App::getInstance()->getSession();

        if ($this->getRequestParam('exit', false)) {
            $sess->set('login_id', null);
            $sess->set('login_name', null);
            $this->redirect('backend_index');
        }

        $username = '';
        if (!$sess->getByName('login_id') || !$sess->getByName('login_name')) {
            $formUser = new LoginFormType($this);
            if ($_POST) {

                $res = array();
                $res['redirect'] = false;
                if ($formUser->fillAndIsValid()) {
                    $tblUser = new Users();
                    $login = $tblUser->login($formUser->getData());
                    if (isset($login['id']) && isset($login['name'])) {
                        $sess->set('login_id', $login['id']);
                        $sess->set('login_name', $login['name']);
                        $res['redirect'] = true;
                    } else {
                        $formUser->addFormError('Неверные данные');
                    }
                }


                $res['form'] = $formUser->render();

                header('Content-Type: application/json');
                echo  json_encode($res);
                die;
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