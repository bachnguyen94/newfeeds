<?php

namespace System\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{

    /**
     * Copy data
     *
     * Queries: 'model', 'from_group', 'to_group'
     */
    public function copy()
    {
        $model = $this->request->query('model');
        $fromGroup = $this->request->query('from_group');
        $toGroup = $this->request->query('to_group');
        if (!$fromGroup || !$toGroup || !$model) {
            $this->Flash->error('Missed params');
            $this->redirect($this->referer());
        }

        $this->loadModel($model);
        switch ($model) {
            case 'Menus':
                $this->Menus->copyMenu($fromGroup, $toGroup);
                $this->redirect(['action' => 'index', $toGroup]);
            break;
            case 'UserAuths':
                $this->loadModel('Users');
                $this->Users->copyAuths($fromGroup, $toGroup);
                $this->redirect($this->referer());
                break;
            default:
                die('Please define this action in: System.App::copy()');
                break;
        }
    }
}
