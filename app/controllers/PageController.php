<?php

namespace app\controllers;

use app\models\Page;

class PageController extends ApiController
{
    protected int $uid;
    protected Page $pageModel;
    public function __construct($app) {
        parent::__construct($app);
        $this->pageModel = new Page($this->app->db());
        $this->uid = $this->app->get('authUid');
    }

    public function index()
    {
        $page = intval($this->app->request()->query->page ?? 1);
        $perPage = intval($this->app->request()->query->per_page ?? 10);

        $pages = $this->pageModel->getPages($this->uid, $page, $perPage);
        $this->return200($pages);
    }

    public function create()
    {
        // $rawData = file_get_contents('php://input');
        $rawData = $this->app->request()->getBody();
        $jsonData = json_decode($rawData, true);
        
        $content = $jsonData['content'] ?? $this->app->request()->data->content ?? '';

        if (empty($content)) {
            $this->return400('content is required');
            return;
        }
        $pageId = $this->pageModel->create($this->uid, $content);
        $this->return201([
            'result' => 'create success!',
            'view_url' => "/api/page/{$pageId}"
        ]);
    }

    public function show($id)
    {
        $page = $this->pageModel->getById($id, $this->uid);
        if (!$page) {
            $this->return404('Page not found');
            return;
        }
        $this->return200($page);
    }

    public function update($id)
    {
        // $rawData = file_get_contents('php://input');
        $rawData = $this->app->request()->getBody();
        $jsonData = json_decode($rawData, true);
        
        $content = $jsonData['content'] ?? $this->app->request()->data->content ?? '';

        if (empty($content)) {
            $this->return400('content is required');
            return;
        }

        $result = $this->pageModel->update($id, $this->uid, $content);

        if (!$result) {
            $this->return404('Page not found or update failed');
            return;
        }

        $this->return200(['result' => 'update success!']);
    }

    public function delete($id)
    {
        $result = $this->pageModel->delete($id, $this->uid);

        if (!$result) {
            $this->return404('Page not found or delete failed');
            return;
        }
        $this->return200(['result' => 'delete success!']);
    }
}
