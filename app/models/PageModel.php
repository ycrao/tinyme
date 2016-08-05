<?php

/**
 * PageModel
 */
class PageModel extends Model
{

    protected $_table = 'tm_page';

    public function getPageById($id)
    {
        return $this->_db->get($this->_table, '*', [
            'id' => $id
            ]);
    }

}
