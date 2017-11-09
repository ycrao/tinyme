<?php

/**
 * PageModel
 */
class PageModel extends Model
{
    /**
     * pages table name
     * @var string
     */
    protected $_table = 'tm_pages';

    /**
     * getPageById
     * 
     * @param  int $id
     * @return array
     */
    public function getPageById($id)
    {
        return $this->_db->get($this->_table, ['id', 'content', 'created_at', 'updated_at'], [
            'id' => $id
        ]);
    }

    /**
     * getUserPages
     * 
     * @param  int  $uid
     * @param  integer $per_page
     * @param  integer $page
     * @return array
     */
    public function getUserPages($uid, $per_page = 10, $page = 1)
    {
        $per_page = (int) $per_page;
        if ($per_page <= 0 || $per_page > 100) {
            $per_page = 10;
        }

        $total_count = $this->_db->count($this->_table, [
            'uid' => $uid,
        ]);

        $total = ceil($total_count/$per_page);
        $current_page = (int) $page;
        if ($current_page <= 0) {
            $current_page = 1;
        }
        $next_page_url = ($total >= $current_page) ? '/api/pages/?page='.($current_page + 1).'&per_page='.$per_page : null;
        $prev_page_url = ($current_page == 1 || $total == 0) ? null : '/api/pages/?page='.($current_page - 1).'&per_page='.$per_page;
        $data = $this->_db->select($this->_table, ['id', 'content', 'created_at', 'updated_at'], [
            'uid'   => $uid,
            'ORDER' => [
                'id' => 'DESC',
            ],
            'LIMIT' => [10*($current_page - 1), $per_page],
        ]);
        $from = $to = null;
        if ($data) {
            $from = $data[0]['id'];
            $to = $data[count($data)-1]['id'];
        } else {
            $data = [];
        }

        // pagination like laravel
        return [
            'total'         => (int) $total,  // total page, nothing will return 0
            'per_page'      => (int) $per_page,  // item mumber per page
            'current_page'  => $current_page,  // current page
            'next_page_url' => $next_page_url,  // no next page will return null
            'prev_page_url' => $prev_page_url,  // no prev page will return null
            'from'          => $from,  // current page first item id, no item id will return null
            'to'            => $to,  // current page last item id, no item id will return null
            'data'          => $data,  // no data will return empty array []
        ];
    }

    /**
     * insertPage
     *
     * @param  int $uid
     * @param  string $content
     * @return int
     */
    public function createPage($uid, $content)
    {
        $now = date('Y-m-d H:i:s');
        return $this->_db->insert($this->_table, [
            'uid'        => $uid,
            'content'    => $content,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    /**
     * updatePage
     *
     * @param  int $uid
     * @param  string $content
     * @return int
     */
    public function updatePage($id, $content, $uid)
    {
        $now = date('Y-m-d H:i:s');
        return $this->_db->update($this->_table, [
            'content'    => $content,
            'updated_at' => $now,
        ], [
            'id'  => $id,
            'uid' => $uid,
        ]);
    }

    /**
     * deletePage
     *
     * @param  int $uid
     * @param  int $id
     * @return int
     */
    public function deletePage($uid, $id)
    {
        return $this->_db->delete($this->_table, [
            'AND' => [
                'uid' => $uid,
                'id'  => $id
            ]
        ]);
    }
}
