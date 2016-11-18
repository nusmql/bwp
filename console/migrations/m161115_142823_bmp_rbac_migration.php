<?php

use Yii;
use yii\db\Migration;

class m161115_142823_bmp_rbac_migration extends Migration
{
    public function up()
    {
        $auth = Yii::$app->adminAuthManager;

        $auth->removeAll();

        // // add "createCompany" permission
        // $createCompany = $auth->createPermission('crateCompany');
        // $createCompany->description = 'Create a company';
        // $auth->add($createCompany);


        // // update 'updateCompany' permission
        // $updateCompany = $auth->createPermission('updateCompany');
        // $updateCompany->description = 'Update a Company';
        // $auth->add($updateCompany);

        // // add admin role
        // $superAdmin = $auth->createRole('superAdmin');
        // $auth->add($superAdmin);
        // $auth->addChild($superAdmin, $createCompany);
        // $auth->addChild($superAdmin, $updateCompany);

    }

    public function down()
    {
        echo "m161115_142823_bmp_rbac_migration cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
