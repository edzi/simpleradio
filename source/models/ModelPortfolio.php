<?php
namespace radio\models;
use radio\classes\Broadcast;
use radio\core\Model;
use radio\classes\DataBase;

/**
 * Created by PhpStorm.
 * User: littl
 * Date: 24.04.2018
 * Time: 17:19
 */

class ModelPortfolio extends Model
{
    public function get_data()
    {
        $DB = new DataBase();
        $DB->setClassName('Broadcast');
        $sql = 'SELECT `id`, `name`, `id_employee` FROM Broadcast';
        $result = $DB->query($sql);
        $data = [];
        if (!empty($result)) {
            /** @var Broadcast $ObjectBroadcast */
            foreach ($result as $ObjectBroadcast) {
                $data[] = [
                    'id' => $ObjectBroadcast->getId(),
                    'name' => $ObjectBroadcast->getName(),
                    'id_employee' => $ObjectBroadcast->getIdEmployee(),
                ];
            }
        }
        return $data;
    }

}