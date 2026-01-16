<?php

namespace app\models;


class Page extends Model
{
    public function getPages($uid, $page = 1, $perPage = 10)
    {
        $db = $this->db;
        
        $total = $db->count('tm_pages', ['uid' => $uid]);
        $offset = ($page - 1) * $perPage;
        
        $pages = $db->select('tm_pages', ['id', 'content', 'created_at', 'updated_at'], [
            'uid' => $uid,
            'LIMIT' => [$offset, $perPage],
            'ORDER' => ['id' => 'DESC']
        ]);

        $nextPage = ($page * $perPage < $total) ? $page + 1 : null;
        $prevPage = ($page > 1) ? $page - 1 : null;

        return [
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'next_page_url' => $nextPage ? "/api/pages/?page={$nextPage}&per_page={$perPage}" : null,
            'prev_page_url' => $prevPage ? "/api/pages/?page={$prevPage}&per_page={$perPage}" : null,
            'from' => $offset + 1,
            'to' => min($offset + $perPage, $total),
            'data' => $pages
        ];
    }

    public function create($uid, $content)
    {
        $db = $this->db;
        $now = date('Y-m-d H:i:s');
        
        $result = $db->insert('tm_pages', [
            'uid' => $uid,
            'content' => $content,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        return $db->id();
    }

    public function getById($id, $uid)
    {
        return $this->db->get('tm_pages', '*', [
            'id' => $id,
            'uid' => $uid
        ]);
    }

    public function update($id, $uid, $content)
    {
        $db = $this->db;
        $result = $db->update('tm_pages', [
            'content' => $content,
            'updated_at' => date('Y-m-d H:i:s')
        ], [
            'id' => $id,
            'uid' => $uid
        ]);

        return $result->rowCount() > 0;
    }

    public function delete($id, $uid)
    {
        $db = $this->db;
        $result = $db->delete('tm_pages', [
            'id' => $id,
            'uid' => $uid
        ]);

        return $result->rowCount() > 0;
    }
}
