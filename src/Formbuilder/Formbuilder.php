<?php

namespace Modules\Addons;

use Modules\Addons\Formbuilder\Install\Installer;

class Formbuilder
{
    public function popup($body) {
        ob_start();
        include 'popup.php';
        return ob_get_clean();
    }

    public function install()
    {
        require_once 'install/Installer.php';

        $installer = new Installer();
        $installer->run();
    }

    public function duplicate() {

        global $argv;

        $form_to_duplicate = db()->table('iris_formulieren')
            ->select()
            ->find($argv[2]);

        if (!$form_to_duplicate) {
            exit;
        }

        unset(
            $form_to_duplicate['id'],
            $form_to_duplicate['hash'],
            $form_to_duplicate['bevestiging_ontvanger_veld'],
            $form_to_duplicate['modified']
        );

        $duplicated_form_id = db()->table('iris_formulieren')
            ->insert(array_merge($form_to_duplicate, [
                'hash' => sha1(time() * rand(1, 999)),
                'naam' => '[KOPIE] ' . output($form_to_duplicate['naam']),
                'created' => time(),
            ]))
            ->execute();


        $fields_to_duplicate = db()->table('iris_formulieren_velden')
            ->select()
            ->where('iris_formulieren_id', $argv[2])
            ->get();

        foreach ($fields_to_duplicate ?? [] as $field) {

            unset(
                $field['id'],
                $field['iris_formulieren_id'],
                $field['hash'],
                $field['modified']
            );

            db()->table('iris_formulieren_velden')
                ->insert(array_merge($field, [
                    'hash' => sha1(time() * rand(1, 999)),
                    'iris_formulieren_id' => $duplicated_form_id,
                    'created' => time(),
                ]))
                ->execute();

        }

        echo $this->popup('
            <h4 class="mb-4">Kopie is gemaakt</h4>
            <p>Ververs de pagina om de nieuwsbrief te zien.</a>                        
        ');
    }


}
