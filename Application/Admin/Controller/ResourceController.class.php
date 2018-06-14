<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;

/**
 * 资源管理
 * Class ResourceController
 * @package Admin\Controller
 */
class ResourceController extends CommonController{
    // 资源列表
    public function ResourceList()
    {
        $resourceModel = M('resource');
        $dataRows = $resourceModel->select();
        if ($dataRows) {
            foreach ($dataRows as $key => $value) {
                $dataRows[$key]['statusTxt'] = $value['status'] == 1 ? '启用' : '禁用';
            }
        }
        $this->assign('dataRows',$dataRows);
        $this->display();
    }

    public function ArticleList()
    {
        $articleModel = M('resource_articles');
        $resourceModel = M('resource');
        $dataRows = $articleModel->select();
        if ($dataRows) {
            foreach ($dataRows as $key => $value) {

                if ($value['status'] == 1) {
                    $dataRows[$key]['statusTxt'] = '已采集';
                } elseif ($value['status'] == 2) {
                    $dataRows[$key]['statusTxt'] = '废弃';
                } elseif ($value['status'] == 3) {
                    $dataRows[$key]['statusTxt'] = '采集失败';
                } else {
                    $dataRows[$key]['statusTxt'] = '未使用';
                }

                $where = array('id' => $value['rid']);
                $dataRow = $resourceModel->where($where)->find();
                $dataRows[$key]['name'] = $dataRow['name'];
                $dataRows[$key]['wechatid'] = $dataRow['wechatid'];
                $dataRows[$key]['fbtimeTxt'] = date('Y-m-d H:i:s', $value['publish_time']);
            }
        }
        $this->assign('dataRows',$dataRows);
        $this->display();
    }

    // 文章列表采集
    public function GatherArticle()
    {
        $id = I('id');
        if ($id <= 0) {
            $this->error('参数传递错误');
        }
        $resourceModel = M('resource');
        $where = array('id' => $id);
        $dataRow = $resourceModel->where($where)->find();
        if (empty($dataRow)) {
            $this->error('参数传递错误');
        }
//        $url = 'http://api.shenjian.io/?appid=effb08ce37328e6ae5e8b9952c7c3126&weixinId='. urlencode($dataRow['wechatid']);
//        $result = self::curl($url);

//        file_put_contents('./1.txt', $result);
        $result = file_get_contents('./1.txt');
        $result = json_decode($result, true);
        if ($result['error_code'] !== 0) {
            $errorMessageArr = array();
            $errorMessageArr[101] = '没有该用户';
            $errorMessageArr[102] = '签名错误';
            $errorMessageArr[103] = 'AIP不存在';
            $errorMessageArr[104] = '调用太频繁';
            $errorMessageArr[105] = '请求并发数超过限制';
            $errorMessageArr[110] = '可调用次数不足';
            $errorMessageArr[111] = '请求IP不在白名单中';
            $errorMessageArr[112] = '当前账户余额为负或代表验证码扣费失败，请查看余额';
            $errorMessageArr[113] = '用户自定义退出';
            $errorMessageArr[114] = '没有返回数据';
            $errorMessageArr[500] = '其他错误类型，具体原因请看返回结果的错误原因';
            $this->error($errorMessageArr[$result['error_code']]);
        }

        $data = $result['data'];
        if (empty($data)) {
            $this->error('未知错误');
        }
        // 补充资源内容
        $setArr = array();
        $setArr['brief'] = $data['weixin_brief'];
        $setArr['body'] = $data['weixin_body'];
        $setArr['avatar'] = $data['weixin_avatar'];
        $resourceModel->where(array('id'=>$id))->save($setArr);

        // 资源文章列表添加
        $articles = $data['articles'];
        if (empty($articles)) {
            $this->error('未知错误');
        }

        foreach ($articles as $value) {
            $articleArr = array();
            $articleArr['rid'] = $id;
            $articleArr['article_url'] = $value['article_url'];
            $articleArr['article_title'] = $value['article_title'];
            $articleArr['article_brief'] = $value['article_brief'];
            $articleArr['article_thumbnail'] = $value['article_thumbnail'];
            $articleArr['publish_time'] = $value['article_publish_time'];
            $articleArr['status'] = 0;
            $articleArr['create_time'] = time();
            $articleModel = M('resource_articles');
            $articleModel->add($articleArr);
        }
        $this->success('采集成功');
    }

    // 采集文章内容
    public function GatherArticleContent()
    {
        $id = I('id');
        if ($id <= 0) {
            $this->error('参数传递错误');
        }
        $resourceModel = M('resource_articles');
        $where = array('id' => $id);
        $dataRow = $resourceModel->where($where)->find();
        if (empty($dataRow)) {
            $this->error('参数传递错误');
        }
        $url = 'http://api.shenjian.io/?appid=2b6d67df233857c9f14bee74bdd736b6&url=' . urlencode($dataRow['article_url']);
        $result = self::curl($url);
        file_put_contents('./2.txt', $result);
//        $result = file_get_contents('./2.txt');
        $result = json_decode($result, true);
        if ($result['error_code'] !== 0) {
            $errorMessageArr = array();
            $errorMessageArr[101] = '没有该用户';
            $errorMessageArr[102] = '签名错误';
            $errorMessageArr[103] = 'AIP不存在';
            $errorMessageArr[104] = '调用太频繁';
            $errorMessageArr[105] = '请求并发数超过限制';
            $errorMessageArr[110] = '可调用次数不足';
            $errorMessageArr[111] = '请求IP不在白名单中';
            $errorMessageArr[112] = '当前账户余额为负或代表验证码扣费失败，请查看余额';
            $errorMessageArr[113] = '用户自定义退出';
            $errorMessageArr[114] = '没有返回数据';
            $errorMessageArr[500] = '其他错误类型，具体原因请看返回结果的错误原因';
            $this->error($errorMessageArr[$result['error_code']]);
        }
        $data = $result['data'];
        if (empty($data)) {
            $this->error('未知错误');
        }


        $setArr = array();
        $setArr['uid'] = 1;
        $setArr['aid'] = $id;
        $setArr['u_type'] = 1;
        $setArr['art_name'] = $data['article_title'];
        $setArr['art_desc'] = $dataRow['article_brief'];
        $setArr['content'] = $data['article_content'];
        $setArr['resp_pic'] = $dataRow['article_thumbnail'];
        $setArr['source_url'] = $data['article_fixed_url'] ? $data['article_fixed_url'] : $dataRow['article_url'];
        $setArr['indate'] = date('Y-m-d');
        $setArr['intime'] = time();
        $setArr['status'] = 2;
        $articleModel = M('article');
        $result = $articleModel->add($setArr);
        if ($result) {
            $status = 1;
        } else {
            $status = 3;
        }

        $setArr = array();
        if ($data['article_fixed_url']) {
            $setArr['article_url'] = $data['article_fixed_url'];
        }
        $setArr['gather_time'] = time();
        $setArr['status'] = $status;
        $res = $resourceModel->where(array('id'=>$id))->save($setArr);
        if ($res) {
            $this->success('采集成功');
        } else {
            $this->success('采集失败');
        }
    }

    private function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}



?>