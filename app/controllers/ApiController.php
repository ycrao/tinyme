<?php


/**
 * Api Controller
 */
class ApiController
{

    /**
     * api response (normal success)
     *
     * @param  array   $data
     * @param  integer $code Using 200 when success
     * @param  string  $msg
     * @return Flight\response json
     */
    private static function _api($data = [], $msg = 'OK', $code = 200)
    {
        $response = ['code' => $code, 'msg' => $msg, 'data' => $data];
        return Flight::json($response);
    }

    /**
     * api response (fail or error)
     *
     * @param  string  $msg
     * @param  integer $code Using non-2xx in fail or error case
     * @param  array   $data
     * @return Flight\response json
     */
    private static function _error($msg = 'fail', $code = 500, $data = [])
    {
        if ($code == 200) {
            $code = 500;
        }
        return self::_api($data, $msg, $code);
    }

    /**
     * authorize token
     *
     * @return \AppException|int If success will return current user id
     */
    private static function _auth()
    {
        $access_token = Flight::request()->getVar('HTTP_AUTHORIZATION', null);
        if (empty(trim($access_token))) {
            throw new \AppException('fail to authenticate access token!', 403);
        } else {
            $access_token = trim(str_replace('Bearer ', '', $access_token));
            $check = Flight::model('Token')->checkToken($access_token);
            if ($check) {
                $token = Flight::model('Token')->getTokenByToken($access_token);
                return $uid = $token['uid'];
            } else {
                // access token expired
                throw new \AppException('access token already expired, please recall `/api/login` !', 401);
            }
        }
    }

    /**
     * login
     *
     * Please recall login api when token is expired, do not call this api frequently when old token(s) not expired
     *
     * @return Flight\response json
     */
    public static function login()
    {
        $email = Flight::request()->data['email'];
        $password = Flight::request()->data['password'];
        if (empty($email) || empty($password)) {
            return self::_error('missing params!');
        }
        $uid = Flight::model('User')->loginByCredentials($email, $password);
        if ($uid > 0) {
            $token = str_rand(42);
            $expire_at = time() + env('API_TIME_EXPIRE', 3600);
            Flight::model('Token')->insertToken($uid, $token, $expire_at);
            $data = [
                'uid'       => $uid,
                'token'     => $token,
                'expire_at' => $expire_at,
            ];
            return self::_api($data);
        } else {
            return self::_error('illegal or incorrect credentials', 403);
        }
    }

    /**
     * getOwnPages
     *
     * Get current user own pages
     *
     * @return Flight\response json
     */
    public static function getOwnPages()
    {
        try {
            $uid = self::_auth();
            $per_page = Flight::request()->query['per_page'];
            $page = Flight::request()->query['page'];
            $pages = Flight::model('Page')->getUserPages($uid, $per_page, $page);
            return self::_api($pages);
        } catch (\AppException $e) {
            return self::_error($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            return self::_error($e->getMessage());
        }
    }

    /**
     * createPage
     *
     * @return Flight\response json
     */
    public static function createPage()
    {
        try {
            $uid = self::_auth();
            $content = Flight::request()->data['content'];
            if (empty(trim($content))) {
                // try to get POST raw data
                $body = json_decode(Flight::request()->getBody(), true);
                if (isset($body['content']) && !empty($body['content'])) {
                    $content = $body['content'];
                } else {
                    return self::_error('missing params or empty content!');
                }
            }
            $page_id = Flight::model('Page')->createPage($uid, $content);
            if ($page_id) {
                return self::_api(['result' => 'create success!', 'view_url' => '/api/page/'.$page_id]);
            } else {
                return self::_error('fail to create page!');
            }
        } catch (\AppException $e) {
            return self::_error($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            return self::_error($e->getMessage());
        }
    }

    /**
     * getPage
     *
     * @param  int $id
     * @return Flight\response json
     */
    public static function getPage($id)
    {
        try {
            $id = (int) $id;
            $uid = self::_auth();
            $page = Flight::model('Page')->getPageById($id);
            if ($page) {
                if ($page['uid'] == $uid) {
                    return self::_api($page);
                } else {
                    return self::_error('forbidden, you have no right to view this page!', 403);
                }
            } else {
                return self::_error('page not found!', 404);
            }
        } catch (\AppException $e) {
            return self::_error($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            return self::_error($e->getMessage());
        }
    }

    /**
     * updatePage
     *
     * @param  int $id
     * @return Flight\response json
     */
    public static function updatePage($id)
    {
        try {
            $id = (int) $id;
            $uid = self::_auth();
            $page = Flight::model('Page')->getPageById($id);
            if ($page) {
                if ($page['uid'] == $uid) {
                    // hijack PUT method by passing `_method=put` parameter with POST
                    $content = Flight::request()->data['content'];
                    if (empty(trim($content))) {
                        // try to get PUT raw data
                        $body = json_decode(Flight::request()->getBody(), true);
                        if (isset($body['content']) && !empty($body['content'])) {
                            $content = $body['content'];
                        } else {
                            return self::_error('missing params or empty content!');
                        }
                    }
                    Flight::model('Page')->updatePage($id, $content, $uid);
                    return self::_api(['result' => 'update success!']);
                } else {
                    return self::_error('forbidden, you have no right to update this page!', 403);
                }
            } else {
                return self::_error('page not found!', 404);
            }
        } catch (\AppException $e) {
            return self::_error($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            return self::_error($e->getMessage());
        }
    }


    /**
     * deletePage
     *
     * @param  int $id
     * @return Flight\response
     */
    public static function deletePage($id)
    {
        try {
            $id = (int) $id;
            $uid = self::_auth();
            $page = Flight::model('Page')->getPageById($id);
            if ($page) {
                if ($page['uid'] == $uid) {
                    Flight::model('Page')->deletePage($uid, $id);
                    return self::_api(['result' => 'delete success!']);
                } else {
                    return self::_error('forbidden, you have no right to delete this page!', 403);
                }
            } else {
                return self::_error('page not found!', 404);
            }
        } catch (\AppException $e) {
            return self::_error($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            return self::_error($e->getMessage());
        }
    }
}
