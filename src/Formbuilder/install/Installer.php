<?php

namespace Modules\Addons\Formbuilder\Install;

class Installer
{
    private $needed;
    private $conn;

    public function __construct()
    {
        if (php_sapi_name() != 'cli') {

            $this->needed = ['iris_formulieren_velden', 'iris_formulieren'];
            $this->conn = new \mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

            if ($this->conn->connect_error) {
                dd('Connection failed: ' . $this->conn->connect_error);
            }

        }
    }

    public function run()
    {
        self::tables();
        self::data();
        self::components();
        self::destroy($_SERVER['DOCUMENT_ROOT'] . '/modules/Addons/Formbuilder/install');
    }

    public function tables()
    {
        $current_tables = array_column(raw('SHOW TABLES'), 'Tables_in_' . $_ENV['DB_NAME']);

        foreach ($this->needed ?? [] as $needed) {

            if (isset($current_tables[$needed])) { continue; }

            $statement = file_get_contents(__dir__ . '/tables/'.$needed.'.sql');
            $this->conn->query($statement);

        }
    }

    public function data()
    {
        foreach ($this->needed ?? [] as $needed) {

            if (isset($current_tables[$needed])) { continue; }

            $file = __dir__ . '/data/'.$needed.'.sql';

            if (!file_exists($file)) { continue; }

            $statement = file_get_contents($file);
            $this->conn->query($statement);

        }
    }

    public function components()
    {
        $current_components = db('iris')->table('componenten')
            ->select(['id', 'table_name'])
            ->where('table_name', 'like', 'iris_formulieren%')
            ->where('domein_id', $_ENV['DOMAIN_ID'])
            ->get();

        $current_components = array_keyBy('table_name', $current_components);

        $inserted_ids = [];

        foreach ($this->needed ?? [] as $needed) {

            if (isset($current_components[$needed])) { continue; }

            $file = __dir__ . '/components/'.$needed.'.json';

            if (!file_exists($file)) { continue; }

            $component = file_get_contents($file);

            $component = str_replace(['{DOMAIN_ID}', '{PARENT_ID}'], [$_ENV['DOMAIN_ID'], ($inserted_ids['iris_formulieren_velden'] ?? null)], $component);

            $component = json_decode($component, true);

            $data_to_insert = [];

            foreach ($component ?? [] as $k => $v) {
                $data_to_insert[$k] = (gettype($v) == 'array' ? json_encode($v) : $v);
            }

            $inserted_ids[$needed] = db('iris')->table('componenten')
                ->insert($data_to_insert)
                ->execute();

        }
    }

    public function destroy($dir)
    {
        if (is_dir($dir)) {

            $objects = scandir($dir);

            foreach ($objects ?? [] as $object) {

                if (in_array($object, ['.', '..'])) { continue; }

                if (filetype($dir . '/' . $object) == 'dir') {
                    self::destroy($dir . '/' . $object);
                } else {
                    unlink($dir . '/' . $object);
                }

            }

            reset($objects);
            rmdir($dir);
        }
    }
}