<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;


class RbacController extends Controller
{
	public function actionIndex()
	{

                $auth = \Yii::$app->adminAuthManager;

                // $auth->removeAll();

        // add "createCompany" permission
                $createCompany = $auth->createPermission('createCompany');
                $createCompany->description = 'Create a company';
                $auth->add($createCompany);


        // update 'updateCompany' permission
                $updateCompany = $auth->createPermission('updateCompany');
                $updateCompany->description = 'Update a Company';
                $auth->add($updateCompany);


        // update 'viewCompany' permission
                $viewCompany = $auth->createPermission('viewCompany');
                $viewCompany->description = 'Vew a Company';
                $auth->add($viewCompany);


        // update 'updateCompany' permission
                $deleteCompany= $auth->createPermission('deleteCompany');
                $deleteCompany->description = 'Delete a Company';
                $auth->add($deleteCompany);


        // manageCompany permission
                $manageCompany = $auth->createPermission('manageCompany');
                $manageCompany->description = 'Manage a Company';
                $auth->add($manageCompany);


        // add "crateUser" permission
                $createUser = $auth->createPermission('createUser');
                $createUser->description = 'Create a User';
                $auth->add($createUser);


        // update 'updateUser' permission
                $updateUser = $auth->createPermission('updateUser');
                $updateUser->description = 'Update a User';
                $auth->add($updateUser);


        // update 'viewUser' permission
                $viewUser = $auth->createPermission('viewUser');
                $viewUser->description = 'Vew a User';
                $auth->add($viewUser);


        // update 'deleteUser' permission
                $deleteUser= $auth->createPermission('deleteUser');
                $deleteUser->description = 'Delete a User';
                $auth->add($deleteUser);


        // manageUser permission
                $manageUser = $auth->createPermission('manageUser');
                $manageUser->description = 'Manage a User';
                $auth->add($manageUser);


        // add user role
        // update 
                $user = $auth->createRole('user');
                $auth->add($user);
                $auth->addChild($user, $createCompany);
                $auth->addChild($user, $updateCompany);
                $auth->addChild($user, $viewCompany);
                $auth->addChild($user, $manageCompany);

                $auth->addChild($user, $createUser);
                $auth->addChild($user, $updateUser);
                $auth->addChild($user, $viewUser);
                $auth->addChild($user, $manageUser);


        // add admin role
                $admin = $auth->createRole('admin');
                $auth->add($admin);
                $auth->addChild($admin, $createCompany);
                $auth->addChild($admin, $updateCompany);
                $auth->addChild($admin, $viewCompany);
                $auth->addChild($admin, $manageCompany);
                $auth->addChild($admin, $deleteCompany);

                $auth->addChild($admin, $createUser);
                $auth->addChild($admin, $updateUser);
                $auth->addChild($admin, $viewUser);
                $auth->addChild($admin, $manageUser);
                $auth->addChild($admin, $deleteUser);

        // add super admin role
                $superAdmin = $auth->createRole('superAdmin');
                $auth->add($superAdmin);
                $auth->addChild($superAdmin, $admin);


                $auth->assign($user, 3);
                $auth->assign($superAdmin, 1);

        }
}